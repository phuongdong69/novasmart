// Chờ cho DOM được tải đầy đủ rồi mới thực thi
document.addEventListener("DOMContentLoaded", function () {
    // Các quy tắc kiểm tra dữ liệu nhập của người dùng
    const rules = {
        name: {
            required: true,
            message: "Vui lòng nhập họ tên"
        },
        phoneNumber: {
            required: true,
            regex: /^(0|\+84)[0-9]{9,10}$/, // Số điện thoại bắt đầu bằng 0 hoặc +84, có 9-10 số
            emptyMessage: "Vui lòng nhập số điện thoại",
            message: "Số điện thoại không hợp lệ"
        },
        email: {
            required: true,
            regex: /^[^\s@]+@[^\s@]+\.[^\s@]+$/, // Regex kiểm tra định dạng email
            emptyMessage: "Vui lòng nhập email",
            message: "Email không hợp lệ"
        },
        address: {
            required: true,
            message: "Vui lòng nhập địa chỉ"
        }
    };

    // Lấy form checkout
    const form = document.getElementById("checkout-form");
    if (!form) return;

    // Hàm kiểm tra từng trường input theo rules
    function validateField(field) {
        const input = document.getElementById(field);
        const errorSpan = document.getElementById(`${field}-error`);
        const rule = rules[field];
        const value = input?.value?.trim() || "";
        let valid = true;
        let message = rule.message;

        if (!input || !errorSpan) return true;

        // Kiểm tra rỗng
        if (rule.required && value === "") {
            valid = false;
            message = rule.emptyMessage || rule.message;
        }
        // Kiểm tra regex nếu có
        else if (rule.regex && !rule.regex.test(value)) {
            valid = false;
        }

        // Hiển thị hoặc ẩn lỗi
        if (!valid) {
            input.classList.add("border-red-500");
            errorSpan.classList.remove("hidden");
            errorSpan.textContent = message;
        } else {
            input.classList.remove("border-red-500");
            errorSpan.classList.add("hidden");
        }

        return valid;
    }

    // Hàm kiểm tra xem người dùng đã chọn phương thức thanh toán chưa
    function validateSelectField() {
        const select = document.querySelector('select[name="payment_method"]');
        const errorSpan = document.getElementById("payment_method-error");
        let valid = true;

        if (!select || !errorSpan) return true;

        if (!select.value) {
            select.classList.add("border-red-500");
            errorSpan.classList.remove("hidden");
            errorSpan.textContent = "Vui lòng chọn phương thức thanh toán";
            valid = false;
        } else {
            select.classList.remove("border-red-500");
            errorSpan.classList.add("hidden");
        }

        return valid;
    }

    // Kiểm tra xem giá trị voucher có hợp lệ (không vượt quá tổng tiền)
    function validateVoucherAmount() {
        const originalTotalEl = document.getElementById("original-total");
        const discountEl = document.getElementById("discount-value");
        const errorSpan = document.getElementById("voucher-error");

        if (!originalTotalEl || !errorSpan) return true;

        const total = parseInt(originalTotalEl.dataset.amount || "0", 10);
        const discount = discountEl ? parseInt(discountEl.dataset.amount || "0", 10) : 0;

        const valid = (total - discount) >= 0;

        if (!valid) {
            errorSpan.textContent = "Giá trị giảm không hợp lệ, vượt quá tổng tiền!";
            errorSpan.classList.remove("hidden");
        } else {
            errorSpan.classList.add("hidden");
        }

        return valid;
    }

    // Lắng nghe sự kiện nhập vào các trường input để kiểm tra realtime
    Object.keys(rules).forEach(field => {
        const input = document.getElementById(field);
        if (input) {
            input.addEventListener("input", () => validateField(field));
        }
    });

    // Lắng nghe sự kiện thay đổi phương thức thanh toán
    const paymentSelect = document.querySelector('select[name="payment_method"]');
    paymentSelect?.addEventListener("change", validateSelectField);

    // Xử lý khi submit form
    form.addEventListener("submit", function (e) {
        let isValid = true;

        // Kiểm tra tất cả các trường input
        Object.keys(rules).forEach(field => {
            if (!validateField(field)) isValid = false;
        });

        // Kiểm tra select và voucher
        if (!validateSelectField()) isValid = false;
        if (!validateVoucherAmount()) isValid = false;

        // Nếu có lỗi thì chặn submit và scroll đến chỗ lỗi đầu tiên
        if (!isValid) {
            e.preventDefault();
            const firstError = document.querySelector(".border-red-500, #voucher-error:not(.hidden)");
            firstError?.scrollIntoView({ behavior: "smooth", block: "center" });
            return;
        }

        // Nếu người dùng chọn phương thức thanh toán là VNPay
        const paymentMethod = paymentSelect?.value;
        const vnpayRoute = form.getAttribute("data-vnpay-route");

        if (paymentMethod === "vnpay" && vnpayRoute) {
            e.preventDefault();

            // Lấy sản phẩm đã chọn từ localStorage
            const selectedIds = JSON.parse(localStorage.getItem("selected_cart_ids") || "[]");
            const cart = JSON.parse(localStorage.getItem("cart") || "[]");

            // Lọc các item được chọn
            const selectedCartItems = cart.filter(item =>
                selectedIds.includes(String(item.product_variant_id))
            );

            // Gom nhóm các sản phẩm trùng nhau
            const grouped = {};
            selectedCartItems.forEach(item => {
                const id = String(item.product_variant_id);
                if (!grouped[id]) {
                    grouped[id] = { ...item, quantity: 0 };
                }
                grouped[id].quantity += parseInt(item.quantity);
            });

            // Lưu lại cart mới vào localStorage
            const mergedCart = Object.values(grouped);
            localStorage.setItem("cart", JSON.stringify(mergedCart));
            localStorage.setItem("selected_cart_ids", JSON.stringify(mergedCart.map(i => String(i.product_variant_id))));

            // Tạo input ẩn chứa danh sách sản phẩm để gửi lên server
            let input = form.querySelector('input[name="selected_items"]');
            if (!input) {
                input = document.createElement("input");
                input.type = "hidden";
                input.name = "selected_items";
                form.appendChild(input);
            }
            input.value = mergedCart.map(item => item.product_variant_id).join(",");

            // Chuyển form sang route thanh toán của VNPay
            form.setAttribute("action", vnpayRoute);

            // Vô hiệu hoá nút submit để tránh submit lại
            const submitBtn = form.querySelector("button[type=submit]");
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.textContent = "Đang chuyển hướng đến VNPay...";
            }

            form.submit();
        }
    });
});
