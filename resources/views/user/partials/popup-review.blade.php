<div id="review-modal" class="hidden">
    <div class="popup-box">
        <button class="close-btn" onclick="closeReviewModal()">&times;</button>

        <h2 class="text-lg font-semibold text-center">Đánh giá & nhận xét</h2>

        <form id="review-form" action="{{ route('review.submit') }}" method="POST">
            @csrf
            <input type="hidden" name="product_variant_id" id="review-product-id">
            <input type="hidden" name="rating" id="review-rating" value="5">

            <div class="mb-4">
                <h4 class="font-semibold text-sm text-center mb-2">Đánh giá chung</h4>
                <div id="review-stars" class="grid grid-cols-5 gap-2 text-center text-sm">
                    @foreach ([1 => 'Rất tệ', 2 => 'Tệ', 3 => 'Bình thường', 4 => 'Tốt', 5 => 'Tuyệt vời'] as $value => $label)
                        <div class="flex flex-col items-center star-select cursor-pointer" data-star="{{ $value }}">
                            <i class="mdi mdi-star-outline text-2xl text-yellow-400"></i>
                            <span>{{ $label }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="mb-4">
                <label class="font-semibold block mb-1 text-sm">Bình luận</label>
                <textarea name="content" rows="4" class="w-full border rounded-md p-2 focus:outline-none focus:ring-1 focus:ring-orange-500 placeholder:text-sm"
                          placeholder="Hãy chia sẻ cảm nhận của bạn về sản phẩm..."></textarea>
            </div>

            <div class="text-center">
                <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-2 rounded-md font-semibold">
                    Gửi đánh giá
                </button>
            </div>
        </form>
    </div>
</div>
<style>
    #review-modal {
        position: fixed;
        inset: 0;
        z-index: 9999;
        display: none;
        align-items: center;
        justify-content: center;
        background-color: rgba(0, 0, 0, 0.5);
    }

    #review-modal.active {
        display: flex;
    }

    .popup-box {
        background-color: #fff;
        border-radius: 10px;
        padding: 32px 24px;
        width: 100%;
        max-width: 520px;
        position: relative;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
        animation: slideIn 0.3s ease-out;
    }

    .popup-box h2 {
        font-size: 20px;
        font-weight: 700;
        margin-bottom: 4px;
        text-align: center;
        color: #1f2937;
    }

    .popup-box p {
        text-align: center;
        font-size: 14px;
        color: #6b7280;
        margin-bottom: 20px;
    }

    .popup-box .close-btn {
        position: absolute;
        top: 12px;
        right: 16px;
        font-size: 24px;
        font-weight: bold;
        color: #888;
        background: none;
        border: none;
        cursor: pointer;
    }

    .popup-box .close-btn:hover {
        color: #f87171;
    }

    .popup-box h4 {
        font-size: 14px;
        font-weight: 600;
        margin-bottom: 12px;
        text-align: center;
        color: #111827;
    }

    #review-stars {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 10px;
        margin: 0 auto;
        justify-content: center;
        max-width: 100%;
    }

    .star-select {
        display: flex;
        flex-direction: column;
        align-items: center;
        cursor: pointer;
        user-select: none;
    }

    .star-select i {
        font-size: 28px;
        color: #facc15;
        transition: all 0.2s ease;
    }

    .star-select.active i,
    .star-select:hover i {
        color: #facc15 !important; /* Vàng */
    }

    .star-select span {
        margin-top: 4px;
        font-size: 13px;
        color: #374151;
    }

    .popup-box textarea {
        resize: vertical;
        font-size: 14px;
    }

    .popup-box button[type="submit"] {
        background-color: #f97316;
        color: white;
        padding: 10px 24px;
        border-radius: 6px;
        font-weight: 600;
        transition: background 0.3s ease;
        font-size: 15px;
    }

    .popup-box button[type="submit"]:hover {
        background-color: #ea580c;
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(40px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

<script src="{{ asset('assets/user/js/review.js') }}"></script>
