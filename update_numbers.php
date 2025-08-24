<?php
// Script để cập nhật số thứ tự use case
$file = 'NovaSmart_Complete_UseCase_Specifications_Web.md';
$content = file_get_contents($file);

// Cập nhật các số thứ tự
$replacements = [
    '### 12. Xem Lịch Sử Đơn Hàng' => '### 14. Xem Lịch Sử Đơn Hàng',
    '### 13. Xem Chi Tiết Đơn Hàng' => '### 15. Xem Chi Tiết Đơn Hàng',
    '### 14. Hủy Đơn Hàng' => '### 16. Hủy Đơn Hàng',
    '### 15. Quản Lý Wishlist' => '### 17. Quản Lý Wishlist',
    '### 16. Thanh Toán Đơn Hàng' => '### 18. Thanh Toán Đơn Hàng',
    '### 17. Thanh Toán VNPay' => '### 19. Thanh Toán VNPay',
    '### 18. Đăng Xuất' => '### 20. Đăng Xuất',
    '### 19. Dashboard' => '### 21. Dashboard',
    '### 20. Quản Lý Người Dùng' => '### 22. Quản Lý Người Dùng',
    '### 21. Quản Lý Sản Phẩm' => '### 23. Quản Lý Sản Phẩm',
    '### 22. Quản Lý Danh Mục' => '### 24. Quản Lý Danh Mục',
    '### 23. Quản Lý Thương Hiệu' => '### 25. Quản Lý Thương Hiệu',
    '### 24. Quản Lý Đơn Hàng' => '### 26. Quản Lý Đơn Hàng',
    '### 25. Quản Lý Mã Giảm Giá' => '### 27. Quản Lý Mã Giảm Giá',
    '### 26. Quản Lý Tin Tức' => '### 28. Quản Lý Tin Tức',
    '### 27. Quản Lý Slideshow' => '### 29. Quản Lý Slideshow',
    '### 28. Quản Lý Thuộc Tính Sản Phẩm' => '### 30. Quản Lý Thuộc Tính Sản Phẩm',
    '### 29. Quản Lý Biến Thể Sản Phẩm' => '### 31. Quản Lý Biến Thể Sản Phẩm',
    '### 30. Xử Lý Thanh Toán VNPay' => '### 32. Xử Lý Thanh Toán VNPay',
    '### 31. Callback Xử Lý' => '### 33. Callback Xử Lý',
];

foreach ($replacements as $old => $new) {
    $content = str_replace($old, $new, $content);
}

// Cập nhật phần kết luận
$content = str_replace(
    'Tài liệu này cung cấp đặc tả chi tiết cho **31 use case chính**',
    'Tài liệu này cung cấp đặc tả chi tiết cho **33 use case chính**',
    $content
);

$content = str_replace(
    '- **10 use case** cho khách hàng chưa đăng nhập<br>',
    '- **12 use case** cho khách hàng chưa đăng nhập<br>',
    $content
);

$content = str_replace(
    '- **8 use case** cho người dùng đã đăng nhập<br>',
    '- **8 use case** cho người dùng đã đăng nhập<br>',
    $content
);

$content = str_replace(
    '- **11 use case** cho quản trị viên<br>',
    '- **11 use case** cho quản trị viên<br>',
    $content
);

$content = str_replace(
    '- **2 use case** cho hệ thống thanh toán<br><br>',
    '- **2 use case** cho hệ thống thanh toán<br><br>',
    $content
);

file_put_contents($file, $content);
echo "Đã cập nhật số thứ tự use case thành công!\n";
?>
