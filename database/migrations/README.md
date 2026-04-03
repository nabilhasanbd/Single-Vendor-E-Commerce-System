# E-Commerce DB Schema (Laravel)

## Migration Order (Based on Dependencies)

```
001 → users
002 → user_addresses          (users)
003 → categories              (categories - self ref)
004 → products                (categories)
005 → product_images          (products)
006 → product_variants        (products)
007 → carts + cart_items      (users, products, product_variants, coupons)
008 → coupons + coupon_usages (users, orders)  ← Create 'coupons' here, 'coupon_usages' later due to FK
009 → orders                  (users, coupons)
010 → order_items             (orders, products, product_variants)
011 → payments                (orders, users)
```

> ⚠️ The `coupon_usages` table has an `order_id` FK, so it must be migrated after `orders`. 
> However, the `coupons` table is needed before `orders` (since `orders` has a `coupon_id` FK).
> Therefore, in migration 008, only create the `coupons` table; you can keep `coupon_usages` in a separate migration file.

---

## Table Relationships

```
users
 ├── user_addresses (1:N)
 ├── carts (1:1 active)
 ├── orders (1:N)
 └── payments (1:N)

categories
 ├── parent_id → categories (self, for subcategory)
 └── products (1:N)

products
 ├── product_images (1:N)
 ├── product_variants (1:N)
 ├── cart_items (1:N)
 └── order_items (1:N)

carts
 └── cart_items (1:N)
      ├── product_id → products
      └── product_variant_id → product_variants (nullable)

orders
 ├── order_items (1:N)
 ├── payments (1:N)
 └── coupon_usages (1:1)

coupons
 ├── carts (1:N, nullable)
 ├── orders (1:N, nullable)
 └── coupon_usages (1:N)
```

---

## Key Design Decisions

### 1. Snapshot Pattern (order_items)
Even if a product's name or price changes after an order is placed, the order history will remain accurate. 
`product_name`, `unit_price`, `variant_attributes`, and `product_image` are all stored as snapshots.

### 2. Guest Cart Support (carts)
The `user_id` is kept nullable. Guests will track their carts using a `session_id`. 
Upon login, the guest cart will be merged with the user cart.

### 3. Self-referencing Categories
Unlimited nested categories are possible using a `parent_id`.
- Electronics → Mobile → Android
- Fashion → Men → T-Shirt

### 4. Product Variants (product_variants)
Any combination of Size/Color/Material is stored as JSON in the `attributes` column.
Each variant has its own separate stock and price adjustment.

### 5. Soft Deletes
Soft deletes are implemented on `users`, `products`, and `orders` — data will not be permanently lost.

---

## Future Tables (As needed)

Add these in separate migration files later as needed:

| Feature | Tables |
|---------|--------|
| Reviews | `product_reviews` |
| Wishlist | `wishlists` |
| Notifications | `notifications` (Laravel built-in) |
| Refunds | `refunds` |
| Shipping zones | `shipping_zones`, `shipping_rates` |
| Flash sales | `promotions`, `promotion_products` |
| Tags/Filters | `tags`, `product_tag` (pivot) |
| Activity log | `activity_logs` |