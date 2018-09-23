<?php

return [
    "titles" => [
        "member" => [
            "manage" => "Quản lý người dùng",
            "create" => "Tạo người dùng",
            "update" => "Cập nhật người dùng",
            "excel" => "Tải người dùng bằng file excel"
        ],
        "group" => [
            "manage" => "Quản lý nhóm người dùng",
            "create" => "Thêm nhóm người dùng",
            "update" => "Cập nhật nhóm người dùng",
            "add_member" => "Thêm người dùng vào nhóm"
        ]
    ],
    "table" => [
        "id" => "#",
        "created_at" => "Thời gian tạo",
        "updated_at" => "Thời gian cập nhật",
        "action" => "Thao tác",
        "status" => "Trạng thái",
        "member" => [
            "name"=> "Tên",
            "u_name"=> "Username",
            "email"=> "Email",
            "group"=> "Nhóm",
            "object"=> "Đối tượng",
            "address"=> "Địa chỉ",
            "trinh_do_chuyen_mon"=> "Học hàm học vị chuyên môn cao nhất",
            "trinh_do_ly_luan"=> "Lý luận Chính trị"
        ],
        "group" => [
            "name" => "Tên",
            "count" => "Số người dùng trong nhóm"
        ],
        "position" => [
            "name" => "Tên"
        ],
        "group" => [
            "name" => "Tên",
            "position"=> "Chức vụ",
            "id" => "ID"
        ]
    ],
    "form" => [
        "title" => [
            "name" => "Tên",
            "gender" => "Giới tính",
            "u_name" => "Username",
            "password" => "Mật khẩu",
            "conf_password" => "Xác nhận mật khẩu",
            "avatar" => "Ảnh đại diện",
            "address" => "Địa chỉ",
            "don_vi" => "Đơn vị",
            "birthday" => "Ngày sinh",
            "phone" => "Số điện thoại",
            "email" => "Email",
            "object" => "Đối tượng",
            "city" => "Thành phố",
            "district" => "Quận huyện",
            "school" => "Trường",
            "class" => "Lớp",
            "table" => "Bảng"
        ],
        "title_group" => [
            "name" => "Tên nhóm",
            "hot" => "Đoàn đại biểu bầu",
            "normal" => "Đoàn đại biểu thường",
            "desc" => "Mô tả",
            "image" => "Ảnh đại diện",
            "choise_image_display" => "Chọn đại diện",
        ],
        "title_position" => [
            "name" => "Tên chức vụ"
        ]
    ],
    "buttons" => [
        "create" => "Thêm",
        "discard" => "Hủy",
        "update" => "Cập nhật",
        "upload" => "Tải lên"
    ],
    "placeholder" => [
        "member" => [
            "name" => "Nhập tên",
            "u_name" => "Nhập tên tài khoản",
            "password" => "Nhập mật khẩu",
            "conf_password" => "Xác nhận mật khẩu",
            "avatar" => "Chọn ảnh đại diện",
            "address" => "Nhập địa chỉ",
            "birthday" => "Chọn ngày sinh",
            "phone" => "Nhập số điện thoại",
            "email" => "Nhập địa chỉ mail",
            "object" => "Chọn đối tượng"
        ],
        "group" => [
            "name" => "Nhập tên nhóm",
            "desc" => "Nhập mô tả"
        ]
    ],
    "messages" => [
        "success" => [
            "create" => "Thêm thành công",
            "update" => "Cập nhật thành công",
            "delete" => "Xóa thành công",
            "block" => "Khóa thành công",
            "add_member" => "Thêm người dùng thành công",
            "import" => "Thêm người dùng thành công"
        ],
        "error" => [
            "permission" => "Permission lock",
            "create" => "Thêm thất bại",
            "update" => "Cập nhật thất bại",
            "delete" => "Xóa thất bại",
            "block" => "Khóa thất bại",
            "add_member" => "Thêm người dùng thất bại",
            "import" => "Thêm người dùng thất bại"
        ]
    ]
];