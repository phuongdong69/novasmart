<style>
    .custom-toast {
        position: fixed;
        top: 24px;
        right: 24px;
        z-index: 9999;
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 16px;
        min-width: 260px;
        max-width: 360px;
        background-color: #16a34a;
        color: #fff;
        border-radius: 6px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        animation: slideIn 0.3s ease-out;
        font-size: 14px;
        line-height: 1.4;
        transition: opacity 0.4s ease-out;
    }

    .toast-icon {
        width: 20px;
        height: 20px;
        stroke: #fff;
    }

    .toast-message {
        flex: 1;
        font-weight: 600;
    }

    .toast-close {
        background: transparent;
        border: none;
        color: #fff;
        cursor: pointer;
    }

    .toast-close-icon {
        width: 16px;
        height: 16px;
        stroke: #fff;
    }

    .toast-progress {
        position: absolute;
        bottom: 0;
        left: 0;
        height: 4px;
        background-color: #a3e635;
        animation: progressBar 4s linear forwards;
        width: 100%;
        border-bottom-left-radius: 6px;
        border-bottom-right-radius: 6px;
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateX(50%);
        }

        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes progressBar {
        from {
            width: 100%;
        }

        to {
            width: 0%;
        }
    }

    /* Custom scrollbar styles for variant options */
    .scrollbar-hide {
        -ms-overflow-style: none;  /* Internet Explorer 10+ */
        scrollbar-width: none;  /* Firefox */
    }
    .scrollbar-hide::-webkit-scrollbar {
        display: none;  /* Safari and Chrome */
    }

    /* Variant option styling to match the image */
    .variant-option {
        min-width: 120px;
        max-width: 120px;
        aspect-ratio: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        position: relative;
    }

    .variant-option:hover {
        transform: translateY(-1px);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    /* Button improvements */
    .btn-add-cart {
        position: relative;
        overflow: hidden;
    }
    
    .btn-add-cart:hover {
        transform: translateY(-1px);
    }
    
    .btn-add-cart:active {
        transform: translateY(0);
    }
    
    .wishlist-btn {
        position: relative;
        overflow: hidden;
    }
    
    .wishlist-btn:hover {
        transform: translateY(-1px);
        background-color: #ef4444 !important;
        color: white !important;
    }
    
    .wishlist-btn:active {
        transform: translateY(0);
    }
    
    .wishlist-btn.liked {
        background-color: #ef4444 !important;
        color: white !important;
    }
    
    .wishlist-btn.liked:hover {
        background-color: #dc2626 !important;
        color: white !important;
    }
    
    /* Responsive buttons */
    @media (max-width: 640px) {
        .btn-add-cart, .wishlist-btn {
            padding: 0.75rem 1rem;
            font-size: 0.875rem;
        }
    }
</style> 