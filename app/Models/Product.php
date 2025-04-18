<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Product extends Model
{
  use HasFactory, Searchable;

  protected $fillable = [
    'name',
    'slug',
    'description',
    'stock',
    'is_available',
    'category_id',
    'enable_custom_color',
    'enable_custom_size',
    'enable_color_selection',
    'enable_size_selection',
    'enable_quantity_pricing'
  ];

  protected $casts = [
    'stock' => 'integer',
    'is_available' => 'boolean',
    'enable_custom_color' => 'boolean',
    'enable_custom_size' => 'boolean',
    'enable_color_selection' => 'boolean',
    'enable_size_selection' => 'boolean',
    'enable_quantity_pricing' => 'boolean'
  ];

  protected $searchableFields = [
    'name',
    'description',
    'sku'
  ];

  protected $filterableFields = [
    'category_id',
    'price',
    'stock',
    'featured'
  ];

  protected $appends = [
    'image_url',
    'all_images'
  ];

  public function getRouteKeyName()
  {
    return 'slug';
  }

  public function category(): BelongsTo
  {
    return $this->belongsTo(Category::class);
  }

  /**
   * علاقة many-to-many مع التصنيفات للكوبونات
   */
  public function categories(): BelongsToMany
  {
    return $this->belongsToMany(Category::class, 'category_product');
  }

  public function images(): HasMany
  {
    return $this->hasMany(ProductImage::class);
  }

  public function colors(): HasMany
  {
    return $this->hasMany(ProductColor::class);
  }

  public function sizes(): HasMany
  {
    return $this->hasMany(ProductSize::class);
  }

  public function orderItems(): HasMany
  {
    return $this->hasMany(OrderItem::class);
  }

  public function quantities()
  {
    return $this->hasMany(ProductQuantity::class);
  }

  public function discounts()
  {
    return $this->belongsToMany(Coupon::class, 'coupon_product');
  }

  public function quantityDiscounts()
  {
    return $this->hasMany(QuantityDiscount::class);
  }

  /**
   * الحصول على الكوبونات الصالحة المتاحة لهذا المنتج
   *
   * @return \Illuminate\Database\Eloquent\Collection
   */
  public function getAvailableCoupons()
  {
    // جمع كل الكوبونات المتاحة للمنتج
    $productCoupons = $this->discounts()->where('is_active', true)->get();

    // جمع الكوبونات المتاحة لجميع المنتجات
    $globalCoupons = Coupon::where('is_active', true)
                           ->where('applies_to_all_products', true)
                           ->get();

    // جمع الكوبونات المتاحة عبر فئة المنتج
    $categoryCoupons = collect();
    if ($this->category_id) {
      $categoryCoupons = Coupon::where('is_active', true)
                              ->whereHas('categories', function ($query) {
                                $query->where('category_id', $this->category_id);
                              })
                              ->get();
    }

    // دمج المجموعات
    $allCoupons = $productCoupons->merge($globalCoupons)->merge($categoryCoupons);

    // تصفية الكوبونات لإزالة المكررات والتحقق من الصلاحية
    return $allCoupons->unique('id')->filter(function ($coupon) {
      return $coupon->isValid();
    });
  }

  public function scopePriceRange(Builder $query, $min = null, $max = null): Builder
  {
    if ($min !== null) {
      $query->where('price', '>=', $min);
    }

    if ($max !== null) {
      $query->where('price', '<=', $max);
    }

    return $query;
  }

  public function scopeFeatured(Builder $query): Builder
  {
    return $query->where('featured', true);
  }

  public function scopeInStock(Builder $query): Builder
  {
    return $query->where('stock', '>', 0);
  }

  public function getPrimaryImageAttribute()
  {
    return $this->images->where('is_primary', true)->first()
      ?? $this->images->first();
  }

  public function getImageUrlAttribute()
  {
    if ($image = $this->primary_image) {
      return Storage::url($image->image_path);
    }
    return asset('images/placeholder.jpg');
  }

  public function getAllImagesAttribute()
  {
    return $this->images->map(function($image) {
      return Storage::url($image->image_path);
    })->toArray();
  }

  public function getAllowCustomColorAttribute()
  {
    return $this->enable_custom_color;
  }

  public function getAllowCustomSizeAttribute()
  {
    return $this->enable_custom_size;
  }

  public function getAllowColorSelectionAttribute()
  {
    return $this->enable_color_selection;
  }

  public function getAllowSizeSelectionAttribute()
  {
    return $this->enable_size_selection;
  }

  public function toArray()
  {
    $array = parent::toArray();
    $array['category_name'] = $this->category->name ?? null;
    $array['price_range'] = $this->getPriceRange();
    return $array;
  }

  /**
   * Get the minimum price for this product
   * Based on sizes and quantities
   */
  public function getMinPriceAttribute()
  {
    $prices = [];

    if ($this->enable_size_selection && $this->sizes->isNotEmpty()) {
      $sizesPrices = $this->sizes->pluck('price')->filter()->toArray();
      if (!empty($sizesPrices)) {
        $prices[] = min($sizesPrices);
      }
    }

    if ($this->enable_quantity_pricing && $this->quantities->isNotEmpty()) {
      $quantityPrices = $this->quantities->pluck('price')->filter()->toArray();
      if (!empty($quantityPrices)) {
        $prices[] = min($quantityPrices);
      }
    }

    // If no sizes or quantities with prices, return 0
    return !empty($prices) ? min($prices) : 0;
  }

  /**
   * Get the maximum price for this product
   * Based on sizes and quantities
   */
  public function getMaxPriceAttribute()
  {
    $prices = [];

    if ($this->enable_size_selection && $this->sizes->isNotEmpty()) {
      $sizesPrices = $this->sizes->pluck('price')->filter()->toArray();
      if (!empty($sizesPrices)) {
        $prices[] = max($sizesPrices);
      }
    }

    if ($this->enable_quantity_pricing && $this->quantities->isNotEmpty()) {
      $quantityPrices = $this->quantities->pluck('price')->filter()->toArray();
      if (!empty($quantityPrices)) {
        $prices[] = max($quantityPrices);
      }
    }

    // If no sizes or quantities with prices, return 0
    return !empty($prices) ? max($prices) : 0;
  }

  /**
   * Get the price range for this product
   */
  public function getPriceRange()
  {
    return [
      'min' => $this->min_price,
      'max' => $this->max_price
    ];
  }

  /**
   * Check if the product has any active discounts
   *
   * @return bool
   */
  public function hasDiscounts()
  {
    // Check if product has available coupons
    if ($this->getAvailableCoupons()->isNotEmpty()) {
      return true;
    }

    // Check if product has active quantity discounts
    if ($this->quantityDiscounts()->where('is_active', true)->exists()) {
      return true;
    }

    return false;
  }
}
