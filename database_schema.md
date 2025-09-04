# NovaSmart Database Schema Design

## Database Overview
Hệ thống NovaSmart có 32+ bảng được tổ chức theo các module chính:

---

## 🏗️ **Core System Tables**

### Authentication & User Management
```
┌─────────────────┐    ┌─────────────────┐    ┌─────────────────┐
│     users       │    │     roles       │    │    statuses     │
├─────────────────┤    ├─────────────────┤    ├─────────────────┤
│ id (PK)         │    │ id (PK)         │    │ id (PK)         │
│ name            │    │ name            │    │ name            │
│ email           │    │ description     │    │ type            │
│ password        │    │ created_at      │    │ description     │
│ phone_number    │    │ updated_at      │    │ created_at      │
│ image_user      │    └─────────────────┘    │ updated_at      │
│ gender          │                           └─────────────────┘
│ birthday        │
│ role_id (FK)    │
│ deleted_at      │
│ created_at      │
│ updated_at      │
└─────────────────┘
```

---

## 🛍️ **Product Management**

### Product Hierarchy
```
┌─────────────────┐    ┌─────────────────┐    ┌─────────────────┐
│   categories    │    │     brands      │    │    origins      │
├─────────────────┤    ├─────────────────┤    ├─────────────────┤
│ id (PK)         │    │ id (PK)         │    │ id (PK)         │
│ name            │    │ name            │    │ name            │
│ status_id (FK)  │    │ category_id(FK) │    │ status_id (FK)  │
│ deleted_at      │    │ status_id (FK)  │    │ created_at      │
│ created_at      │    │ created_at      │    │ updated_at      │
│ updated_at      │    │ updated_at      │    └─────────────────┘
└─────────────────┘    └─────────────────┘
```

### Products & Variants
```
┌─────────────────┐    ┌─────────────────┐    ┌─────────────────┐
│    products     │    │product_variants │    │product_thumbnails│
├─────────────────┤    ├─────────────────┤    ├─────────────────┤
│ id (PK)         │    │ id (PK)         │    │ id (PK)         │
│ name            │    │ product_id (FK) │    │ product_id (FK) │
│ description     │    │ sku             │    │ image_path      │
│ category_id(FK) │    │ price           │    │ is_primary      │
│ brand_id (FK)   │    │ stock_quantity  │    │ created_at      │
│ origin_id (FK)  │    │ status_id (FK)  │    │ updated_at      │
│ status_id (FK)  │    │ created_at      │    └─────────────────┘
│ created_at      │    │ updated_at      │
│ updated_at      │    └─────────────────┘
└─────────────────┘
```

### Attributes System
```
┌─────────────────┐    ┌─────────────────┐    ┌─────────────────┐
│   attributes    │    │attribute_values │    │variant_attribute│
├─────────────────┤    ├─────────────────┤    │     _values     │
│ id (PK)         │    │ id (PK)         │    ├─────────────────┤
│ name            │    │ attribute_id(FK)│    │ id (PK)         │
│ created_at      │    │ value           │    │ variant_id (FK) │
│ updated_at      │    │ created_at      │    │ attr_value_id(FK)│
└─────────────────┘    │ updated_at      │    │ created_at      │
                       └─────────────────┘    │ updated_at      │
                                              └─────────────────┘
```

---

## 🛒 **E-commerce Core**

### Shopping Cart
```
┌─────────────────┐    ┌─────────────────┐
│     carts       │    │   cart_items    │
├─────────────────┤    ├─────────────────┤
│ id (PK)         │    │ id (PK)         │
│ user_id (FK)    │    │ cart_id (FK)    │
│ created_at      │    │ variant_id (FK) │
│ updated_at      │    │ quantity        │
└─────────────────┘    │ created_at      │
                       │ updated_at      │
                       └─────────────────┘
```

### Orders & Payments
```
┌─────────────────┐    ┌─────────────────┐    ┌─────────────────┐
│     orders      │    │  order_details  │    │    payments     │
├─────────────────┤    ├─────────────────┤    ├─────────────────┤
│ id (PK)         │    │ id (PK)         │    │ id (PK)         │
│ user_id (FK)    │    │ order_id (FK)   │    │ method          │
│ voucher_id (FK) │    │ variant_id (FK) │    │ status          │
│ payment_id (FK) │    │ quantity        │    │ amount          │
│ status_id (FK)  │    │ price           │    │ transaction_id  │
│ name            │    │ created_at      │    │ created_at      │
│ phoneNumber     │    │ updated_at      │    │ updated_at      │
│ email           │    └─────────────────┘    └─────────────────┘
│ address         │
│ total_price     │
│ discount_amount │
│ order_code      │
│ cancel_reason   │
│ created_at      │
│ updated_at      │
└─────────────────┘
```

---

## 🎟️ **Promotions & Returns**

### Vouchers
```
┌─────────────────┐
│    vouchers     │
├─────────────────┤
│ id (PK)         │
│ status_id (FK)  │
│ code            │
│ discount_type   │
│ discount_value  │
│ expired_at      │
│ quantity        │
│ created_at      │
│ updated_at      │
└─────────────────┘
```

### Returns System
```
┌─────────────────┐
│ product_returns │
├─────────────────┤
│ id (PK)         │
│ order_id (FK)   │
│ user_id (FK)    │
│ guest_name      │
│ guest_email     │
│ guest_phone     │
│ reason          │
│ status          │
│ refund_amount   │
│ return_type     │
│ admin_notes     │
│ processed_by(FK)│
│ processed_at    │
│ created_at      │
│ updated_at      │
└─────────────────┘
```

---

## 👤 **User Features**

### User Interactions
```
┌─────────────────┐    ┌─────────────────┐    ┌─────────────────┐
│   wishlists     │    │     likes       │    │    comments     │
├─────────────────┤    ├─────────────────┤    ├─────────────────┤
│ id (PK)         │    │ id (PK)         │    │ id (PK)         │
│ user_id (FK)    │    │ user_id (FK)    │    │ user_id (FK)    │
│ product_id (FK) │    │ product_id (FK) │    │ order_id (FK)   │
│ created_at      │    │ created_at      │    │ content         │
│ updated_at      │    │ updated_at      │    │ created_at      │
└─────────────────┘    └─────────────────┘    │ updated_at      │
                                              └─────────────────┘

┌─────────────────┐
│    ratings      │
├─────────────────┤
│ id (PK)         │
│ user_id (FK)    │
│ order_id (FK)   │
│ rating          │
│ review          │
│ created_at      │
│ updated_at      │
└─────────────────┘
```

---

## 📰 **Content Management**

### News & Media
```
┌─────────────────┐    ┌─────────────────┐
│      news       │    │   slideshows    │
├─────────────────┤    ├─────────────────┤
│ id (PK)         │    │ id (PK)         │
│ title           │    │ title           │
│ slug            │    │ image           │
│ content         │    │ link            │
│ image           │    │ order           │
│ excerpt         │    │ is_active       │
│ status          │    │ created_at      │
│ published_at    │    │ updated_at      │
│ author_id (FK)  │    └─────────────────┘
│ product_link    │
│ created_at      │
│ updated_at      │
└─────────────────┘
```

---

## 📊 **System Tracking**

### Status & Logs
```
┌─────────────────┐    ┌─────────────────┐    ┌─────────────────┐
│   status_logs   │    │order_cancellations│  │    refunds      │
├─────────────────┤    ├─────────────────┤    ├─────────────────┤
│ id (PK)         │    │ id (PK)         │    │ id (PK)         │
│ loggable_type   │    │ order_id (FK)   │    │ order_id (FK)   │
│ loggable_id     │    │ reason          │    │ amount          │
│ status_id (FK)  │    │ cancelled_by(FK)│    │ reason          │
│ user_id (FK)    │    │ cancelled_at    │    │ status          │
│ note            │    │ created_at      │    │ processed_by(FK)│
│ created_at      │    │ updated_at      │    │ processed_at    │
│ updated_at      │    └─────────────────┘    │ created_at      │
└─────────────────┘                           │ updated_at      │
                                              └─────────────────┘
```

---

## 🔗 **Key Relationships**

### Primary Foreign Key Relationships:
- `users` → `orders`, `carts`, `wishlists`, `likes`, `comments`, `ratings`
- `orders` → `order_details`, `product_returns`, `order_cancellations`, `refunds`
- `products` → `product_variants`, `product_thumbnails`, `wishlists`, `likes`
- `product_variants` → `cart_items`, `order_details`, `variant_attribute_values`
- `categories` → `products`, `brands`
- `statuses` → `users`, `products`, `orders`, `vouchers`, `categories`, `origins`

### Polymorphic Relationships:
- `status_logs` → polymorphic relationship với nhiều models

---

## 📋 **Database Statistics**
- **Total Tables**: 32+
- **Core Entities**: Users, Products, Orders, Payments
- **Support Tables**: Statuses, Logs, Media
- **Junction Tables**: cart_items, order_details, variant_attribute_values
- **Feature Tables**: wishlists, likes, comments, ratings, returns

---

## 🎯 **Recommended Layout in MySQL Workbench**

### Group 1: User & Auth (Top Left)
- users, roles, statuses

### Group 2: Products (Top Center)  
- categories, brands, origins, products, product_variants, product_thumbnails

### Group 3: Attributes (Top Right)
- attributes, attribute_values, variant_attribute_values

### Group 4: Commerce (Middle Left)
- carts, cart_items, orders, order_details, payments

### Group 5: Features (Middle Right)
- vouchers, product_returns, wishlists, likes

### Group 6: Content & Logs (Bottom)
- news, slideshows, comments, ratings, status_logs, refunds, order_cancellations

Với layout này, các bảng sẽ được sắp xếp theo logic nghiệp vụ và không bị chồng lấp!
