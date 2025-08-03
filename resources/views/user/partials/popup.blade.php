<div id="popup-login-required" class="popup-overlay hidden">
  <div class="popup-box" onclick="event.stopPropagation()">
    <h3 class="popup-title">Bạn chưa đăng nhập</h3>
    <p class="popup-message">
      Vui lòng đăng nhập để thêm sản phẩm vào giỏ hàng và trải nghiệm nhiều tiện ích hơn trên NovaSmart.
    </p>
    <div class="popup-actions">
      <a href="{{ route('register') }}" class="btn btn-outline">Đăng ký</a>
      <a href="{{ route('login') }}" class="btn btn-primary">Đăng nhập</a>
    </div>
    <button class="popup-close" onclick="document.getElementById('popup-login-required').classList.add('hidden')">×</button>
  </div>
</div>

<style>
.popup-overlay {
  position: fixed; inset: 0; background: rgba(0, 0, 0, 0.5);
  display: flex; justify-content: center; align-items: center;
  z-index: 1000;
}
.popup-box {
  background: white; padding: 24px; border-radius: 12px;
  text-align: center; max-width: 400px; width: 90%;
  position: relative;
}
.popup-title {
  font-size: 1.5em; font-weight: bold; color: #f97316;
}
.popup-message {
  margin: 16px 0;
  color: #4b5563;
}
.popup-actions a {
  margin: 0 8px; padding: 10px 16px; text-decoration: none;
}
.btn-primary {
  background: #f97316; color: white; border: none;
}
.btn-outline {
  border: 1px solid #f97316; color: #f97316; background: white;
}
.hidden {
  display: none;
}
.popup-close {
  position: absolute; top: 8px; right: 12px;
  background: none; border: none; font-size: 24px; cursor: pointer;
}
</style>

<script>
// Đóng popup khi click ra ngoài (overlay)
document.addEventListener('DOMContentLoaded', () => {
  const overlay = document.getElementById('popup-login-required');
  if (overlay) {
    overlay.addEventListener('click', () => {
      overlay.classList.add('hidden');
    });
  }
});
</script>
