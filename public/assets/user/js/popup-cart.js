document.addEventListener('DOMContentLoaded', () => {
    const popup = document.getElementById('popup-login-required');

    // 1. Xử lý khi click nút "Thêm vào giỏ hàng"
    document.querySelectorAll('.btn-add-cart').forEach(btn => {
        btn.addEventListener('click', function (e) {
            const productId = this.getAttribute('data-id');

            if (!window.isLoggedIn) {
                e.preventDefault();
                if (popup) popup.classList.remove('hidden');
            } else {
                if (typeof addToCart === 'function' && productId) {
                    addToCart(parseInt(productId));
                } else {
                    console.warn('Hàm addToCart không tồn tại hoặc thiếu productId');
                }
            }
        });
    });

    // 2. Xử lý khi click "Xem giỏ hàng" trong dropdown (class .btn-view-cart)
    document.querySelectorAll('.btn-view-cart').forEach(link => {
        link.addEventListener('click', function (e) {
            if (!window.isLoggedIn) {
                e.preventDefault();
                if (popup) popup.classList.remove('hidden');
            }
        });
    });

    // 3. Đóng popup khi click ra ngoài
    if (popup) {
        popup.addEventListener('click', () => popup.classList.add('hidden'));
        const popupBox = popup.querySelector('.popup-box');
        if (popupBox) {
            popupBox.addEventListener('click', e => e.stopPropagation());
        }
    }
});
