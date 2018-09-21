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
        ],
        "position" => [
            "manage" => "Quản lý chức vụ",
            "create" => "Thêm chức vụ",
            "update" => "Cập nhật chức vụ"
        ],
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
            "position_current"=> "Chức vụ hiện tại",
            "position"=> "Chọn chức vụ được bầu",
            "group"=> "Đoàn",
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
            "u_name" => "Username",
            "gender" => "Giới tính",
            "password" => "Mật khẩu",
            "conf_password" => "Xác nhận mật khẩu",
            "avatar" => "Ảnh đại diện",
            "address" => "Địa chỉ",
            "don_vi" => "Đơn vị",
            "birthday" => "Năm sinh",
            "phone" => "Số điện thoại",
            "position" => "Chọn chức vụ được bầu",
            "doan" => "Đoàn",
            "position_current" => "Những chức vụ hiện tại",
            "trinh_do_ly_luan" => "Trình độ lý luận",
            "trinh_do_chuyen_mon" => "Trình độ chuyên môn",
            "email" => "Email",
            "dan_toc" => "Dân tộc",
            "ton_giao" => "Tôn giáo",
            "ngay_vao_dang" => "Ngày vào đảng",
            "ngay_vao_doan" => "Ngày vào đoàn"
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
            "position_text" => "Nhập chức vụ",
            "position_current" => "Nhập những chức vụ hiện tại",
            "position_select" => "Chọn chức vụ",
            "doan_select" => "Chọn đoàn",
            "trinh_do_ly_luan_text" => "Trình độ lý luận...",
            "trinh_do_ly_luan_select" => "Chọn trình độ lý luận...",
            "trinh_do_chuyen_mon_text" => "Trình độ chuyên môn...",
            "trinh_do_chuyen_mon_select" => "Chọn trình độ chuyên môn...",
            "email" => "Nhập địa chỉ mail",
            "dan_toc" => "Dân tộc...",
            "ton_giao" => "Tôn giáo...",
            "ngay_vao_dang" => "Ngày vào đảng...",
            "ngay_vao_doan" => "Ngày vào đoàn...",
            "don_vi" => "Đơn vị...",
        ],
        "group" => [
            "name" => "Nhập tên nhóm",
            "desc" => "Nhập mô tả"
        ],
        "position" => [
            "name" => "Nhập tên chức vụ"
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