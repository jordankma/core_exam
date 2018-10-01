$(document).ready(function() {
	$('#form-register').bootstrapValidator({
        feedbackIcons: {
        },
        fields: {
            u_name: {
                validators: {
                    notEmpty: {
                        message: 'Bạn chưa nhập tên tên tài khoản'
                    },
                    stringLength: {
                        min: 3,
                        max: 30,
                        message: 'Tên đăng nhập phải ít nhất 3 đến 30 kí tự'
                    },
                    remote: {
                        // headers: {
                        //     'X-CSRF-TOKEN': $('input[name=_token]').val()//$('meta[name="csrf-token"]').attr('content')
                        // },
                        data: {
                            '_token': $('meta[name=csrf-token]').prop('content')
                        },
                        type: 'post',
                        message: 'Tên đăng nhập đã tồn tại',
                        url: '/admin/vne/member/member/check-username-exist',
                    }
                }
            },
            phone: {
                validators: {
                    notEmpty: {
                        message: 'Bạn chưa nhập số điện thoại'
                    },
                    stringLength: {
                        min: 10,
                        max: 11,
                        message: 'Số điện thoại phải 10 hoặc 11 số'
                    },
                    regexp: {
                        regexp: '^[0-9]*$',
                        message: 'Số điện thoại không đúng định dạng'
                    },
                    remote: {
                        // headers: {
                        //     'X-CSRF-TOKEN': $('input[name=_token]').val()//$('meta[name="csrf-token"]').attr('content')
                        // },
                        data: {
                            '_token': $('meta[name=csrf-token]').prop('content')
                        },
                        type: 'post',
                        message: 'Số điện thoại đã tồn tại',
                        url: '/admin/vne/member/member/check-phone-exist',
                    }
                }
            },
            password_reg: {
                validators: {
                    notEmpty: {
                        message: 'Bạn chưa nhập mật khẩu'
                    },
                    stringLength: {
                        min: 6,
                        max: 30,
                        message: 'Mật khẩu phải ít nhất 6 đến 30 kí tự'
                    }
                }
            },
            conf_password: {
                validators: {
                    notEmpty: {
                        message: 'Bạn chưa xác nhận mật khẩu'
                    },
                    identical: {
                        field: 'password_reg',
                        message: 'Mật khẩu không khớp nhau'
                    }
                }
            }
        },
            onSuccess: function(e, data) {
            e.preventDefault();
            var _crsfToken = $('meta[name=csrf-token]').prop('content');
            var u_name = $('input[name=u_name]').val();;
            var password = $('input[name=password_reg]').val();; 
            var phone = $('input[name=phone]').val();;
            var url = '/vne/member/member/register';
            $.post(url, {_token: _crsfToken, u_name: u_name, password: password,phone:phone}, function (result) {
	            if (!result.status) {
	                alert('false');
	            } else{
	            	// $('body').removeClass('active-registration');
	            	// $('body').addClass('active-login');
                    window.location.assign("http://exam.local.vn/cap-nhat-thong-tin");
	            }	    
            }, 'json');
        }
    });

	$('body').on('submit', "#form-login", function (event) {
        event.preventDefault();
        var _crsfToken = $('meta[name=csrf-token]').prop('content');
        var u_name = $('input[name=username]').val();;
        var password = $('input[name=password]').val();; 
        var url = '/login';
        $.post(url, {_token: _crsfToken, u_name: u_name, password: password}, function (result) {
            if (!result.status) {
                $('#form-login .help-block').text(result.messeger);
                $('#form-login .help-block').css('display','block');
                return false;
            }else{
                location.reload(true);
            }
        }, 'json');
    });
});