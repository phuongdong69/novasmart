<?php
// Script để thêm thẻ <br> vào file markdown
$input_file = 'NovaSmart_Complete_UseCase_Specifications.md';
$output_file = 'NovaSmart_Complete_UseCase_Specifications_Web.md';

// Đọc file gốc
$content = file_get_contents($input_file);

// Thêm <br> tags cho các dòng cần thiết
$patterns = [
    // Thêm <br> sau các tiêu đề
    '/(#+ .*?)\n/' => '$1<br><br>',
    
    // Thêm <br> sau các dòng danh sách
    '/(\d+\. .*?)\n/' => '$1<br>',
    '/(- .*?)\n/' => '$1<br>',
    
    // Thêm <br> sau các dòng có **
    '/(\*\*.*?\*\*: .*?)\n/' => '$1<br><br>',
    
    // Thêm <br> sau các dòng có ---
    '/(---)\n/' => '$1<br><br>',
    
    // Thêm <br> sau các dòng trống
    '/(\n\n)/' => '<br><br>',
];

// Áp dụng các pattern
foreach ($patterns as $pattern => $replacement) {
    $content = preg_replace($pattern, $replacement, $content);
}

// Ghi file mới
file_put_contents($output_file, $content);

echo "Đã tạo file $output_file với thẻ <br> tags!\n";
?>
