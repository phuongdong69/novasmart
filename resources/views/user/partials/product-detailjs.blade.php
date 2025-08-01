<script>
function addToCart(productVariantId) {
    const quantity = document.querySelector('input[name="quantity"]').value;
    
    if (quantity <= 0) {
        alert('Vui lòng chọn số lượng sản phẩm!');
        return;
    }
    
    // Hiển thị loading
    const button = event.target;
    const originalText = button.textContent;
    button.textContent = 'Đang thêm...';
    button.disabled = true;
    
    // Tạo form data để gửi request
    const formData = new FormData();
    formData.append('product_variant_id', productVariantId);
    formData.append('quantity', quantity);
    formData.append('_token', '{{ csrf_token() }}');
    
    fetch('{{ route("cart.add") }}', {
        method: 'POST',
        body: formData
    })
    .then(response => {
        if (response.redirected) {
            // Nếu redirect (thành công), reload trang
            window.location.reload();
        } else {
            return response.text();
        }
    })
    .then(data => {
        if (data) {
            // Nếu có response text, hiển thị thông báo
            showNotification('Đã thêm sản phẩm vào giỏ hàng!', 'success');
            document.querySelector('input[name="quantity"]').value = 1;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Có lỗi xảy ra khi thêm vào giỏ hàng', 'error');
    })
    .finally(() => {
        // Khôi phục button
        button.textContent = originalText;
        button.disabled = false;
    });
}

function showNotification(message, type) {
    // Tạo notification element
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 z-50 p-4 rounded-md shadow-lg ${
        type === 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'
    }`;
    notification.textContent = message;
    
    // Thêm vào body
    document.body.appendChild(notification);
    
    // Tự động ẩn sau 3 giây
    setTimeout(() => {
        notification.remove();
    }, 3000);
}
</script>