<?php

return [
    "titles" => [
        "news"=>[
            "add" => "Thêm tin tức",
            "list"=> "Danh sách tin tức",
            "edit"=> "Cập nhật tin tức"
        ],
        "news_cat"=>[
            "add" => "Thêm danh mục",
            "list"=> "Danh sách danh mục",
            "edit"=> "Cập nhật danh mục"
        ],
        "news_tag"=>[
            "add" => "Thêm tag",
            "list"=> "Danh sách tag",
            "edit"=> "Cập nhật tag"
        ],
        "news_box"=>[
            "add" => "Thêm box",
            "list"=> "Danh sách box",
            "edit"=> "Cập nhật box"
        ],
        "page"=>[
            "add" => "Thêm trang tĩnh",
            "list"=> "Danh sách trang tĩnh",
            "edit"=> "Cập nhật trang tĩnh"
        ]
    ],
    "table" => [
        "id" => "Stt",
        "created_at" => "Ngày tạo",
        "updated_at" => "Ngày sửa",
        "action" => "Thao tác",
        "news" => [
            "image" => "Ảnh",
            "url" => "Đường dẫn",
            "actions" => "Thao tác"
        ],
        "list_news" => [
            "title"=>"Tiêu đề",
            "author"=>"Người tạo",
            "category"=>"Chuyên mục",
            "status"=>"Trạng thái",
            'is_hot'=>"Tin hot",
            'priority'=> "Sắp xếp",
            'image'=> "Ảnh"
        ],
        "list_news_cat"=>[
            "title_cat_paren"=>"Chuyên mục cha"
        ]
    ],
    "form"=>[
        "tags_placeholder"=>"Nhập tag...",
        "boxs_placeholder"=>"Nhập box...",
        "desc_placeholder"=>"Nhập mô tả...",
        "title_placeholder"=>"Nhập title...",
        "seo_key_word_placeholder"=>"Nhập từ khóa seo...",
        "desc_seo_placeholder"=>"Nhập mô tả seo...",
        "priority_placeholder"=>"Nhập thứ tự sắp xếp...",
        "content_placeholder"=>"Nhập nội dung...",
        "text"=>[
            "title" => "Tiêu đề",
            "desc" => "Mô tả",
            "content" => "Nội dung",
            "cat" => "Chuyên mục",
            "tag" => "Tag",
            "box" => "Box",
            "image" => "Ảnh hiển thị",
            "news_hot" => "Tin hot",
            "news_normal" => "Tin thường",
            "priority" => "Sắp xếp",
            "key_seo" => "Danh sách từ khóa seo",
            "desc_seo" => "Mô tả seo",
            "news_text" => "Tin văn bản",
            "news_image" => "Tin ảnh"
        ],
    ],
    "label_cat"=>[
        "name_category" => "Tên chuyên mục",
        "checkbox" => "Chuyên mục con",   
    ],
    "label"=>[
        "name" => "Tên",
        "alias" => "Alias",
        "choise_image_display" => "Chọn ảnh đại diện",   
        "choise_image" => "Chọn ảnh",   
    ],
    "form_cat"=>[
        "category_placeholder" => "Nhập chuyên mục",   
    ],
    "buttons" => [
        "create" => "Thêm",
        "update"=> "Cập nhật",
        "discard" => "Hủy",
        "select_image"=> "Chọn ảnh",
        "change_image"=> "Sửa ảnh",
        "remove_image"=> "Xóa ảnh",
        "search"=> "Tìm kiếm"
    ],
    "messages" => [
        "success" => [
            "create" => "Thêm thành công",
            "update" => "Cập nhật thành công",
            "delete" => "Xóa thành công"
        ],
        "error" => [
            "permission" => "Permission lock",
            "create" => "Thêm thất bại",
            "update" => "Cập nhật thất bại",
            "delete" => "Xóa thất bại"
        ]
    ]
];