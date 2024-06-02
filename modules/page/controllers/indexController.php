<?php

function construct() {
    load_model('index');
    load_model('user');
    load('lib', 'user');
    load('lib', 'validate');
    load('lib', 'slug');
}

function indexAction() {
    #Lọc theo trạng thái hoặc tiêu đề trang
    load('lib', 'pagging');
    #lấy tham status và keyword truyền trên url
    $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
    $keyword = !empty($_GET["keyword"]) ? $_GET["keyword"] : "";
    if (isset($_POST['btn-search'])) {
        $keyword = $_POST['search'];
        $page = 1;
    }
    $status = !empty($_GET["status"]) ? $_GET["status"] : "";
    # Tạo điều kiện lọc
    if (empty($status)) {
        $where = "`page_title` LIKE '%{$keyword}%'";
    } else {
        $where = "`page_title` LIKE '%{$keyword}%' AND status = '{$status}'";
    }
    #Phân trang
    $total = get_total($where);
    $num_per_page = 10;
    $num_page = ceil($total / $num_per_page);
    $start = $num_per_page * ($page - 1);
    #lấy danh sách trang truyền qua view
    $list_page = get_list_page_per_page($start, $num_per_page, $where);
    $data = array(
        'list_page' => $list_page,
        'num_per_page' => $num_per_page,
        'num_page' => $num_page,
        'page' => $page,
        'params' => array(
            'status' => $status,
            'keyword' => $keyword
        )
    );
    load_view('index', $data);
}

function addAction() {
    if (isset($_POST['btn-add'])) {
        global $error, $result, $upload_file, $page_title, $page_content, $slug, $status, $page_desc;
        $error = array();
        $result = array();
        $page_title = $_POST['title'];
        if (empty($page_title)) {
            $error['page_title'] = "Không được để trống tiêu đề trang";
        }

        $slug = $_POST['slug'];

        $page_desc = $_POST['desc'];
        $page_content = $_POST['content'];
        if (empty($page_content)) {
            $error['page_content'] = "Không được để trống nội dung trang";
        }
        if (!empty($_FILES['thumb']['name'])) {
            //thư mục chứa file sau khi upload
            $upload_dir = "public/uploads/";

            //đường dẫn của file sau khi upload
            $upload_file = $upload_dir . $_FILES['thumb']['name'];

            #xử lí upload đúng định dạng file ảnh: 
            $type_allow = array('png', 'jpg', 'gift', 'jpeg');
            $type = pathinfo($_FILES['thumb']['name'], PATHINFO_EXTENSION);
            if (!in_array(strtolower($type), $type_allow)) {
                $error['thumb_type'] = "Chỉ được upload file có đuôi png, jpg, jpeg, gift";
            }

            #upload file có dung lương cho phép (<20MB)
            $file_size = $_FILES['thumb']['size'];
            if ($file_size > 29000000) {
                $error['thumb_size'] = "Chỉ được upload file bé hơn 20MB";
            }
        }
        $status = $_POST['status'];
        if (empty($error)) {
            #kiểm tra trùng file trên hệ thống
            if (file_exists($upload_file)) {
                $file_name = pathinfo($_FILES['thumb']['name'], PATHINFO_FILENAME);
                $new_file_name = $file_name . " - Copy";
                $new_upload_file = $upload_dir . $new_file_name . ".{$type}";
                $k = 1;
                while (file_exists($new_upload_file)) {
                    $new_file_name = $file_name . " - Copy ({$k})";
                    $new_upload_file = $upload_dir . $new_file_name . ".{$type}";
                    $k++;
                }
                $upload_file = $new_upload_file;
            }
            #upload file lên hệ thống
            if (move_uploaded_file($_FILES['thumb']['tmp_name'], $upload_file)) {
                $is_upload_thumb = true;
            } else {
                $is_upload_thumb = false;
            };

            #lưu trang vào db
            if (empty($slug)) {
                $slug = "trang/" . create_slug($page_title) . ".html";
            }
            $data_page = array(
                'page_title' => $page_title,
                'slug' => $slug,
                'page_content' => $page_content,
                'page_desc' => $page_desc,
                'page_thumb' => $upload_file,
                'create_time' => time(),
                'status' => $status,
                'user_id' => get_user_id_login(user_login())
            );

            if (add_page($data_page) && $is_upload_thumb = true) {
                $alert = "Đã thêm trang thành công";
                redirect_to("?mod=page&result=success&alert={$alert}");
                exit();
            } elseif (add_page($data_page) && $is_upload_thumb = false) {
                $alert = "Đã thêm trang thành công. Tuy nhiên ảnh đại diện chưa được tải lên.";
                redirect_to("?mod=page&result=success&alert={$alert}");
                exit();
            } else {
                $result['fail'] = "Thêm trang không thành công.";
            };
        }
    }

    load_view('add');
}

function editAction() {
    $is_change = false;
    $str_id = $_GET['id'];
    $page_info = get_page_info($str_id);

    if (isset($_POST['btn-edit'])) {
        $is_change = true;
        global $error, $result, $upload_file, $page_title, $page_content, $slug, $status, $page_desc;
        $is_upload_thumb = false;
        $is_change_thumb = false;
        $error = array();
        $result = array();
        $page_title = $_POST['title'];
        if (empty($page_title)) {
            $error['page_title'] = "Không được để trống tiêu đề trang";
        }
        $slug = $_POST['slug'];
        $page_desc = $_POST['desc'];
        $page_content = $_POST['content'];
        if (empty($page_content)) {
            $error['page_content'] = "Không được để trống nội dung trang";
        }
        if (empty($_FILES['thumb']['name'])) {
            $upload_file = $page_info['page_thumb'];
        } else {
            $is_change_thumb = true;
            //thư mục chứa file sau khi upload
            $upload_dir = "public/uploads/";

            //đường dẫn của file sau khi upload
            $upload_file = $upload_dir . $_FILES['thumb']['name'];

            #xử lí upload đúng định dạng file ảnh: 
            $type_allow = array('png', 'jpg', 'gift', 'jpeg');
            $type = pathinfo($_FILES['thumb']['name'], PATHINFO_EXTENSION);
            if (!in_array(strtolower($type), $type_allow)) {
                $error['thumb_type'] = "Chỉ được upload file có đuôi png, jpg, jpeg, gift";
            }

            #upload file có dung lương cho phép (<20MB)
            $file_size = $_FILES['thumb']['size'];
            if ($file_size > 29000000) {
                $error['thumb_size'] = "Chỉ được upload file bé hơn 20MB";
            }
        }
        $status = $_POST['status'];
        if (empty($error)) {
            #kiểm tra trùng file trên hệ thống
            if ($is_change_thumb) {
                if (file_exists($upload_file)) {
                    $file_name = pathinfo($_FILES['thumb']['name'], PATHINFO_FILENAME);
                    $new_file_name = $file_name . " - Copy";
                    $new_upload_file = $upload_dir . $new_file_name . ".{$type}";
                    $k = 1;
                    while (file_exists($new_upload_file)) {
                        $new_file_name = $file_name . " - Copy ({$k})";
                        $new_upload_file = $upload_dir . $new_file_name . ".{$type}";
                        $k++;
                    }
                    $upload_file = $new_upload_file;
                }
                #upload file lên hệ thống
                if (move_uploaded_file($_FILES['thumb']['tmp_name'], $upload_file)) {
                    $is_upload_thumb = true;
                }
            }

            #lưu trang vào db
            if (empty($slug)) {
                $slug = "trang/" . create_slug($page_title) . ".html";
            }
            $data_page = array(
                'page_title' => $page_title,
                'slug' => $slug,
                'status' => $status,
                'page_content' => $page_content,
                'page_desc' => $page_desc,
                'page_thumb' => $upload_file,
                'create_time' => time(),
                'user_id' => get_user_id_login(user_login())
            );
            show_array($data_page);

            if (update_page($str_id, $data_page) && $is_upload_thumb = true) {
                $alert = "Đã cập nhật thông tin trang thành công";
                redirect_to("?mod=page&result=success&alert={$alert}");
                exit();
            } elseif (update_page($id, $data_page) && $is_upload_thumb = false) {
                $alert = "Đã cập nhật thông tin trang thành công. Tuy nhiên ảnh đại diện tải lên bị lỗi.";
                redirect_to("?mod=page&result=success&alert={$alert}");
                exit();
            } else {
                $result['fail'] = "Cập nhật không thành công.";
            };
        }
    }
    $page_info = get_page_info($str_id);
    $data = array(
        'is_change' => $is_change,
        'page_info' => $page_info
    );
    load_view('edit', $data);
}

function deleteAction() {
    $str_id = $_GET['id'];
    if (delete_page($str_id)) {
        $result = "success";
        $alert = "Xóa thành công";
    } else {
        $result = "fail";
        $alert = "Xóa thất bại";
    }
    redirect_to("?mod=page&result={$result}&alert={$alert}");
}

function multiAction() {
    #Nếu checkItem rống, thông báo cần chọn ít nhất 1 bản ghi.
    #Nếu actions = delete => join()
    #redirect_to
    if (isset($_POST['btn-submit'])) {
        if (empty($_POST['actions'])) {
            $result = "fail";
            $alert = "Chọn tác vụ phù hợp.";
            redirect_to("?mod=page&result={$result}&alert={$alert}");
            exit();
        } else {
            $action = $_POST['actions'];
        }
        if (empty($_POST['checkItem'])) {
            $result = "fail";
            $alert = "Cần chọn ít nhất 1 bản ghi";
            redirect_to("?mod=page&result={$result}&alert={$alert}");
            exit();
        }

        $str_id = $_POST['checkItem'][0];

        if ($action == 'delete') {
            $str_id = $str_id = join(',', $_POST['checkItem']);
        }
        redirect_to("?mod=page&act={$action}&id={$str_id}");
    }
}
