<?php

function construct()
{
    //    echo "DÙng chung, load đầu tiên";
    load_model('index');
    load_model('user');
    load('lib', 'user');
    load('lib', 'pagging');
    load('lib', 'validate');
    load('lib', 'slug');
}

function indexAction()
{

    //Hiển thị danh sách bài viết theo status và theo title
    # Xác định tham số url
    $keyword = !empty($_GET['keyword']) ? $_GET['keyword'] : "";
    $page = !empty($_GET['page']) ? $_GET['page'] : 1;
    $status = !empty($_GET['status']) ? $_GET['status'] : "";

    if (isset($_POST['btn-search'])) {
        $keyword = $_POST['search'];
        $page = 1;
    }
    # Tạo điều kiện truy xuất dữ liệu theo trạng thái và tiêu đề
    $where = "";
    if (empty($status)) {
        $where = "`product_title` LIKE '%{$keyword}%'";
    } else {
        $where = "`product_title` LIKE '%{$keyword}%' AND `status` = '{$status}'";
    }
    # Phân trang và truy xuất dữ liệu theo trang
    $num_per_page = 5;
    $start = ($page - 1) * $num_per_page;
    $total_product = get_num_product($where);
    $num_page = ceil($total_product / $num_per_page);
    $list_product = get_list_product_per_page($start, $num_per_page, $where);
    # Chuản bị dữ liệu truyền lên view
    $data = array(
        'list_product' => $list_product,
        'page' => $page,
        'num_per_page' => $num_per_page,
        'num_page' => $num_page,
        'start' => $start,
        'params' => array(
            'status' => $status,
            'keyword' => $keyword
        )
    );
    # Load view
    load_view('index', $data);
}

function editAction()
{
    $is_change = false;
    $id = (int) $_GET['id'];
    $product_item = get_product("`product_id` = {$id}");
    if (isset($_POST['btn-edit'])) {
        $is_change = true;
        global $error, $result, $upload_file, $product_title, $quantity, $product_desc, $slug, $status, $product_content, $product_cat_id;
        $error = array();
        $resutl = array();
        $is_change_thumb = false;
        $is_upload_thumb = false;

        # Kiểm tra dữ liệu vào
        $product_title = $_POST['product_title'];
        if (empty($product_title)) {
            $error['product_title'] = "Không được để trống tiêu đề bài viết";
        }
        $product_desc = $_POST['product_desc'];
        if (empty($product_desc)) {
            $error['product_desc'] = "Không được để trống mô tả bài viết";
        }
        $quantity = $_POST['quantity'];
        if (empty($quantity)) {
            $error['quantity'] = "Không được để trống số lượng sản phẩm";
        }
        $slug = $_POST['slug'];
        $product_content = $_POST['product_content'];
        if (empty($product_content)) {
            $error['product_content'] = "Không được để trống nội dung bài viết";
        }
        if (empty($_FILES['thumb']['name'])) {
            $upload_file = $product_item['product_thumb'];
        } else {
            $is_change_thumb = true;
            $upload_dir = "public/uploads/";
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
        $product_cat_id = $_POST['cat'];
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
            if (empty($slug)) {
                $slug = "san-pham/" . create_slug($product_title);
            }
            #lưu trang vào db
            $data_product = array(
                'product_title' => $product_title,
                'slug' => $slug,
                'status' => $status,
                'quantity' => $quantity,
                'product_content' => $product_content,
                'product_desc' => $product_desc,
                'product_thumb' => $upload_file,
                'create_time' => time(),
                'product_cat_id' => $product_cat_id,
                'user_id' => get_user_id_login(user_login())
            );

            if (update_product($id, $data_product) && $is_upload_thumb = true) {
                $result = 'success';
                $alert = "Đã cập nhật thông tin bài viết thành công";
                redirect_to("?mod=product&result={$result}&alert={$alert}");
                exit();
            } elseif (update_product($id, $data_product) && $is_upload_thumb = false) {
                $result = 'success';
                $alert = "Đã cập nhật thông tin bài viết thành công. Tuy nhiên ảnh đại diện tải lên bị lỗi.";
                exit();
                redirect_to("?mod=product&result={$result}&alert={$alert}");
            } else {
                $result['fail'] = "Cập nhật không thành công.";
            }
            ;
        }
    }
    $product_item = get_product("`product_id` = {$id}");
    $list_product_cat = get_list_cat();
    $data = array(
        'is_change' => $is_change,
        'product_item' => $product_item,
        'list_product_cat' => $list_product_cat
    );
    load_view('edit', $data);
}

function addAction()
{
    if (isset($_POST['btn-add'])) {
        global $error, $result, $upload_file, $product_title, $product_desc, $quantity, $slug, $status, $product_content, $product_cat_id;
        $error = array();
        $result = array();

        $is_upload_thumb = false;
        $product_title = $_POST['product_title'];
        if (empty($product_title)) {
            $error['product_title'] = "Không được để trống tiêu đề bài viết";
        }
        $product_desc = $_POST['product_desc'];
        if (empty($product_desc)) {
            $error['product_desc'] = "Không được để trống mô tả bài viết";
        }
        $quantity = $_POST['quantity'];
        if (empty($quantity)) {
            $error['quantity'] = "Không được để trống số lượng sản phẩm";
        }

        $slug = $_POST['slug'];
        $product_content = $_POST['product_content'];
        if (empty($product_content)) {
            $error['product_content'] = "Không được để trống nội dung bài viết";
        }
        if (!empty($_FILES['thumb']['name'])) {
            $upload_dir = "public/uploads/";
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
        $product_cat_id = $_POST['cat'];
        if (empty($product_cat_id)) {
            $error['product_cat_id'] = "Không được để trống danh mục";
        }
        $status = $_POST['status'];
        if (empty($error)) {
            #kiểm tra trùng file trên hệ thống
            if (!empty($upload_file) && file_exists($upload_file)) {
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
            if (empty($slug)) {
                $slug = "san-pham/" . create_slug($product_title);
            }
            #lưu trang vào db
            $data_product = array(
                'product_title' => $product_title,
                'slug' => $slug,
                'product_content' => $product_content,
                'product_desc' => $product_desc,
                'product_thumb' => $upload_file,
                'status' => $status,
                'quantity' => $quantity,
                'create_time' => time(),
                'product_cat_id' => $product_cat_id,
                'user_id' => get_user_id_login(user_login())
            );
            show_array($data_product);

            if (add_product($data_product) && $is_upload_thumb = true) {
                $result = 'success';
                $alert = "Đã lưu bài viết thành công";
                redirect_to("?mod=product&result={$result}&alert={$alert}");
                exit();
            } elseif (add_product($data_product) && $is_upload_thumb = false) {
                $result = 'success';
                $alert = "Đã lưu bài viết thành công. Tuy nhiên ảnh đại diện tải lên bị lỗi.";
                redirect_to("?mod=product&result={$result}&alert={$alert}");
                exit();
            } else {
                $result['fail'] = "Cập nhật không thành công.";
            }
            ;
        }
    }
    $list_product_cat = get_list_cat();
    $data = array(
        'list_product_cat' => $list_product_cat
    );
    load_view("add", $data);
}

function deleteAction()
{
    $str_id = $_GET['id'];
    if (delete_product("product_id IN ({$str_id})")) {
        $result = "success";
        $alert = "Xóa thành công";
    } else {
        $result = "fail";
        $alert = "Xóa thất bại";
    }
    redirect_to("?mod=product&result={$result}&alert={$alert}");
}

function multiAction()
{
    if (isset($_POST['btn-submit'])) {
        if (empty($_POST['actions'])) {
            $result = "fail";
            $alert = "Chưa chọn tác vụ";
            redirect_to("?mod=product&result={$result}&alert={$alert}");
            exit();
        }
        if (empty($_POST['checkItem'])) {
            $result = "fail";
            $alert = "Chọn ít nhất 1 bản ghi";
            redirect_to("?mod=product&result={$result}&alert={$alert}");
            exit();
        }
        $id = $_POST['checkItem'][0];
        $action = $_POST['actions'];
        if ($_POST['actions'] == 'delete') {
            $array_id = $_POST['checkItem'];
            $id = join(',', $array_id);
        }
        redirect_to("?mod=product&act={$action}&id={$id}");
    }
}
