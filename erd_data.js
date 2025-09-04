// NovaSmart Complete Database ERD Data
const tables = {
    // CORE SYSTEM GROUP (Top Left)
    statuses: { 
        x: 50, y: 50, group: 'core',
        fields: [
            {name: 'id', type: 'pk'}, 
            {name: 'name', type: 'regular'}, 
            {name: 'code', type: 'regular'}, 
            {name: 'type', type: 'regular'}, 
            {name: 'color', type: 'regular'}, 
            {name: 'priority', type: 'regular'}, 
            {name: 'is_active', type: 'regular'}, 
            {name: 'description', type: 'regular'}, 
            {name: 'created_at', type: 'regular'}, 
            {name: 'updated_at', type: 'regular'}
        ]
    },
    roles: { 
        x: 280, y: 50, group: 'core',
        fields: [
            {name: 'id', type: 'pk'}, 
            {name: 'name', type: 'regular'}, 
            {name: 'description', type: 'regular'}, 
            {name: 'created_at', type: 'regular'}, 
            {name: 'updated_at', type: 'regular'}
        ]
    },
    users: { 
        x: 50, y: 220, group: 'core',
        fields: [
            {name: 'id', type: 'pk'}, 
            {name: 'status_id', type: 'fk'}, 
            {name: 'role_id', type: 'fk'}, 
            {name: 'name', type: 'regular'}, 
            {name: 'email', type: 'unique'}, 
            {name: 'password', type: 'regular'}, 
            {name: 'phoneNumber', type: 'regular'}, 
            {name: 'phone_number', type: 'regular'}, 
            {name: 'image_user', type: 'regular'}, 
            {name: 'gender', type: 'regular'}, 
            {name: 'birthday', type: 'regular'}, 
            {name: 'address', type: 'regular'}, 
            {name: 'remember_token', type: 'regular'}, 
            {name: 'deleted_at', type: 'regular'}, 
            {name: 'created_at', type: 'regular'}, 
            {name: 'updated_at', type: 'regular'}
        ]
    },
    
    // PRODUCTS GROUP (Top Center)
    categories: { 
        x: 500, y: 50, group: 'products',
        fields: [
            {name: 'id', type: 'pk'}, 
            {name: 'status_id', type: 'fk'}, 
            {name: 'name', type: 'regular'}, 
            {name: 'deleted_at', type: 'regular'}, 
            {name: 'created_at', type: 'regular'}, 
            {name: 'updated_at', type: 'regular'}
        ]
    },
    brands: { 
        x: 720, y: 50, group: 'products',
        fields: [
            {name: 'id', type: 'pk'}, 
            {name: 'status_id', type: 'fk'}, 
            {name: 'category_id', type: 'fk'}, 
            {name: 'name', type: 'regular'}, 
            {name: 'created_at', type: 'regular'}, 
            {name: 'updated_at', type: 'regular'}
        ]
    },
    origins: { 
        x: 940, y: 50, group: 'products',
        fields: [
            {name: 'id', type: 'pk'}, 
            {name: 'status_id', type: 'fk'}, 
            {name: 'name', type: 'regular'}, 
            {name: 'created_at', type: 'regular'}, 
            {name: 'updated_at', type: 'regular'}
        ]
    },
    products: { 
        x: 500, y: 220, group: 'products',
        fields: [
            {name: 'id', type: 'pk'}, 
            {name: 'status_id', type: 'fk'}, 
            {name: 'brand_id', type: 'fk'}, 
            {name: 'origin_id', type: 'fk'}, 
            {name: 'category_id', type: 'fk'}, 
            {name: 'name', type: 'regular'}, 
            {name: 'description', type: 'regular'}, 
            {name: 'created_at', type: 'regular'}, 
            {name: 'updated_at', type: 'regular'}
        ]
    },
    product_variants: { 
        x: 500, y: 420, group: 'products',
        fields: [
            {name: 'id', type: 'pk'}, 
            {name: 'status_id', type: 'fk'}, 
            {name: 'product_id', type: 'fk'}, 
            {name: 'sku', type: 'regular'}, 
            {name: 'price', type: 'regular'}, 
            {name: 'stock_quantity', type: 'regular'}, 
            {name: 'created_at', type: 'regular'}, 
            {name: 'updated_at', type: 'regular'}
        ]
    },
    product_thumbnails: { 
        x: 720, y: 420, group: 'products',
        fields: [
            {name: 'id', type: 'pk'}, 
            {name: 'product_id', type: 'fk'}, 
            {name: 'image_path', type: 'regular'}, 
            {name: 'is_primary', type: 'regular'}, 
            {name: 'created_at', type: 'regular'}, 
            {name: 'updated_at', type: 'regular'}
        ]
    },
    
    // ATTRIBUTES GROUP (Top Right)
    attributes: { 
        x: 1200, y: 50, group: 'attributes',
        fields: [
            {name: 'id', type: 'pk'}, 
            {name: 'name', type: 'regular'}, 
            {name: 'created_at', type: 'regular'}, 
            {name: 'updated_at', type: 'regular'}
        ]
    },
    attribute_values: { 
        x: 1200, y: 180, group: 'attributes',
        fields: [
            {name: 'id', type: 'pk'}, 
            {name: 'attribute_id', type: 'fk'}, 
            {name: 'value', type: 'regular'}, 
            {name: 'created_at', type: 'regular'}, 
            {name: 'updated_at', type: 'regular'}
        ]
    },
    variant_attribute_values: { 
        x: 1200, y: 320, group: 'attributes',
        fields: [
            {name: 'id', type: 'pk'}, 
            {name: 'variant_id', type: 'fk'}, 
            {name: 'attr_value_id', type: 'fk'}, 
            {name: 'created_at', type: 'regular'}, 
            {name: 'updated_at', type: 'regular'}
        ]
    },
    
    // COMMERCE GROUP (Middle Left)
    carts: { 
        x: 50, y: 600, group: 'commerce',
        fields: [
            {name: 'id', type: 'pk'}, 
            {name: 'user_id', type: 'fk'}, 
            {name: 'created_at', type: 'regular'}, 
            {name: 'updated_at', type: 'regular'}
        ]
    },
    cart_items: { 
        x: 280, y: 600, group: 'commerce',
        fields: [
            {name: 'id', type: 'pk'}, 
            {name: 'cart_id', type: 'fk'}, 
            {name: 'variant_id', type: 'fk'}, 
            {name: 'quantity', type: 'regular'}, 
            {name: 'created_at', type: 'regular'}, 
            {name: 'updated_at', type: 'regular'}
        ]
    },
    payments: { 
        x: 50, y: 780, group: 'commerce',
        fields: [
            {name: 'id', type: 'pk'}, 
            {name: 'method', type: 'regular'}, 
            {name: 'status', type: 'regular'}, 
            {name: 'amount', type: 'regular'}, 
            {name: 'transaction_id', type: 'regular'}, 
            {name: 'created_at', type: 'regular'}, 
            {name: 'updated_at', type: 'regular'}
        ]
    },
    vouchers: { 
        x: 280, y: 780, group: 'commerce',
        fields: [
            {name: 'id', type: 'pk'}, 
            {name: 'status_id', type: 'fk'}, 
            {name: 'code', type: 'unique'}, 
            {name: 'discount_type', type: 'regular'}, 
            {name: 'discount_value', type: 'regular'}, 
            {name: 'expired_at', type: 'regular'}, 
            {name: 'quantity', type: 'regular'}, 
            {name: 'created_at', type: 'regular'}, 
            {name: 'updated_at', type: 'regular'}
        ]
    },
    orders: { 
        x: 50, y: 980, group: 'commerce',
        fields: [
            {name: 'id', type: 'pk'}, 
            {name: 'status_id', type: 'fk'}, 
            {name: 'user_id', type: 'fk'}, 
            {name: 'voucher_id', type: 'fk'}, 
            {name: 'payment_id', type: 'fk'}, 
            {name: 'name', type: 'regular'}, 
            {name: 'phoneNumber', type: 'regular'}, 
            {name: 'address', type: 'regular'}, 
            {name: 'email', type: 'regular'}, 
            {name: 'total_price', type: 'regular'}, 
            {name: 'discount_amount', type: 'regular'}, 
            {name: 'order_code', type: 'unique'}, 
            {name: 'cancel_reason', type: 'regular'}, 
            {name: 'created_at', type: 'regular'}, 
            {name: 'updated_at', type: 'regular'}
        ]
    },
    order_details: { 
        x: 280, y: 980, group: 'commerce',
        fields: [
            {name: 'id', type: 'pk'}, 
            {name: 'order_id', type: 'fk'}, 
            {name: 'variant_id', type: 'fk'}, 
            {name: 'quantity', type: 'regular'}, 
            {name: 'price', type: 'regular'}, 
            {name: 'created_at', type: 'regular'}, 
            {name: 'updated_at', type: 'regular'}
        ]
    },
    
    // FEATURES GROUP (Right Side)
    product_returns: { 
        x: 1450, y: 50, group: 'features',
        fields: [
            {name: 'id', type: 'pk'}, 
            {name: 'order_id', type: 'fk'}, 
            {name: 'user_id', type: 'fk'}, 
            {name: 'guest_name', type: 'regular'}, 
            {name: 'guest_email', type: 'regular'}, 
            {name: 'guest_phone', type: 'regular'}, 
            {name: 'reason', type: 'regular'}, 
            {name: 'status', type: 'regular'}, 
            {name: 'refund_amount', type: 'regular'}, 
            {name: 'return_type', type: 'regular'}, 
            {name: 'admin_notes', type: 'regular'}, 
            {name: 'processed_by', type: 'fk'}, 
            {name: 'processed_at', type: 'regular'}, 
            {name: 'created_at', type: 'regular'}, 
            {name: 'updated_at', type: 'regular'}
        ]
    },
    wishlists: { 
        x: 1450, y: 350, group: 'features',
        fields: [
            {name: 'id', type: 'pk'}, 
            {name: 'user_id', type: 'fk'}, 
            {name: 'product_id', type: 'fk'}, 
            {name: 'created_at', type: 'regular'}, 
            {name: 'updated_at', type: 'regular'}
        ]
    },
    likes: { 
        x: 1450, y: 480, group: 'features',
        fields: [
            {name: 'id', type: 'pk'}, 
            {name: 'user_id', type: 'fk'}, 
            {name: 'product_id', type: 'fk'}, 
            {name: 'created_at', type: 'regular'}, 
            {name: 'updated_at', type: 'regular'}
        ]
    },
    refunds: { 
        x: 1450, y: 610, group: 'features',
        fields: [
            {name: 'id', type: 'pk'}, 
            {name: 'order_id', type: 'fk'}, 
            {name: 'amount', type: 'regular'}, 
            {name: 'reason', type: 'regular'}, 
            {name: 'status', type: 'regular'}, 
            {name: 'processed_by', type: 'fk'}, 
            {name: 'processed_at', type: 'regular'}, 
            {name: 'created_at', type: 'regular'}, 
            {name: 'updated_at', type: 'regular'}
        ]
    },
    order_cancellations: { 
        x: 1450, y: 780, group: 'features',
        fields: [
            {name: 'id', type: 'pk'}, 
            {name: 'order_id', type: 'fk'}, 
            {name: 'reason', type: 'regular'}, 
            {name: 'cancelled_by', type: 'fk'}, 
            {name: 'cancelled_at', type: 'regular'}, 
            {name: 'created_at', type: 'regular'}, 
            {name: 'updated_at', type: 'regular'}
        ]
    },
    
    // CONTENT GROUP (Bottom Center)
    news: { 
        x: 700, y: 800, group: 'content',
        fields: [
            {name: 'id', type: 'pk'}, 
            {name: 'title', type: 'regular'}, 
            {name: 'slug', type: 'unique'}, 
            {name: 'content', type: 'regular'}, 
            {name: 'image', type: 'regular'}, 
            {name: 'excerpt', type: 'regular'}, 
            {name: 'status', type: 'regular'}, 
            {name: 'published_at', type: 'regular'}, 
            {name: 'author_id', type: 'fk'}, 
            {name: 'product_link', type: 'regular'}, 
            {name: 'created_at', type: 'regular'}, 
            {name: 'updated_at', type: 'regular'}
        ]
    },
    slideshows: { 
        x: 700, y: 1050, group: 'content',
        fields: [
            {name: 'id', type: 'pk'}, 
            {name: 'title', type: 'regular'}, 
            {name: 'image_path', type: 'regular'}, 
            {name: 'link', type: 'regular'}, 
            {name: 'order', type: 'regular'}, 
            {name: 'is_active', type: 'regular'}, 
            {name: 'created_at', type: 'regular'}, 
            {name: 'updated_at', type: 'regular'}
        ]
    },
    
    // SYSTEM GROUP (Bottom Right)
    migrations: { 
        x: 1600, y: 1000, group: 'system',
        fields: [
            {name: 'id', type: 'pk'}, 
            {name: 'migration', type: 'regular'}, 
            {name: 'batch', type: 'regular'}
        ]
    },
    password_resets: { 
        x: 1600, y: 1150, group: 'system',
        fields: [
            {name: 'email', type: 'regular'}, 
            {name: 'token', type: 'regular'}, 
            {name: 'created_at', type: 'regular'}
        ]
    },
    personal_access_tokens: { 
        x: 1600, y: 1280, group: 'system',
        fields: [
            {name: 'id', type: 'pk'}, 
            {name: 'tokenable_type', type: 'regular'}, 
            {name: 'tokenable_id', type: 'regular'}, 
            {name: 'name', type: 'regular'}, 
            {name: 'token', type: 'unique'}, 
            {name: 'abilities', type: 'regular'}, 
            {name: 'last_used_at', type: 'regular'}, 
            {name: 'expires_at', type: 'regular'}, 
            {name: 'created_at', type: 'regular'}, 
            {name: 'updated_at', type: 'regular'}
        ]
    }
};

// Define relationships between tables
const relationships = [
    // Core relationships
    {from: 'users', to: 'statuses', fromField: 'status_id', toField: 'id'},
    {from: 'users', to: 'roles', fromField: 'role_id', toField: 'id'},
    
    // Product relationships
    {from: 'categories', to: 'statuses', fromField: 'status_id', toField: 'id'},
    {from: 'brands', to: 'statuses', fromField: 'status_id', toField: 'id'},
    {from: 'brands', to: 'categories', fromField: 'category_id', toField: 'id'},
    {from: 'origins', to: 'statuses', fromField: 'status_id', toField: 'id'},
    {from: 'products', to: 'statuses', fromField: 'status_id', toField: 'id'},
    {from: 'products', to: 'brands', fromField: 'brand_id', toField: 'id'},
    {from: 'products', to: 'origins', fromField: 'origin_id', toField: 'id'},
    {from: 'products', to: 'categories', fromField: 'category_id', toField: 'id'},
    {from: 'product_variants', to: 'statuses', fromField: 'status_id', toField: 'id'},
    {from: 'product_variants', to: 'products', fromField: 'product_id', toField: 'id'},
    {from: 'product_thumbnails', to: 'products', fromField: 'product_id', toField: 'id'},
    
    // Attribute relationships
    {from: 'attribute_values', to: 'attributes', fromField: 'attribute_id', toField: 'id'},
    {from: 'variant_attribute_values', to: 'product_variants', fromField: 'variant_id', toField: 'id'},
    {from: 'variant_attribute_values', to: 'attribute_values', fromField: 'attr_value_id', toField: 'id'},
    
    // Commerce relationships
    {from: 'carts', to: 'users', fromField: 'user_id', toField: 'id'},
    {from: 'cart_items', to: 'carts', fromField: 'cart_id', toField: 'id'},
    {from: 'cart_items', to: 'product_variants', fromField: 'variant_id', toField: 'id'},
    {from: 'vouchers', to: 'statuses', fromField: 'status_id', toField: 'id'},
    {from: 'orders', to: 'statuses', fromField: 'status_id', toField: 'id'},
    {from: 'orders', to: 'users', fromField: 'user_id', toField: 'id'},
    {from: 'orders', to: 'vouchers', fromField: 'voucher_id', toField: 'id'},
    {from: 'orders', to: 'payments', fromField: 'payment_id', toField: 'id'},
    {from: 'order_details', to: 'orders', fromField: 'order_id', toField: 'id'},
    {from: 'order_details', to: 'product_variants', fromField: 'variant_id', toField: 'id'},
    
    // Feature relationships
    {from: 'product_returns', to: 'orders', fromField: 'order_id', toField: 'id'},
    {from: 'product_returns', to: 'users', fromField: 'user_id', toField: 'id'},
    {from: 'product_returns', to: 'users', fromField: 'processed_by', toField: 'id'},
    {from: 'wishlists', to: 'users', fromField: 'user_id', toField: 'id'},
    {from: 'wishlists', to: 'products', fromField: 'product_id', toField: 'id'},
    {from: 'likes', to: 'users', fromField: 'user_id', toField: 'id'},
    {from: 'likes', to: 'products', fromField: 'product_id', toField: 'id'},
    {from: 'refunds', to: 'orders', fromField: 'order_id', toField: 'id'},
    {from: 'refunds', to: 'users', fromField: 'processed_by', toField: 'id'},
    {from: 'order_cancellations', to: 'orders', fromField: 'order_id', toField: 'id'},
    {from: 'order_cancellations', to: 'users', fromField: 'cancelled_by', toField: 'id'},
    
    // Content relationships
    {from: 'news', to: 'users', fromField: 'author_id', toField: 'id'}
];

// Export for use in main ERD file
if (typeof module !== 'undefined' && module.exports) {
    module.exports = { tables, relationships };
}
