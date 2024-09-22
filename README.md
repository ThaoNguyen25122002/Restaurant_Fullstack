Công Nghệ Sử Dụng
Frontend:

Vue.js - Framework JavaScript tiến tiến cho giao diện người dùng.
Inertia.js - Kết nối giữa Laravel và Vue.js để xây dựng SPA mà không cần API.
Backend:

Laravel - Framework PHP mạnh mẽ.
Khác:

Composer - Quản lý phụ thuộc PHP.
Node.js & npm - Môi trường chạy JavaScript và quản lý gói.
Cài Đặt
Yêu Cầu Hệ Thống
Trước khi bắt đầu, hãy đảm bảo bạn đã cài đặt các công cụ sau trên máy tính của mình:

PHP >= 8.0
Composer
Node.js >= 14.x và npm
MySQL hoặc bất kỳ cơ sở dữ liệu nào được hỗ trợ bởi Laravel
Git

Cài Đặt Backend (Laravel)
1.Clone Repository:
git clone https://github.com/username/your-project.git
cd your-project

2.Cài Đặt Các Phụ Thuộc PHP:
composer install

3.Sao Chép Tệp .env:
cp .env.example .env

4.Cấu Hình Tệp .env:
Mở tệp .env và chỉnh sửa các thông tin cấu hình như sau:
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password

Cài Đặt Frontend (Vue.js)
1.Cài Đặt Các Phụ Thuộc Node:
npm install
your-project/
├── app/
│ ├── Http/
│ │ ├── Controllers/
│ │ │  
│ │ └── Middleware/
│ ├── Models/
│ └── ...
├── bootstrap/
├── config/
├── database/
│ ├── migrations/
│ └── seeders/
├── public/
├── resources/
│ ├── js/
│ │ ├── Components/
│ │ ├── Pages/
│ │ └── app.js
│ ├── views/
│ │ └── app.blade.php
│ └── css/
├── routes/
│ ├── api.php
│ └── web.php
├── tests/
├── .env
├── composer.json
├── package.json
└── README.md

Mô Tả Chi Tiết
app/: Chứa mã nguồn backend của Laravel, bao gồm Controllers, Models, Middleware, v.v.
bootstrap/: Các tệp khởi động cho Laravel.
config/: Cấu hình của ứng dụng Laravel.
database/: Bao gồm migrations và seeders cho cơ sở dữ liệu.
public/: Thư mục public chứa các tệp tĩnh như hình ảnh, CSS, JS biên dịch.
resources/:
js/: Mã nguồn frontend của Vue.js.
Components/: Các component Vue tái sử dụng.
Pages/: Các trang chính sử dụng trong ứng dụng.
app.js: Tệp khởi tạo Vue.js.
views/: Các view Blade của Laravel sử dụng Inertia.js.
css/: Các tệp CSS tùy chỉnh.
routes/: Định nghĩa các route của ứng dụng.
api.php: Các API route.
web.php: Các web route.
tests/: Các test case cho ứng dụng.
.env: Tệp cấu hình môi trường.
composer.json: Quản lý phụ thuộc PHP.
package.json: Quản lý phụ thuộc Node.js.
README.md: Tệp hướng dẫn này.

Chạy Dự Án
1.Chạy Backend
php artisan serve

2.Chạy Frontend
npm run dev
