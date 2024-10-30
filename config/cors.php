<?php

return [

    'paths' => ['api/*'], // Định nghĩa các đường dẫn cho phép CORS, bạn có thể thêm 'sanctum/csrf-cookie' nếu dùng Sanctum

    'allowed_methods' => ['*'], // Cho phép tất cả các phương thức HTTP (GET, POST, PUT, DELETE,...)

    'allowed_origins' => ['*'], // Cho phép tất cả các nguồn gốc (bạn có thể thay đổi * thành các domain cụ thể)

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'], // Cho phép tất cả các header

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => true, // Đặt là true nếu bạn cần gửi cookie (đặc biệt khi dùng với Laravel Sanctum)
];
