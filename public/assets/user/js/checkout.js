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

    const alertBox = document.getElementById("form-alert");
    const form = document.querySelector("form");

    function validateField(field) {
        const input = document.getElementById(field);
        const errorSpan = document.getElementById(`${field}-error`);
        const rule = rules[field];
        const value = input.value.trim();
        let valid = true;
        let message = rule.message;

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

    // Validate khi nhập vào input
    Object.keys(rules).forEach(field => {
        const input = document.getElementById(field);
        input.addEventListener("input", () => validateField(field));
    });

    // Validate khi thay đổi payment_method
    document.querySelector('select[name="payment_method"]').addEventListener("change", validateSelectField);

    // Validate khi submit
    form.addEventListener("submit", function (e) {
        let isValid = true;

        Object.keys(rules).forEach(field => {
            const fieldValid = validateField(field);
            if (!fieldValid) isValid = false;
        });

        const paymentValid = validateSelectField();
        if (!paymentValid) isValid = false;

        if (!isValid) {
            e.preventDefault();
            alertBox?.classList.remove("hidden");
            window.scrollTo({ top: alertBox.offsetTop - 20, behavior: "smooth" });
        }
    });
});
