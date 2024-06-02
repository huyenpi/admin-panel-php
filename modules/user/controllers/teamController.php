<?php

function construct() {
    load_model('user');
    load('lib', 'user');
    load('lib', 'validate');
    load('lib', 'pagging');
}

function indexAction() {
//Lấy danh sách sản phẩm theo keysearch. Nếu không search, keysearch=""
    $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
    $keyword = isset($_GET['keyword']) ? $_GET['keyword'] : "";
    if (isset($_POST['btn-search'])) {
        $keyword = $_POST['search'];
    }
    $total = get_total_member("`fullname` LIKE '%{$keyword}%'");

    $num_per_page = 5;
    $num_page = ceil($total / $num_per_page);
    $start = $num_per_page * ($page - 1);

    $list_users = array();
    $list_users = get_list_user_per_page($start, $num_per_page, "`fullname` LIKE '%{$keyword}%'");
    $data = array(
        'list_users' => $list_users,
        'num_per_page' => $num_per_page,
        'num_page' => $num_page,
        'page' => $page,
        'keyword' => $keyword
    );
    load_view('teamIndex', $data);
}

function addAction() {
    if (isset($_POST['btn-add'])) {
        global $error, $result, $fullname, $username, $password, $phone, $address, $email;
        $error = array();
        $result = array();
//Kiểm tra 
        if (empty($_POST['fullname'])) {
            $error['fullname'] = "Không được để trống fullname";
        } else {
            $fullname = $_POST['fullname'];
        }
        if (empty($_POST['username'])) {
            $error['username'] = "Không được để trống tên đăng nhập";
        } else {
            if (!is_username($_POST['username'])) {
                $error['username'] = "Tên đăng nhập không đúng định dạng";
            } else {
                if (is_username_exists($_POST['username'])) {
                    $error['username'] = "Tên đăng nhập đã tồn tại";
                } else {
                    $username = $_POST['username'];
                }
            }
        }
        if (empty($_POST['email'])) {
            $error['email'] = "Không được để trống email";
        } else {
            if (!is_email($_POST['email'])) {
                $error['email'] = "Email không đúng định dạng";
            } else {
                if (is_email_exists($_POST['email'])) {
                    $error['email'] = "Email đã tồn tại";
                } else {
                    $email = $_POST['email'];
                }
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
//Kết luận
        if (empty($error)) {
//update
            $data = array(
                'fullname' => $fullname,
                'username' => $username,
                'email' => $email,
                'password' => md5($password),
                'phone' => $phone,
                'address' => $address,
                'create_time' => time()
            );
            if (add_user("`tbl_users`", $data)) {
                $result['success'] = "Lưu thành công.";
                $fullname = "";
                $username = "";
                $email = "";
                $password = "";
                $phone = "";
                $address = "";
            } else {
                $result['fail'] = "Lưu thất bại.";
            }
        }
    }
    $info_user = get_user_by_username(user_login());
    $data['info_user'] = $info_user;
    load_view('add');
}

function editAction() {
    $id = (int) $_GET['id'];

    if (isset($_POST['btn-edit'])) {
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
            if (update_user($id, $data)) {
                $result['success'] = "Cập nhật thông tin thành công.";
            } else {
                $result['fail'] = "Cập nhật thông tin thất bại.";
            }
        }
    }
    $info_user = get_user_by_id($id);
    $data['info_user'] = $info_user;
    load_view('edit', $data);
}

function deleteAction() {
    $str_id = $_GET['id'];
    if (delete_user($str_id)) {
        $result = 'success';
        $alert = "Xóa thành công.";
    } else {
        $result = 'fail';
        $alert = "Xóa thất bại.";
    }
    redirect_to("?mod=user&controller=team&result={$result}&alert={$alert}");
}

function resetAction() {
    global $error, $current_password, $new_password, $re_password, $result;
    if (isset($_POST['btn-reset'])) {
        $error = array();
        $result = array();
        $id = (int) $_GET['id'];
        #kiểm tra email
        if (empty($_POST['current_password'])) {
            $error['current_password'] = "Không được để trống mật khẩu hiện tại";
        } else {
            if (!is_password($_POST['current_password'])) {
                $error['current_password'] = "Mật khẩu hiện tại không đúng định dạng";
            } else {
                if (!is_current_password_by_id($id, md5($_POST['current_password']))) {
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
            if (update_user($id, $data)) {
                $result['success'] = "Thay đổi mật khẩu thành công.";
            } else {
                $result['fail'] = "Thay đổi mật khẩu thất bại.";
            }
        }
    }
    load_view('teamReset');
}

function multiAction() {
    $action = $_POST['actions'];
    $checkItem = $_POST['checkItem'];
    if ($action == 0) {
        redirect_to("?mod=user&controller=team");
    } else {
        if (empty($checkItem)) {
            $result = 'fail';
            $alert = 'Chọn ít nhất 1 bản ghi.';
            redirect_to("?mod=user&controller=team&result={$result}&alert={$alert}");
        } else {
            $str_id = $checkItem[0];
            if ($action == 'delete') {
                $str_id = join(',', $checkItem);
            }
            redirect_to("?mod=user&controller=team&act={$action}&id={$str_id}");
        }
    }
}

?>
