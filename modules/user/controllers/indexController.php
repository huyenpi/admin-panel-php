<?php

function construct()
{
    //    echo "DÙng chung, load đầu tiên";
    load_model('user');
    load('lib', 'user');
    load('lib', 'validate');
    load('lib', 'email');
    load('lib', 'randomToken');

}

function indexAction()
{

}

function mailToResetAction()
{

    global $email, $error, $config, $result;
    //Xử lí xác nhận email trước khi reset mật khẩu
    if (isset($_POST['btn-mail-to-reset'])) {
        if (empty($_POST['email'])) {
            $error['email'] = "Vui lòng nhập email";
        } else if (!is_email($_POST['email'])) {
            $email = $_POST['email'];
            $error['email'] = "Email không hợp lệ";
        } else {
            $email = $_POST['email'];
            $user = get_user_by_email($email);
            if (empty($user)) {
                $error['email'] = "Email không tồn tại trong hệ thống";
                load_view('mailToReset');
                return;
            }
            $token = generateRandomToken();
            save_reset_token($email, $token, time());
            $sent_to_email = $email;
            $sent_to_fullname = "Thu Huyền";
            $subject = "Team Ismart: Yêu cầu khôi phục mật khẩu của bạn đã được chấp thuận";
            $content = "<p>Xin chào <b>{$sent_to_fullname}</b> </p>" .
                "<p>Hãy nhấn vào link bên dưới để thay đổi mật khẩu của bạn:</p>" .
                "<a href='{$config['base_url']}?mod=user&act=recoverPass&token={$token}'>Nhấn vào đây để thay đổi mật khẩu</a>";
            if (send_mail($sent_to_email, $sent_to_fullname, $subject, $content)) {
                $result['success'] = 'Chúng tôi đã gửi thư đến email của bạn.';
                load_view('notify');
                return;
            }

        }

    }
    load_view('mailToReset');
}
function recoverPassAction()
{
    global $error, $email, $config, $token, $new_password, $re_password, $result;

    $is_reset_token_valid = false;
    if (!empty($_GET['token'])) {
        $token = $_GET['token'];
        if (is_reset_token_exists($token)) {
            //Kiểm tra reset_token có hợp lệ hay không
            $reset_time = get_reset_time($token);
            if ((time() - $reset_time) < 120 * 60)
                $is_reset_token_valid = true;
        }
    }

    if (isset($is_reset_token_valid) && $is_reset_token_valid === false) {
        echo $is_reset_token_valid;
        $result['fail'] = "Yêu cầu thay đổi mật khẩu không hợp lệ hoặc đã hết hạn.";
        load_view('notify');
    }

    if (isset($is_reset_token_valid) && $is_reset_token_valid === true) {

        if (isset($_POST['btn-recover-pass'])) {
            $error = array();
            $result = array();
            if (empty($_POST['new_password'])) {
                $error['new_password'] = "Không được để trống mật khẩu mới";
            } else {
                if (!is_password($_POST['new_password'])) {
                    $error['new_password'] = "Mật khẩu mới không đúng định dạng";
                } else {
                    $new_password = $_POST['new_password'];
                }
            }
            if (empty($_POST['confirm_password'])) {
                $error['confirm_password'] = "Không được để trống xác nhận mật khẩu";
            } else {
                if (!is_password($_POST['confirm_password'])) {
                    $error['confirm_password'] = "Mật khẩu không đúng định dạng";
                } else {
                    if ($_POST['new_password'] != $_POST['confirm_password']) {
                        $error['confirm_password'] = "Mật khẩu không khớp";
                    }
                }
            }
            #kết luận
            if (empty($error)) {
                $data = array(
                    'password' => md5($new_password)
                );
                $user_id = get_user_id('reset_token', $token);
                if (update_user($user_id, $data)) {
                    $result['success'] = "Thay đổi mật khẩu thành công.";
                } else {
                    $result['fail'] = "Thay đổi mật khẩu thất bại. 
                    Đã có lỗi xảy ra hoặc bạn đã nhập mật khẩu cũ.";
                }
                load_view('notify');
                return;
            }
        }
        load_view('resetPass');
    }

}



function loginAction()
{
    global $error, $username, $password;
    if (isset($_POST['btn-login'])) {
        $error = array();
        if (empty($_POST['username'])) {
            $error['username'] = "Không được để trống tên đăng nhập";
        } else {
            if (!is_username($_POST['username'])) {
                $error['username'] = "Tên đăng nhập không đúng định dạng";
            } else {
                $username = htmlentities($_POST['username']);
            }
        }

        if (empty($_POST['password'])) {
            $error['password'] = "Không được để trống mật khẩu";
        } else {

            if (!is_password($_POST['password'])) {
                $error['password'] = "Mật khẩu không đúng định dạng";
            } else {
                $password = $_POST['password'];
            }
        }

        if (empty($error)) {
            if (is_user_exists($username, $password)) {
                //lưu trữ phiên đăng nhập
                $_SESSION['is_login'] = true;
                $_SESSION['username'] = $username;

                if (isset($_POST['remember_me'])) {
                    setcookie('is_login', true, time() + 3600, '/');
                    setcookie('username', $username, time() + 3600, '/');
                }
                //chuyển hướng vào trong hệ thống
                redirect_to();
            } else {
                $error['account'] = "Tên đăng nhập hoặc mật khẩu không tồn tại.";
            }
        }
    }
    load_view('login');
}

function resetAction()
{
    global $error, $current_password, $new_password, $re_password, $result;
    if (isset($_POST['btn-reset'])) {
        $error = array();
        $result = array();
        #kiểm tra email
        if (empty($_POST['current_password'])) {
            $error['current_password'] = "Không được để trống mật khẩu hiện tại";
        } else {
            if (!is_password($_POST['current_password'])) {
                $error['current_password'] = "Mật khẩu hiện tại không đúng định dạng";
            } else {
                if (!is_current_password(user_login(), md5($_POST['current_password']))) {
                    $error['current_password'] = "Mật khẩu không đúng";
                } else {
                    $current_password = $_POST['current_password'];
                }
            }
        }
        if (empty($_POST['new_password'])) {
            $error['new_password'] = "Không được để trống mật khẩu mới";
        } else {
            if (!is_password($_POST['new_password'])) {
                $error['new_password'] = "Mật khẩu mới không đúng định dạng";
            } else {
                $new_password = $_POST['new_password'];
            }
        }
        if (empty($_POST['confirm_password'])) {
            $error['confirm_password'] = "Không được để trống xác nhận mật khẩu";
        } else {
            if (!is_password($_POST['confirm_password'])) {
                $error['confirm_password'] = "Mật khẩu không đúng định dạng";
            } else {
                if ($_POST['new_password'] != $_POST['confirm_password']) {
                    $error['confirm_password'] = "Mật khẩu không khớp";
                }
            }
        }
        #kết luận
        if (empty($error)) {
            $data = array(
                'password' => md5($new_password)
            );
            if (update_user_login(user_login(), $data)) {
                $result['success'] = "Thay đổi mật khẩu thành công.";
            } else {
                $result['fail'] = "Thay đổi mật khẩu thất bại.";
            }
        }
    }
    load_view('reset');
}

function logoutAction()
{
    unset($_SESSION['is_login']);
    unset($_SESSION['username']);
    setcookie('is_login', true, time() - 3600, '/');
    setcookie('username', $username, time() - 3600, '/');
    redirect_to("?mod=user&act=login");
}

function updateAction()
{
    /* Cập nhật tài khoản
     * b1: tạo giao diện
     * b2: load lại thông tin cũ
     * b3: validate
     * b4: cập nhật thông tin
     */
    if (isset($_POST['btn-update'])) {
        //        show_array($_POST);
        global $error, $result;
        $error = array();
        $result = array();
        //Kiểm tra 
        if (empty($_POST['fullname'])) {
            $error['fullname'] = "Không được để trống fullname";
        } else {
            $fullname = $_POST['fullname'];
        }
        if (empty($_POST['phone'])) {
            $error['phone'] = "Không được để trống điện thoại";
        } else {
            if (!is_phone($_POST['phone'])) {
                $error['phone'] = "Số điện thoại không đúng định dạng";
            } else {
                $phone = $_POST['phone'];
            }
        }
        if (empty($_POST['address'])) {
            $error['address'] = "Không được để trống địa chỉ";
        } else {
            $address = $_POST['address'];
        }
        //        show_array($error);
        //Kết luận
        if (empty($error)) {
            //update
            $data = array(
                'fullname' => $fullname,
                'phone' => $phone,
                'address' => $address
            );
            if (update_user_login(user_login(), $data)) {
                $result['success'] = "Cập nhật thông tin thành công.";
            } else {
                $result['fail'] = "Cập nhật thông tin thất bại.";
            }
        }
    }
    $info_user = get_user_by_username(user_login());
    $data['info_user'] = $info_user;
    load_view('update', $data);
}
