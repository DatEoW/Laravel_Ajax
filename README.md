# Tên Dự Án

Dự án về quản lý User và Product với đầy đủ các tính năng CRUD với phía Back-end là Laravel và phía Front-end dùng được thực hiện bởi Ajax. Ngoài ra dự án còn có các tính năng khác như phân quyền, đăng nhập, đăng xuất , tìm kiếm theo từ khóa,...

## Demo

Module Login: 
Chức Năng Validate: Kiểm tra các input nhập vào của email và password như ( không được trống, email đúng định dạng)
Chức Năng Kiểm tra tài khoản: Kiểm tra email và mật khẩu có hợp lệ,
Chức năng Renember me: Cập nhật renember_token mỗi khi tích vào check box renember_me ở trang đăng nhập
Module 2: Tính Năng Quản Lý User
Chức Năng CRUD: Giao diện phục vụ cho CRUD được tạo nên bởi Ajax khiến việc tương tác với database không tốn quá nhiều thời gian, tạo mới, sửa, xóa , khóa khi click vào sẽ xổ ra 1 popup giúp tiện lợi trong việc chỉnh sửa, phân quyền các tài khoản có quyền với trang User, user không thể tự xóa chính mình 
Chức Năng tìm kiếm: 
Module 3: Tính Năng 3
Chức Năng 3.1: Mô tả chức năng 3.1 của module 3.
Chức Năng 3.2: Mô tả chức năng 3.2 của module 3.
Tính Năng 4: Chức Năng 4
Chức Năng 4.1: Mô tả chức năng 4.1.
Chức Năng 4.2: Mô tả chức năng 4.2.

## Cài Đặt

Hướng dẫn cài đặt dự án trên máy cục bộ của người sử dụng.

```bash

composer install

php artisan migrate

php artisan db:seed --class=User

php artisan db:seed --class=Product

php artisan serve




