// Sample product data
const products = [
    {
        id: 1,
        name: "Wireless Headphones",
        price: 199.99,
        category: "electronics",
        images: [
            "https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=500",
            "https://images.unsplash.com/photo-1583394838336-acd977736f90?w=500",
        ],
        description: "Premium wireless headphones with noise cancellation and crystal clear sound quality.",
        featured: true,
        rating: 4.5,
        reviews: 128
    },
    {
        id: 2,
        name: "Smart Watch",
        price: 299.99,
        category: "electronics",
        images: [
            "https://images.unsplash.com/photo-1546868871-7041f2a55e12?w=500",
            "https://images.unsplash.com/photo-1508685096489-7aacd43bd3b1?w=500",
        ],
        description: "Advanced smartwatch with health tracking and notifications.",
        featured: true,
        rating: 4.8,
        reviews: 89
    },
    {
        id: 3,
        name: "Designer T-Shirt",
        price: 49.99,
        category: "clothing",
        images: [
            "https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=500",
            "https://images.unsplash.com/photo-1503341504253-dff4815485f1?w=500",
        ],
        description: "Comfortable and stylish designer t-shirt made from premium cotton.",
        featured: false,
        rating: 4.2,
        reviews: 45
    },
    {
        id: 4,
        name: "Leather Wallet",
        price: 79.99,
        category: "accessories",
        images: [
            "https://images.unsplash.com/photo-1627123424574-724758594e93?w=500",
            "https://images.unsplash.com/photo-1627123424574-724758594e93?w=500",
        ],
        description: "Genuine leather wallet with multiple card slots and RFID protection.",
        featured: true,
        rating: 4.6,
        reviews: 67
    }
];

// Cart state
let cart = [];
let activeFilters = {
    categories: new Set(),
    maxPrice: 1000,
    sortBy: 'featured'
};

// DOM Elements
const productGrid = document.getElementById('productGrid');
const cartSidebar = document.getElementById('cartSidebar');
const cartItems = document.getElementById('cartItems');
const cartToggle = document.getElementById('cartToggle');
const closeCart = document.getElementById('closeCart');
const cartTotal = document.getElementById('cartTotal');
const cartCount = document.querySelector('.cart-count');
const priceRange = document.getElementById('priceRange');
const priceValue = document.getElementById('priceValue');
const sortSelect = document.getElementById('sortSelect');
const searchInput = document.querySelector('.search-input');

// Initialize the page
document.addEventListener('DOMContentLoaded', () => {
    setupEventListeners();
    setupCSRFToken();
});

// Setup CSRF Token for AJAX requests
function setupCSRFToken() {
    const token = document.querySelector('meta[name="csrf-token"]').content;
    window.axios = axios.create({
        headers: {
            'X-CSRF-TOKEN': token
        }
    });
}

// Event Listeners Setup
function setupEventListeners() {
    // Cart Toggle
    cartToggle?.addEventListener('click', toggleCart);
    closeCart?.addEventListener('click', toggleCart);

    // Filter Events
    document.querySelectorAll('.form-check-input').forEach(checkbox => {
        checkbox.addEventListener('change', handleCategoryFilter);
    });

    priceRange?.addEventListener('input', handlePriceFilter);

    // Sort Select
    sortSelect?.addEventListener('change', handleSort);

    // Search Input
    searchInput?.addEventListener('input', debounce(handleSearch, 300));

    // Add to Cart Buttons
    document.addEventListener('click', function(e) {
        if (e.target.closest('.add-to-cart-btn')) {
            const btn = e.target.closest('.add-to-cart-btn');
            addToCart(btn.dataset.productId);
        }
        if (e.target.closest('.view-details-btn')) {
            const btn = e.target.closest('.view-details-btn');
            showProductModal(btn.dataset.productId);
        }
    });
}

// Display Products
function displayProducts(products) {
    productGrid.innerHTML = products.map(product => `
        <div class="col-md-6 col-lg-4">
            <div class="product-card">
                <div class="product-image-wrapper">
                    <img src="${product.image_url}" alt="${product.name}" class="product-image">
                </div>
                <div class="product-details">
                    <div class="product-category">${product.category}</div>
                    <h3 class="product-title">${product.name}</h3>
                    <div class="product-rating">
                        <div class="stars" style="--rating: ${product.rating}"></div>
                        <span class="reviews">(${product.reviews} تقييم)</span>
                    </div>
                    <p class="product-price">${product.price} ج.م</p>
                    <div class="product-actions">
                        <button type="button" class="add-to-cart-btn" data-product-id="${product.id}">
                            <i class="fas fa-shopping-cart me-2"></i>أضف للسلة
                        </button>
                        <button type="button" class="view-details-btn" data-product-id="${product.id}">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    `).join('');
}

// Cart Functions
function toggleCart() {
    cartSidebar.classList.toggle('active');
}

function addToCart(productId, quantity = 1) {
    // Convert productId to number for proper comparison
    const numericProductId = parseInt(productId);
    const existingItem = cart.find(item => item.id === numericProductId);

    if (existingItem) {
        existingItem.quantity += quantity;
        updateCart();
        showToast('تم تحديث الكمية في السلة');
    } else {
        axios.get(window.appConfig.routes.products.details.replace('__id__', productId))
            .then(response => {
                const newItem = { ...response.data, quantity: quantity };
                // Ensure the ID is numeric
                newItem.id = numericProductId;
                cart.push(newItem);
                updateCart();
                showToast('تم إضافة المنتج إلى السلة');
            });
    }
}

function removeFromCart(productId) {
    cart = cart.filter(item => item.id !== productId);
    updateCart();
    showToast('تم حذف المنتج من السلة');
}

function updateCartItemQuantity(productId, newQuantity) {
    const item = cart.find(item => item.id === productId);
    if (item) {
        item.quantity = Math.max(1, newQuantity); // لا تسمح بكمية أقل من 1
        updateCart();
        showToast('تم تحديث الكمية');
    }
}

function updateCart() {
    cartItems.innerHTML = cart.map(item => `
        <div class="cart-item d-flex align-items-center p-3 border-bottom position-relative">
            <div class="cart-item-image me-3">
                <img src="${item.image_url}" alt="${item.name}" class="rounded" style="width: 80px; height: 80px; object-fit: cover;">
            </div>
            <div class="cart-item-content flex-grow-1">
                <h5 class="mb-2 fw-bold text-truncate">${item.name}</h5>
                <div class="d-flex flex-column">
                    <div class="quantity-controls mb-2">
                        <div class="input-group input-group-sm" style="width: 120px;">
                            <button type="button" class="btn btn-outline-primary"
                                onclick="updateCartItemQuantity(${item.id}, ${item.quantity - 1})">
                                <i class="fas fa-minus"></i>
                            </button>
                            <span class="form-control text-center border-primary" style="background: #f8f9fa;">
                                ${item.quantity}
                            </span>
                            <button type="button" class="btn btn-outline-primary"
                                onclick="updateCartItemQuantity(${item.id}, ${item.quantity + 1})">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="price-info">
                        <span class="text-primary fw-bold">${(parseFloat(item.price.replace(/[^0-9.-]+/g, '')) * item.quantity).toFixed(2)} ج.م</span>
                        <small class="text-muted me-2">(${item.price} × ${item.quantity})</small>
                    </div>
                </div>
            </div>
            <button type="button" class="btn btn-link text-danger position-absolute top-0 start-0 p-2"
                onclick="removeFromCart(${item.id})" style="background: none;">
                <i class="fas fa-times"></i>
            </button>
        </div>
    `).join('');

    const total = cart.reduce((sum, item) => {
        const price = parseFloat(item.price.replace(/[^0-9.-]+/g, ''));
        return sum + (price * item.quantity);
    }, 0);

    cartTotal.textContent = `${total.toFixed(2)} ج.م`;
    cartCount.textContent = cart.length;

    // إضافة رسالة عندما تكون السلة فارغة
    if (cart.length === 0) {
        cartItems.innerHTML = `
            <div class="text-center p-4">
                <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                <p class="text-muted">السلة فارغة</p>
            </div>
        `;
    }
}

// Filter Functions
function handleCategoryFilter(e) {
    const categoryId = e.target.value;
    if (e.target.checked) {
        activeFilters.categories.add(categoryId);
    } else {
        activeFilters.categories.delete(categoryId);
    }
    applyFilters();
}

function handlePriceFilter(e) {
    activeFilters.maxPrice = parseInt(e.target.value);
    priceValue.textContent = `${activeFilters.maxPrice.toLocaleString()} ج.م`;
    applyFilters();
}

function handleSort(e) {
    activeFilters.sortBy = e.target.value;
    applyFilters();
}

function handleSearch(e) {
    const searchTerm = e.target.value.toLowerCase();
    applyFilters(searchTerm);
}

function applyFilters(search = '') {
    const params = new URLSearchParams();

    if (activeFilters.categories.size > 0) {
        params.append('categories', Array.from(activeFilters.categories));
    }

    if (activeFilters.maxPrice) {
        params.append('price_limit', activeFilters.maxPrice);
    }

    if (activeFilters.sortBy) {
        params.append('sort', activeFilters.sortBy);
    }

    if (search) {
        params.append('search', search);
    }

    axios.get(`${window.appConfig.routes.products.filter}?${params.toString()}`)
        .then(response => {
            displayProducts(response.data.products);
        });
}

// Product Modal
function showProductModal(productId) {
    axios.get(window.appConfig.routes.products.details.replace('__id__', productId))
        .then(response => {
            const product = response.data;
            const modal = new bootstrap.Modal(document.getElementById('productModal'));

            // Update modal content
            document.getElementById('modalProductName').textContent = product.name;
            document.getElementById('modalProductDescription').textContent = product.description;
            document.getElementById('modalProductPrice').textContent = `${product.price} ج.م`;

            // Update carousel
            const carouselInner = document.querySelector('#productCarousel .carousel-inner');
            carouselInner.innerHTML = product.images.map((img, index) => `
                <div class="carousel-item ${index === 0 ? 'active' : ''}">
                    <img src="${img}" class="d-block w-100" alt="${product.name}">
                </div>
            `).join('');

            // Setup quantity selector
            const quantityInput = document.getElementById('productQuantity');
            document.getElementById('decreaseQuantity').onclick = () => {
                if (quantityInput.value > 1) quantityInput.value--;
            };
            document.getElementById('increaseQuantity').onclick = () => {
                quantityInput.value++;
            };

            // Setup add to cart button
            document.getElementById('modalAddToCart').onclick = () => {
                const quantity = parseInt(quantityInput.value);
                addToCart(product.id, quantity);
                modal.hide();
            };

            modal.show();
        });
}

// Toast Notification
function showToast(message) {
    const toastBody = document.querySelector('#cartToast .toast-body');
    toastBody.textContent = message;
    const toast = new bootstrap.Toast(document.getElementById('cartToast'));
    toast.show();
}

// Utility Functions
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}
