let isSubmittingReview = false;

document.addEventListener("DOMContentLoaded", () => {
        (function () {
            const url = new URL(window.location.href);
            const isReload = performance.getEntriesByType("navigation")[0]?.type === "reload";

            if (isReload && url.searchParams.has('star')) {
                url.searchParams.delete('star');
                window.location.replace(url.toString());
            }
        })();
        const reviewItems = document.querySelectorAll('.review-item');
        const loadMoreBtn = document.getElementById('load-more-reviews');
        let visibleCount = 4; // Số đánh giá đang hiển thị
        const step = 3;       // Mỗi lần nhấn hiển thị thêm 3

        if (loadMoreBtn) {
            loadMoreBtn.addEventListener('click', function () {
                let shown = 0;
                for (let i = visibleCount; i < reviewItems.length && shown < step; i++) {
                    reviewItems[i].classList.remove('hidden');
                    shown++;
                }

                visibleCount += shown;

                if (visibleCount >= reviewItems.length) {
                    loadMoreBtn.classList.add('hidden'); // Ẩn nút nếu hiển thị hết
                }
            });
        }
    const stars = document.querySelectorAll('.star-select');
    const ratingInput = document.getElementById('review-rating');

    stars.forEach(star => {
        star.addEventListener('click', () => {
            const selected = parseInt(star.dataset.star);
            ratingInput.value = selected;

            stars.forEach((s, index) => {
                const icon = s.querySelector('i');
                if (index < selected) {
                    icon.classList.remove('mdi-star-outline');
                    icon.classList.add('mdi-star');
                } else {
                    icon.classList.remove('mdi-star');
                    icon.classList.add('mdi-star-outline');
                }
            });
        });
    });
    const popupLogin = document.getElementById("popup-login-required");

    ["toast-success", "toast-error"].forEach((id) => {
        const toast = document.getElementById(id);
        if (toast) setTimeout(() => toast.remove(), 4000);
    });

    document.querySelectorAll(".btn-write-review").forEach((btn) => {
    btn.addEventListener("click", (e) => {
        e.preventDefault();
        const variantId = btn.getAttribute("data-product-variant-id");

        if (!window.isLoggedIn) {
            closeReviewModal(); // 🔒 Đảm bảo modal review bị đóng nếu đang mở
            popupLogin?.classList.remove("hidden"); // ✅ Chỉ hiện login
            return;
        }

        openReviewModal(parseInt(variantId)); // ✅ Chỉ mở nếu đã đăng nhập
    });
    });

    document.body.addEventListener("click", (e) => {
        const popup = document.getElementById("review-modal");
        const box = popup?.querySelector(".popup-box");
        if (popup && e.target === popup) {
            closeReviewModal();
        }
        if (box && box.contains(e.target)) {
            e.stopPropagation();
        }
    });

    document.querySelectorAll("#review-stars i").forEach((star) => {
        star.addEventListener("click", () => {
            const selected = parseInt(star.dataset.star);
            const ratingInput = document.getElementById("review-rating");
            const stars = document.querySelectorAll("#review-stars i");

            if (ratingInput) ratingInput.value = selected;

            stars.forEach((s) => {
                const val = parseInt(s.dataset.star);
                s.classList.toggle("mdi-star", val <= selected);
                s.classList.toggle("mdi-star-outline", val > selected);
            });
        });
    });

    const form = document.querySelector("#review-form");
if (form) {
    form.addEventListener("submit", async (e) => {
        e.preventDefault();
        if (isSubmittingReview) return;
        isSubmittingReview = true;

        const submitBtn = form.querySelector("button[type='submit']");
        submitBtn.disabled = true;

        const formData = new FormData(form);

        // ✅ Luôn reload lại filter = all sau khi gửi đánh giá
        async function refreshReviewByAllFilter() {
            const cleanUrl = new URL(window.location.href);
            cleanUrl.searchParams.delete('star');

            try {
                const res = await fetch(cleanUrl.toString(), {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });

                const html = await res.text();
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');

                const newReviewList = doc.querySelector('#review-list-container');
                const newSummary = doc.querySelector('.bg-white.rounded-md.p-6.shadow.border.mb-6');

                if (newReviewList && newSummary) {
                    document.querySelector('#review-list-container').replaceWith(newReviewList);
                    bindLoadMoreReview();
                    document.querySelector('.bg-white.rounded-md.p-6.shadow.border.mb-6').replaceWith(newSummary);
                }

                updateFilterActiveState('all');
                window.history.replaceState({}, '', cleanUrl.toString());
            } catch (err) {
                console.error('Lỗi khi reload đánh giá:', err);
                showErrorToast('Không thể tải lại đánh giá.');
            }
        }

        try {
            const res = await fetch(form.action, {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                },
                body: formData,
            });

            const data = await res.json();

            if (data.success) {
                closeReviewModal();
                showSuccessToast(data.message || "Gửi đánh giá thành công!");

                const variantId = form.querySelector("input[name='product_variant_id']")?.value;

                if (data.data && variantId) {
    await refreshReviewByAllFilter(); // ✅ RESET VỀ FILTER "TẤT CẢ"

    // ✅ KHÔNG cần clone và prepend thủ công để tránh bị trùng đánh giá

    // ✅ Reset form và sao lại giao diện chấm sao
    form.reset();
    document.querySelectorAll("#review-stars i").forEach((i) => {
        i.classList.remove("mdi-star");
        i.classList.add("mdi-star-outline");
    });

    // ✅ Cập nhật tổng quan nếu có
    const { summary } = data.data;
    if (summary) updateRatingSummary(summary);
}
            } else {
                showErrorToast(data.message || "Đã có lỗi xảy ra.");
            }
        } catch (err) {
            console.error(err);
            showErrorToast("Lỗi gửi đánh giá.");
        } finally {
            isSubmittingReview = false;
            submitBtn.disabled = false;
        }
    });
}



    // ==========================
// Lọc đánh giá real-time
// ==========================
const filterButtons = document.querySelectorAll('.filter-button');

    function updateFilterActiveState(selectedStar) {
        // Normalize: nếu null hoặc rỗng → gán về 'all'
        selectedStar = selectedStar ?? 'all';

        filterButtons.forEach(btn => {
            btn.classList.remove('bg-blue-100', 'text-blue-600', 'border-blue-600');
            btn.classList.add('hover:bg-gray-100', 'text-gray-700');
        });

        const activeBtn = [...filterButtons].find(btn => {
            return btn.getAttribute('data-star') === selectedStar;
        });

        if (activeBtn) {
            activeBtn.classList.remove('hover:bg-gray-100', 'text-gray-700');
            activeBtn.classList.add('bg-blue-100', 'text-blue-600', 'border-blue-600');
        }
    }

    // ✅ Khi load trang
    let currentStar = new URLSearchParams(window.location.search).get('star');
    if (!currentStar) currentStar = 'all'; // ép về 'all' nếu không có ?star
    updateFilterActiveState(currentStar);

    // ✅ Bắt sự kiện click
    filterButtons.forEach(button => {
        button.addEventListener('click', async () => {
            const selectedStar = button.getAttribute('data-star');
            const url = new URL(window.location.href);

            if (selectedStar === 'all') {
                url.searchParams.delete('star');
            } else {
                url.searchParams.set('star', selectedStar);
            }

            try {
                const res = await fetch(url.toString(), {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });

                const html = await res.text();
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');

                const newReviewList = doc.querySelector('#review-list-container');
                const newSummary = doc.querySelector('.bg-white.rounded-md.p-6.shadow.border.mb-6');

                if (newReviewList && newSummary) {
                    document.querySelector('#review-list-container').replaceWith(newReviewList);
                    bindLoadMoreReview();
                    document.querySelector('.bg-white.rounded-md.p-6.shadow.border.mb-6').replaceWith(newSummary);

                    updateFilterActiveState(selectedStar);

                    // ✅ Xóa ?star khỏi URL sau khi lọc thành công
                    const cleanUrl = new URL(window.location.href);
                    if (cleanUrl.searchParams.has('star')) {
                        cleanUrl.searchParams.delete('star');
                        window.history.replaceState({}, '', cleanUrl.toString());
                    }
                }
            } catch (err) {
                console.error('Lỗi khi lọc đánh giá:', err);
                showErrorToast('Không thể lọc đánh giá.');
            }
        });
    });
    // ✅ Khi người dùng tải lại trang → tự động xóa ?star khỏi URL để reset về 'Tất cả'
const cleanUrl = new URL(window.location.href);
if (cleanUrl.searchParams.has('star')) {
    cleanUrl.searchParams.delete('star');
    window.history.replaceState({}, '', cleanUrl.toString());
}
});

// =============================
// Cập nhật tổng quan đánh giá
// =============================
function updateRatingSummary(summary) {
    const { average, total, breakdown } = summary;

    const avgElem = document.querySelector("#average-rating");
    if (avgElem) {
        avgElem.innerHTML = `${parseFloat(average).toFixed(1)}<span class="text-xl text-gray-500">/5</span>`;
    }

    const totalElem = document.querySelector("#total-rating-count");
    if (totalElem) {
        totalElem.textContent = `${total} lượt đánh giá`;
    }

    for (let star = 1; star <= 5; star++) {
        const percent = total ? (breakdown[star] / total) * 100 : 0;
        const bar = document.querySelector(`.rating-bar[data-star="${star}"]`);
        const count = document.querySelector(`.rating-count[data-star="${star}"]`);
        if (bar) bar.style.width = `${percent}%`;
        if (count) count.textContent = `${breakdown[star]} đánh giá`;
    }

    const starContainer = document.querySelector("#average-rating-icons");
    if (starContainer) {
        starContainer.innerHTML = "";
        const rounded = Math.round(average);
        for (let i = 1; i <= 5; i++) {
            const icon = document.createElement("i");
            icon.className = "mdi mdi-star" + (i <= rounded ? "" : "-outline");
            icon.classList.add("text-yellow-400", "text-xl");
            starContainer.appendChild(icon);
        }
    }
}

// =============================
// Modal
// =============================
function openReviewModal(productVariantId) {
    const modal = document.getElementById("review-modal");
    const input = document.getElementById("review-product-id");
    if (modal && input) {
        input.value = productVariantId;
        modal.classList.add("active");
    }
}

function closeReviewModal() {
    const modal = document.getElementById("review-modal");
    if (modal) {
        modal.classList.remove("active");
    }
}

// =============================
// Toast
// =============================
function showSuccessToast(message) {
    const existing = document.getElementById("toast-success");
    if (existing) existing.remove();

    const toast = document.createElement("div");
    toast.id = "toast-success";
    toast.className = "custom-toast";
    toast.innerHTML = `
        <svg class="toast-icon" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
        <span class="toast-message">${message}</span>
        <button class="toast-close" onclick="this.parentElement.remove()">
            <svg xmlns="http://www.w3.org/2000/svg" class="toast-close-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
        <div class="toast-progress"></div>
    `;
    document.body.appendChild(toast);
    setTimeout(() => toast.remove(), 4000);
}

function showErrorToast(message) {
    const existing = document.getElementById("toast-error");
    if (existing) existing.remove();

    const toast = document.createElement("div");
    toast.id = "toast-error";
    toast.className = "custom-toast";
    toast.style.backgroundColor = "#dc2626";
    toast.innerHTML = `
        <svg class="toast-icon" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M12 2a10 10 0 1010 10A10 10 0 0012 2z"/></svg>
        <span class="toast-message">${message}</span>
        <button class="toast-close" onclick="this.parentElement.remove()">
            <svg xmlns="http://www.w3.org/2000/svg" class="toast-close-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
        <div class="toast-progress" style="background-color: #f87171"></div>
    `;
    document.body.appendChild(toast);
    setTimeout(() => toast.remove(), 4000);
}
function bindLoadMoreReview() {
    const loadMoreBtn = document.getElementById('load-more-reviews');
    const reviewItems = document.querySelectorAll('.review-item');
    let visibleCount = 4;
    const step = 3;

    if (loadMoreBtn) {
        loadMoreBtn.addEventListener('click', function () {
            let shown = 0;
            for (let i = visibleCount; i < reviewItems.length && shown < step; i++) {
                reviewItems[i].classList.remove('hidden');
                shown++;
            }

            visibleCount += shown;

            if (visibleCount >= reviewItems.length) {
                loadMoreBtn.classList.add('hidden');
            }
        });
    }
}