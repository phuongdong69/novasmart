document.addEventListener("DOMContentLoaded", function () {
    const rules = {
        name: {
            required: true,
            message: "Vui lòng nhập họ tên"
        },
        phoneNumber: {
            required: true,
            regex: /^(0|\+84)[0-9]{9,10}$/,
            emptyMessage: "Vui lòng nhập số điện thoại",
            message: "Số điện thoại không hợp lệ"
        },
        email: {
            required: true,
            regex: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
            emptyMessage: "Vui lòng nhập email",
            message: "Email không hợp lệ"
        },
        address: {
            required: true,
            message: "Vui lòng nhập địa chỉ"
        }
    };

    const form = document.getElementById("checkout-form");
    if (!form) return;

    function validateField(field) {
        const input = document.getElementById(field);
        const errorSpan = document.getElementById(`${field}-error`);
        const rule = rules[field];
        const value = input?.value?.trim() || "";
        let valid = true;
        let message = rule.message;

        if (!input || !errorSpan) return true;

        if (rule.required && value === "") {
            valid = false;
            message = rule.emptyMessage || rule.message;
        } else if (rule.regex && !rule.regex.test(value)) {
            valid = false;
        }

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

    function validateSelectField() {
        const select = document.querySelector('select[name="payment_method"]');
        const errorSpan = document.getElementById("payment_method-error");
        let valid = true;

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

    // Gán sự kiện input để kiểm tra từng trường khi người dùng gõ
    Object.keys(rules).forEach(field => {
        const input = document.getElementById(field);
        input?.addEventListener("input", () => validateField(field));
    });

    document.querySelector('select[name="payment_method"]')?.addEventListener("change", validateSelectField);

    // Xử lý khi submit
    form.addEventListener("submit", function (e) {
        let isValid = true;

        Object.keys(rules).forEach(field => {
            if (!validateField(field)) isValid = false;
        });

        if (!validateSelectField()) isValid = false;

        if (!isValid) {
            e.preventDefault();
            const firstErrorInput = document.querySelector(".border-red-500");
            firstErrorInput?.scrollIntoView({ behavior: "smooth", block: "center" });
            return;
        }

        // Nếu hợp lệ → xử lý thay đổi route nếu chọn VNPay
        const paymentMethod = document.querySelector('select[name="payment_method"]')?.value;
        const vnpayRoute = form.getAttribute("data-vnpay-route");

        if (paymentMethod === "vnpay" && vnpayRoute) {
            form.setAttribute("action", vnpayRoute);
        } else {
            form.setAttribute("action", form.getAttribute("action")); // giữ nguyên nếu là COD
        }
    });
});
