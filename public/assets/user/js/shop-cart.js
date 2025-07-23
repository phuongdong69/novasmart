// Khi DOM đã được tải đầy đủ
document.addEventListener('DOMContentLoaded', () => {
    // 🔑 Key dùng để lưu ID sản phẩm đã chọn trong localStorage
    const CHECKED_KEY = 'selected_cart_ids';

    // 📦 Kiểm tra URL có tham số voucher_applied không
    const urlParams = new URLSearchParams(location.search);
    const isVoucherJustApplied = urlParams.has('voucher_applied');

    // 🧱 Lấy các phần tử cần thiết trong DOM
    const checkboxes = document.querySelectorAll('.item-checkbox');
    const checkAll = document.getElementById('check-all');
    const formCheckout = document.getElementById('cart-actions-form');
    const formRemove = document.getElementById('remove-selected-form');
    const voucherForm = document.getElementById('voucher-form');

    // 🧹 Nếu không phải apply voucher, thì xoá checked_ids khỏi localStorage
    if (!isVoucherJustApplied) localStorage.removeItem(CHECKED_KEY);
    // ✅ Nếu có, thì xóa tham số khỏi URL sau khi xử lý
    if (isVoucherJustApplied) {
        const url = new URL(location.href);
        url.searchParams.delete('voucher_applied');
        history.replaceState({}, '', url.toString());
    }

    // 📋 Lấy headers cho fetch request (bao gồm CSRF token)
    function getHeaders() {
        return {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        };
    }

    // 💾 Lưu danh sách ID sản phẩm được chọn vào localStorage
    function saveChecked(ids) {
        localStorage.setItem(CHECKED_KEY, JSON.stringify(ids));
    }

    // 📤 Lấy danh sách ID sản phẩm đã được chọn từ localStorage
    function loadChecked() {
        try {
            return JSON.parse(localStorage.getItem(CHECKED_KEY)) || [];
        } catch {
            return [];
        }
    }

    // 🔁 Cập nhật danh sách ID được chọn (checkbox), hiển thị tổng tiền và tính lại voucher
    function updateSelectedIds() {
        const selectedIds = [...checkboxes].filter(cb => cb.checked).map(cb => cb.value);
        
        // Cập nhật tất cả input hidden trong form
        document.querySelectorAll('input[name="selected_ids"]').forEach(input => {
            input.value = selectedIds.join(',');
        });

        // Cập nhật form xoá
        const hiddenInputRemove = document.getElementById('selected-ids-remove');
        if (hiddenInputRemove) {
            hiddenInputRemove.value = selectedIds.join(',');
        }

        saveChecked(selectedIds);
        updateCartSummary(selectedIds);
        updateVoucher(selectedIds);
    }

    // 💰 Tính lại tổng tiền và cập nhật giao diện giỏ hàng
    function updateCartSummary(selectedIds) {
        let total = 0;

        // Tính tổng tiền của các sản phẩm được chọn
        selectedIds.forEach(id => {
            const row = [...checkboxes].find(cb => cb.value === id)?.closest('tr');
            if (!row) return;
            const text = row.querySelector('.item-total')?.textContent || '0';
            total += parseInt(text.replace(/[^\d]/g, '')) || 0;
        });

        const discountEl = document.getElementById('discount-value');
        const discount = parseInt(discountEl?.dataset.discount || 0);
        const final = total - discount;

        // Hiển thị tổng tạm tính và tổng cuối cùng
        document.getElementById('temp-value').textContent = total.toLocaleString('vi-VN') + ' VNĐ';
        document.getElementById('total-value').textContent = final.toLocaleString('vi-VN') + ' VNĐ';

        // Nếu không còn sản phẩm được chọn mà có áp dụng mã giảm, thì huỷ mã giảm
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

    // 🔄 Cập nhật lại giá trị giảm từ voucher dựa theo các item đang chọn
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

    // ⚠️ Hiển thị hộp lỗi tạm thời
    function showError(msg) {
        const box = document.getElementById('cart-error-box');
        if (!box) return;
        box.querySelector('.cart-error-message').textContent = msg;
        box.classList.remove('hidden');
        setTimeout(() => box.classList.add('hidden'), 4000);
    }

    // 📦 Gán sự kiện khi tick chọn sản phẩm
    checkboxes.forEach(cb => {
        cb.addEventListener('change', () => {
            updateSelectedIds();
            if (checkAll) checkAll.checked = [...checkboxes].every(cb => cb.checked);
        });
    });

    // ✅ Tick/untick tất cả sản phẩm
    if (checkAll) {
        checkAll.addEventListener('change', () => {
            checkboxes.forEach(cb => cb.checked = checkAll.checked);
            updateSelectedIds();
        });
    }

    // 🔃 Tải lại danh sách đã chọn khi load trang
    const checked = loadChecked();
    checkboxes.forEach(cb => cb.checked = checked.includes(cb.value));
    updateSelectedIds();

    // 🔢 Xử lý cập nhật số lượng sản phẩm
    document.querySelectorAll('.form-update-qty').forEach(form => {
        const id = form.dataset.id;
        const input = form.querySelector('.quantity-input');
        const inc = form.querySelector('.btn-increase');
        const dec = form.querySelector('.btn-decrease');
        const errorBox = form.querySelector('.error-message');
        const unitPrice = parseFloat(form.closest('tr').querySelector('.unit-price').dataset.price);
        const maxQty = parseInt(input.dataset.max);
        const totalCell = form.closest('tr').querySelector('.item-total');

        // 📝 Gửi request cập nhật số lượng
        function updateQty(newQty) {
            if (newQty > maxQty) {
                errorBox.textContent = `Chỉ còn ${maxQty} sản phẩm trong kho.`;
                errorBox.classList.remove('hidden');
                return;
            }
            if (newQty < 1) newQty = 1;

            errorBox.classList.add('hidden');

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
                } else {
                    errorBox.textContent = data.message || 'Không thể cập nhật.';
                    errorBox.classList.remove('hidden');
                }
            });
        }

        // ➕ ➖ Gán sự kiện cho nút tăng/giảm và input
        inc.addEventListener('click', () => updateQty(parseInt(input.value) + 1));
        dec.addEventListener('click', () => updateQty(parseInt(input.value) - 1));
        input.addEventListener('change', () => updateQty(parseInt(input.value) || 1));
    });

    // 🧾 Xử lý form thanh toán
    formCheckout?.addEventListener('submit', e => {
        updateSelectedIds();
        if (![...checkboxes].some(cb => cb.checked)) {
            e.preventDefault();
            showError('Vui lòng chọn ít nhất một sản phẩm để thanh toán.');
        }
    });

    // 🗑️ Xử lý form xoá sản phẩm
    formRemove?.addEventListener('submit', e => {
        const selected = [...checkboxes].filter(cb => cb.checked).map(cb => cb.value);
        if (selected.length === 0) {
            e.preventDefault();
            showError('Vui lòng chọn ít nhất một sản phẩm để xóa.');
        }
    });

    // 🎟️ Xử lý form áp dụng mã giảm giá
    voucherForm?.addEventListener('submit', e => {
        e.preventDefault();
        const selectedItems = [...checkboxes].filter(cb => cb.checked).map(cb => {
            const row = cb.closest('tr');
            const qty = row?.querySelector('.quantity-input')?.value || 1;
            return { id: cb.value, quantity: parseInt(qty) };
        });
        const code = voucherForm.querySelector('input[name="voucher_code"]')?.value.trim();
        if (!selectedItems.length) return showError('Phải chọn sản phẩm mới áp dụng mã.');
        if (!code) return showError('Vui lòng nhập mã giảm giá.');

        fetch('/cart/apply-voucher', {
            method: 'POST',
            headers: getHeaders(),
            body: JSON.stringify({ voucher_code: code, items: selectedItems })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                const url = new URL(location.href);
                url.searchParams.set('voucher_applied', '1');
                location.href = url.toString(); // Reload trang để cập nhật
            } else {
                showError(data.message || 'Áp dụng mã thất bại.');
            }
        });
    });
});
