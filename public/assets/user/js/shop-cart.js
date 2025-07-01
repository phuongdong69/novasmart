document.querySelectorAll('.form-update-qty').forEach(form => {
    const id = form.dataset.id;
    const input = form.querySelector('.quantity-input');
    const btnIncrease = form.querySelector('.btn-increase');
    const btnDecrease = form.querySelector('.btn-decrease');
    const totalCell = form.closest('tr').querySelector('.item-total');
    const priceElement = form.closest('tr').querySelector('.unit-price');
    const unitPrice = parseFloat(priceElement.dataset.price);
    const maxQty = parseInt(input.dataset.max);
    const errorBox = form.querySelector('.error-message');

    function updateQty(newQty) {
        if (newQty > maxQty) {
            errorBox.textContent = `Chỉ còn ${maxQty} sản phẩm trong kho.`;
            errorBox.classList.remove('hidden');
            return;
        } else {
            errorBox.classList.add('hidden');
        }

        fetch(`/cart/update/${id}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ quantity: newQty })
        })
        .then(res => {
            if (!res.ok) throw new Error(`HTTP ${res.status}`);
            return res.json();
        })
        .then(data => {
            if (data.success) {
                input.value = newQty;
                const total = unitPrice * newQty;
                totalCell.textContent = `${total.toLocaleString('vi-VN')}₫`;
            }
        })
        .catch(err => {
            console.error('Update failed:', err);
        });
    }

    btnIncrease.addEventListener('click', () => {
        const currentQty = parseInt(input.value);
        const newQty = currentQty + 1;
        updateQty(newQty);
    });

    btnDecrease.addEventListener('click', () => {
        const currentQty = parseInt(input.value);
        if (currentQty > 1) {
            const newQty = currentQty - 1;
            updateQty(newQty);
        }
    });

    input.addEventListener('change', () => {
        const newQty = Math.max(1, parseInt(input.value));
        updateQty(newQty);
    });
});
