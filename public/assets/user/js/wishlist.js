// Wishlist functionality
let wishlistItems = [];

// Load wishlist count on page load
document.addEventListener('DOMContentLoaded', function() {
    loadWishlistCount();
    loadWishlistItems();
    checkWishlistStatus();
    
    // Test notification (remove this after testing)
    // setTimeout(() => {
    //     showNotification('Test thông báo thành công!', 'success');
    // }, 2000);
});

// Toggle wishlist
function toggleWishlist(productVariantId, button) {
    if (!isAuthenticated()) {
        window.location.href = '/login';
        return;
    }

    const isLiked = button.classList.contains('liked');
    const url = isLiked ? '/wishlist/remove' : '/wishlist/add';
    
    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            product_variant_id: productVariantId
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            if (isLiked) {
                button.classList.remove('liked');
                // Reset button style based on button type
                if (button.classList.contains('wishlist-btn')) {
                    if (button.querySelector('.wishlist-text')) {
                        // Product detail page button with text
                        button.style.backgroundColor = '#f3f4f6';
                        button.style.color = '#374151';
                        button.querySelector('.wishlist-text').textContent = 'Yêu thích';
                    } else if (button.querySelector('i')) {
                        // Product detail page button without text
                        button.style.backgroundColor = '#f3f4f6';
                        button.style.color = '#374151';
                    } else {
                        // Home page button
                        button.style.backgroundColor = 'white';
                        button.style.color = '#1e293b';
                    }
                }
            } else {
                button.classList.add('liked');
                button.style.backgroundColor = '#ef4444';
                button.style.color = 'white';
                // Update text if exists
                const textElement = button.querySelector('.wishlist-text');
                if (textElement) {
                    textElement.textContent = 'Đã yêu thích';
                }
            }
            
            // Update wishlist count and items
            loadWishlistCount();
            loadWishlistItems();
            
            // Show notification
            showNotification(data.message, 'success');
        } else {
            showNotification(data.message, 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Có lỗi xảy ra', 'error');
    });
}

// Load wishlist count
function loadWishlistCount() {
    if (!isAuthenticated()) return;
    
    fetch('/wishlist/count')
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const countElement = document.getElementById('wishlist-count');
            if (countElement) {
                countElement.textContent = data.count;
                countElement.setAttribute('data-count', data.count);
                
                if (data.count > 0) {
                    countElement.style.display = 'flex';
                    countElement.style.visibility = 'visible';
                } else {
                    countElement.style.display = 'none';
                    countElement.style.visibility = 'hidden';
                }
            }
        }
    })
    .catch(error => {
        console.error('Error loading wishlist count:', error);
    });
}

// Load wishlist items for dropdown
function loadWishlistItems() {
    if (!isAuthenticated()) return;
    
    fetch('/wishlist', {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        const container = document.getElementById('wishlist-items');
        if (container) {
            container.innerHTML = data.html;
        }
    })
    .catch(error => {
        console.error('Error loading wishlist items:', error);
    });
}

// Check wishlist status for all products
function checkWishlistStatus() {
    if (!isAuthenticated()) return;
    
    const wishlistButtons = document.querySelectorAll('.wishlist-btn');
    wishlistButtons.forEach(button => {
        const productVariantId = button.getAttribute('data-product-variant-id');
        
        fetch('/wishlist/check', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                product_variant_id: productVariantId
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success && data.is_liked) {
                button.classList.add('liked');
                button.style.backgroundColor = '#ef4444';
                button.style.color = 'white';
            }
        })
        .catch(error => {
            console.error('Error checking wishlist status:', error);
        });
    });
}

// Check if user is authenticated
function isAuthenticated() {
    return document.querySelector('meta[name="auth-status"]')?.getAttribute('content') === 'true';
}

// Show notification
function showNotification(message, type = 'info') {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `wishlist-notification ${
        type === 'success' ? 'bg-green-500 text-white' : 
        type === 'error' ? 'bg-red-500 text-white' : 
        'bg-blue-500 text-white'
    }`;
    notification.textContent = message;
    
    // Add to page
    document.body.appendChild(notification);
    
    // Remove after 3 seconds
    setTimeout(() => {
        notification.style.animation = 'slideOut 0.3s ease';
        setTimeout(() => {
            notification.remove();
        }, 300);
    }, 3000);
} 