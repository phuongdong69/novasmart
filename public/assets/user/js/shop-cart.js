// Khi DOM đã được tải đầy đủ
document.addEventListener('DOMContentLoaded', () => {

    // 🔑 Key lưu trạng thái checkbox
    const CHECKED_KEY = 'selected_cart_ids';
    const CHECK_ALL_KEY = 'cart_check_all';

    // 📦 Kiểm tra có vừa áp voucher không
    const urlParams = new URLSearchParams(location.search);
    const isVoucherJustApplied = urlParams.has('voucher_applied');
    if (!isVoucherJustApplied) {
        localStorage.removeItem(CHECKED_KEY);
        localStorage.removeItem(CHECK_ALL_KEY);
        document.querySelectorAll('.item-checkbox').forEach(cb => cb.checked = false);
        const checkAll = document.getElementById('check-all');
        if (checkAll) checkAll.checked = false;
    }

    // 🧱 Lấy phần tử
    const checkboxes = document.querySelectorAll('.item-checkbox');
    const checkAll = document.getElementById('check-all');
    const formCheckout = document.getElementById('cart-actions-form');
    const formRemove = document.getElementById('remove-selected-form');
    const voucherForm = document.getElementById('voucher-form');

    function getHeaders() {
        return {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        };
    }

    function saveChecked(ids) {
        localStorage.setItem(CHECKED_KEY, JSON.stringify(ids));
    }
    function loadChecked() {
        try {
            return JSON.parse(localStorage.getItem(CHECKED_KEY)) || [];
        } catch {
            return [];
        }
    }

    function updateSelectedIds() {
        const selectedIds = [...checkboxes].filter(cb => cb.checked).map(cb => cb.value);
        document.querySelectorAll('input[name="selected_ids"]').forEach(input => {
            input.value = selectedIds.join(',');
        });
        const hiddenInputRemove = document.getElementById('selected-ids-remove');
        if (hiddenInputRemove) hiddenInputRemove.value = selectedIds.join(',');
        saveChecked(selectedIds);
        updateCartSummary(selectedIds);
        updateVoucher(selectedIds);
    }

    function updateCartSummary(selectedIds) {
        let total = 0;
        selectedIds.forEach(id => {
            const row = [...checkboxes].find(cb => cb.value === id)?.closest('tr');
            if (!row) return;
            const text = row.querySelector('.item-total')?.textContent || '0';
            total += parseInt(text.replace(/[^\d]/g, '')) || 0;
        });

        const discountEl = document.getElementById('discount-value');
        const discount = parseInt(discountEl?.dataset.discount || 0);
        const final = total - discount;

        document.getElementById('temp-value').textContent = total.toLocaleString('vi-VN') + ' VNĐ';
        document.getElementById('total-value').textContent = final.toLocaleString('vi-VN') + ' VNĐ';

        if (selectedIds.length === 0 && document.querySelector('[data-has-voucher="true"]')) {
            fetch('/cart/remove-voucher', {
                method: 'POST',
                headers: getHeaders()
            }).then(() => {
                localStorage.removeItem(CHECKED_KEY);
                document.getElementById('discount-display').textContent = '-0';
                if (discountEl) discountEl.dataset.discount = '0';
                document.querySelector('[data-has-voucher="true"]')?.parentElement?.remove();
                document.getElementById('total-value').textContent = document.getElementById('temp-value').textContent;
            });
        }
    }

    function updateVoucher(selectedIds) {
        if (!document.querySelector('[data-has-voucher="true"]')) return;
        const items = selectedIds.map(id => {
            const row = [...checkboxes].find(cb => cb.value === id)?.closest('tr');
            const qty = row?.querySelector('.quantity-input')?.value || 1;
            return { id, quantity: parseInt(qty) };
        });

        fetch('/cart/update-voucher', {
            method: 'POST',
            headers: getHeaders(),
            body: JSON.stringify({ items })
        })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('discount-display').textContent = `-${data.discount_value}`;
                    document.getElementById('total-value').textContent = parseInt(data.final_total).toLocaleString('vi-VN') + ' VNĐ';
                    const discountEl = document.getElementById('discount-value');
                    if (discountEl) discountEl.dataset.discount = data.discount_raw || 0;
                }
            });
    }

    // Toast
    function showSuccessToast(msg) {
        const existing = document.getElementById('toast-success');
        if (existing) existing.remove();
        const toast = document.createElement('div');
        toast.id = 'toast-success';
        toast.className = 'custom-toast';
        toast.innerHTML = `
        <svg class="toast-icon" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="2"
            viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
        <span class="toast-message">${msg}</span>
        <button class="toast-close" onclick="this.parentElement.remove()">
            <svg xmlns="http://www.w3.org/2000/svg" class="toast-close-icon" fill="none" stroke="currentColor"
                stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
        </button>
        <div class="toast-progress"></div>
        `;
        document.body.appendChild(toast);
        setTimeout(() => toast.remove(), 4000);
    }
    function showErrorToast(msg) {
        const existing = document.getElementById('toast-error');
        if (existing) existing.remove();
        const toast = document.createElement('div');
        toast.id = 'toast-error';
        toast.className = 'custom-toast';
        toast.style.backgroundColor = '#dc2626';
        toast.innerHTML = `
        <svg class="toast-icon" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="2"
            viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M12 2a10 10 0 1010 10A10 10 0 0012 2z" /></svg>
        <span class="toast-message">${msg}</span>
        <button class="toast-close" onclick="this.parentElement.remove()">
            <svg xmlns="http://www.w3.org/2000/svg" class="toast-close-icon" fill="none" stroke="currentColor"
                stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
        </button>
        <div class="toast-progress" style="background-color: #f87171"></div>
        `;
        document.body.appendChild(toast);
        setTimeout(() => toast.remove(), 4000);
    }

    // Chọn tất cả
    checkAll?.addEventListener('change', () => {
        const isChecked = checkAll.checked;
        localStorage.setItem(CHECK_ALL_KEY, isChecked ? '1' : '0');
        checkboxes.forEach(cb => { if (!cb.disabled) cb.checked = isChecked; });
        updateSelectedIds();
        if (isChecked) {
            const selectedCount = [...checkboxes].filter(cb => !cb.disabled && cb.checked).length;
            if (selectedCount > 0) {
                showSuccessToast(`Đã chọn ${selectedCount} sản phẩm.`);
            } else {
                showErrorToast('Không có sản phẩm nào có thể chọn.');
                checkAll.checked = false;
            }
        }
    });

    // Chọn từng sản phẩm
    checkboxes.forEach(cb => {
        cb.addEventListener('change', () => {
            updateSelectedIds();
            const allAvailableChecked = [...checkboxes].filter(item => !item.disabled).every(item => item.checked);
            if (checkAll) {
                checkAll.checked = allAvailableChecked;
                localStorage.setItem(CHECK_ALL_KEY, allAvailableChecked ? '1' : '0');
            }
            if (cb.checked) showSuccessToast('Đã chọn sản phẩm thành công.');
        });
    });

    // Khôi phục trạng thái tick
    const checked = loadChecked();
    checkboxes.forEach(cb => {
        if (!cb.disabled && checked.includes(cb.value)) cb.checked = true;
    });
    updateSelectedIds();

    // Khôi phục check all
    const savedCheckAll = localStorage.getItem(CHECK_ALL_KEY);
    if (checkAll) {
        const availableCheckboxes = [...checkboxes].filter(cb => !cb.disabled);
        const allChecked = availableCheckboxes.every(cb => cb.checked);
        if (savedCheckAll === '1' && availableCheckboxes.length > 0 && allChecked) {
            checkAll.checked = true;
        } else {
            checkAll.checked = false;
            localStorage.setItem(CHECK_ALL_KEY, '0');
        }
    }

    // Cập nhật số lượng
    document.querySelectorAll('.form-update-qty').forEach(form => {
        const id = form.dataset.id;
        const input = form.querySelector('.quantity-input');
        const inc = form.querySelector('.btn-increase');
        const dec = form.querySelector('.btn-decrease');
        const errorBox = form.querySelector('.error-message');
        const maxQty = parseInt(input.dataset.max);
        const totalCell = form.closest('tr').querySelector('.item-total');

        function updateQty(newQty) {
            if (newQty > maxQty) {
                newQty = maxQty;
                input.value = newQty;
                errorBox.textContent = `Chỉ còn ${maxQty} sản phẩm trong kho.`;
                errorBox.classList.remove('hidden');
                setTimeout(() => errorBox.classList.add('hidden'), 4000);
            }
            if (newQty < 1) newQty = 1;
            fetch(`/cart/update/${id}`, {
                method: 'POST',
                headers: getHeaders(),
                body: JSON.stringify({ quantity: newQty })
            })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        input.value = newQty;
                        totalCell.textContent = data.item_total;
                        updateSelectedIds();
                        const productCheckbox = document.querySelector(`.item-checkbox[value="${id}"]`);
                        if (productCheckbox && productCheckbox.checked) showSuccessToast(data.message);
                    } else {
                        errorBox.textContent = data.message || 'Không thể cập nhật.';
                        errorBox.classList.remove('hidden');
                    }
                });
        }
        inc.addEventListener('click', () => updateQty(parseInt(input.value) + 1));
        dec.addEventListener('click', () => updateQty(parseInt(input.value) - 1));
        input.addEventListener('change', () => updateQty(parseInt(input.value) || 1));
    });

    // Giới hạn thanh toán
    formCheckout?.addEventListener('submit', e => {
        updateSelectedIds();
        const hasChecked = [...checkboxes].some(cb => cb.checked);
        if (!hasChecked) {
            e.preventDefault();
            showErrorToast('Vui lòng chọn ít nhất một sản phẩm để thanh toán.');
            return;
        }
        const tempValue = document.getElementById('temp-value')?.textContent || '0';
        const totalValue = parseInt(tempValue.replace(/[^\d]/g, ''));
        if (totalValue > 150_000_000) {
            e.preventDefault();
            showErrorToast('Tổng giá trị đơn hàng không được vượt quá 150 triệu đồng.');
            return;
        }
    });

    // Xóa sản phẩm
    formRemove?.addEventListener('submit', e => {
        const selected = [...checkboxes].filter(cb => cb.checked).map(cb => cb.value);
        if (selected.length === 0) {
            e.preventDefault();
            showErrorToast('Vui lòng chọn ít nhất một sản phẩm để xóa.');
        }
    });

    // Áp voucher
    voucherForm?.addEventListener('submit', e => {
        e.preventDefault();
        const selectedItems = [...checkboxes].filter(cb => cb.checked).map(cb => {
            const row = cb.closest('tr');
            const qty = row?.querySelector('.quantity-input')?.value || 1;
            return { id: cb.value, quantity: parseInt(qty) };
        });
        const code = voucherForm.querySelector('input[name="voucher_code"]')?.value.trim();
        if (!selectedItems.length) return showErrorToast('Phải chọn sản phẩm mới áp dụng mã.');
        if (!code) return showErrorToast('Vui lòng nhập mã giảm giá.');
        saveChecked(selectedItems.map(item => item.id));
        fetch('/cart/apply-voucher', {
            method: 'POST',
            headers: getHeaders(),
            body: JSON.stringify({ voucher_code: code, items: selectedItems })
        })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    showSuccessToast('Áp dụng mã giảm giá thành công.');
                    const url = new URL(location.href);
                    url.searchParams.set('voucher_applied', '1');
                    location.href = url.toString();
                } else {
                    showErrorToast(data.message || 'Áp dụng mã thất bại.');
                }
            });
    });

    // Disable hàng hết hàng
    document.querySelectorAll('tr[data-out-of-stock="1"]').forEach(row => {
        row.classList.add('opacity-60', 'bg-gray-50');
        row.querySelectorAll('.item-checkbox, .btn-decrease, .btn-increase, .quantity-input').forEach(el => {
            if (el) {
                el.disabled = true;
                if (el.tagName === 'INPUT') el.style.cursor = 'not-allowed';
            }
        });
    });

});
