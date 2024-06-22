<?php 
return [
    'sepay_method_name' => env('sepay_method_name', ''),
    'ten_ngan_hang' => env('ten_ngan_hang', 'MBBank'),
    'so_tai_khoan' => env('so_tai_khoan', '1030123325001'),
    'chu_tai_khoan' => env('chu_tai_khoan', 'Nguyễn Ngọc Tuân'),
    'tien_to_thanh_toan' => env('tien_to_thanh_toan', 'MD'),
    'webhook_url' => env('webhook_url', 'https://nguyenngoctuan07.com/sepay/webhook'),
    'ma_bao_mat' => env('ma_bao_mat', '')
];