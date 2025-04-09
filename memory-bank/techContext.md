# Technical Context

## Technology Stack

### Backend
- Laravel (Latest LTS version)
- PHP 8.1+
- MySQL/PostgreSQL
- Laravel Sanctum (API authentication)
- Laravel Jetstream (Authentication scaffolding)
- Spatie Permission (Role & permission management)

### Frontend
- Blade templates (primary templating)
- Tailwind CSS (styling)
- Optional Vue.js components
- Alpine.js (lightweight JavaScript)
- Responsive design

### Development Tools
- Git (version control)
- Composer (PHP package manager)
- NPM (JavaScript package manager)
- Laravel Mix (asset compilation)
- PHPUnit (testing)

## Development Setup

### Prerequisites
1. PHP 8.1 or higher
2. Composer
3. Node.js and NPM
4. MySQL/PostgreSQL
5. Git

### Environment Setup
1. Clone repository
2. Copy .env.example to .env
3. Configure database settings
4. Install dependencies:
   ```bash
   composer install
   npm install
   ```
5. Generate application key:
   ```bash
   php artisan key:generate
   ```
6. Run migrations and seed database:
   ```bash
   php artisan migrate --seed
   ```
7. Compile assets:
   ```bash
   npm run dev
   ```

## Dependencies

### Backend Dependencies
- laravel/framework
- laravel/sanctum
- laravel/jetstream
- laravel/tinker
- spatie/laravel-permission
- intervention/image (for image handling)

### Frontend Dependencies
- tailwindcss
- alpinejs
- axios
- @tailwindcss/forms

## Technical Constraints

### Performance
- Page load time < 2 seconds
- API response time < 500ms
- Database query optimization
- Image optimization
- Caching when necessary

### Security
- HTTPS only
- CSRF protection
- XSS prevention
- SQL injection prevention
- Input validation
- Role-based access control
- Policy-based authorization

### Browser Support
- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- Mobile browsers

## Database Schema

### Core Tables
- users - User accounts with role field
- roles - System roles (admin, customer)
- permissions - System permissions
- products - Main product information
- product_images - Product images
- product_colors - Product color variations
- product_sizes - Product size variations
- product_quantities - Product quantity pricing
- categories - Product categories
- orders - Customer orders
- order_items - Items within orders
- carts - Shopping carts
- cart_items - Items in shopping cart

### Relationships
- One-to-Many: User -> Orders
- One-to-Many: User -> Carts
- Many-to-Many: Users <-> Roles
- One-to-Many: Category -> Products
- One-to-Many: Product -> ProductImages
- One-to-Many: Product -> ProductColors
- One-to-Many: Product -> ProductSizes
- One-to-Many: Product -> ProductQuantities
- One-to-Many: Order -> OrderItems
- One-to-Many: Cart -> CartItems
- One-to-Many: Product -> OrderItems
- One-to-Many: Product -> CartItems

## API Structure

### Authentication
- POST /login - User login
- POST /logout - User logout
- GET /user - Get authenticated user

### Products
- GET /products - List products
- GET /products/{product} - Show product
- POST /products/filter - Filter products

### Cart
- GET /cart - View cart
- POST /cart/add - Add item to cart
- PATCH /cart/items/{cartItem} - Update cart item
- DELETE /cart/items/{cartItem} - Remove cart item

### Orders
- GET /orders - List user orders
- GET /orders/{order} - Show order details
- POST /checkout - Create new order

### Admin
- GET /admin/dashboard - Admin dashboard
- Resource routes for admin products, categories, orders management

## File Structure

### Key Directories
- app/Models - Database models
- app/Http/Controllers - Request handlers
- app/Services - Business logic
- app/Policies - Authorization policies
- app/Providers - Service providers
- database/migrations - Database structure
- database/seeders - Seed data
- resources/views - Blade templates
- public - Public assets
- routes - Route definitions

## Deployment

### Requirements
- PHP 8.1+
- MySQL 8.0+
- Nginx/Apache
- SSL certificate
- Composer

### Process
1. Code deployment
2. Dependency installation
3. Database migrations
4. Asset compilation
5. Cache clearing

## Monitoring

### Tools
- Laravel Telescope
- Laravel Debugbar
- Server monitoring
- Error tracking
- Performance monitoring

### Metrics
- Response times
- Error rates
- Server resources
- Database performance
- Cache hit rates 
