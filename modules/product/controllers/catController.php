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
    //Hiển thị danh sách danh mục sản phẩm theo keyword
    $keyword = !empty ($_GET['keyword']) ? $_GET['keyword'] : "";
    $page = !empty ($_GET['page']) ? (int) $_GET['page'] : 1;
    $status = !empty ($_GET['status']) ? $_GET['status'] : "";

    if (isset ($_POST['btn-search'])) {
        $keyword = $_POST['search'];
        $page = 1;
    }
    if (empty ($status)) {
        $where = "`product_cat_title` LIKE '%{$keyword}%'";
    } else {
        $where = "status = '{$status}' AND `product_cat_title` LIKE '%{$keyword}%'";
    }
    $num_per_page = 5;
    $start = ($page - 1) * $num_per_page;
    $total_cat = get_total_cat($where);
    $num_page = ceil($total_cat / $num_per_page);
    $list_cat = get_list_cat_per_page($start, $num_per_page, $where);
    $data = array(
        'list_cat' => $list_cat,
        'page' => $page,
        'num_per_page' => $num_per_page,
        'num_page' => $num_page,
        'start' => $start,
        'params' => array(
            'keyword' => $keyword,
            'status' => $status
        ),
        'total_cat' => $total_cat
    );
    load_view('catIndex', $data);
}

function addProductCatAction()
{
    if (isset ($_POST['btn-add'])) {
        global $error, $result, $product_cat_title, $product_cat_desc, $slug, $status, $parent_cat;
        $error = array();
        $result = array();
        $product_cat_title = $_POST['title'];
        if (empty ($product_cat_title)) {
            $error['product_cat_title'] = "Không được để trống tên danh mục";
        }
        $product_cat_desc = $_POST['desc'];
        $slug = $_POST['slug'];

        $parent_cat = !empty ($_POST['parent-cat']) ? $_POST['parent-cat'] : NULL;
        $status = $_POST['status'];
        if (empty ($error)) {
            $level = 0;
            if (!empty ($parent_cat)) {
                $level = (int) get_cat_info('level', $parent_cat) + 1;
            }
            if (empty ($slug)) {
                $slug = "san-pham/" . create_slug($product_cat_title);
            }
            $data_cat = array(
                'product_cat_title' => $product_cat_title,
                'product_cat_desc' => $product_cat_desc,
                'slug' => $slug,
                'status' => $status,
                'create_time' => time(),
                'parent_cat_id' => $parent_cat,
                'level' => $level,
                'user_id' => get_user_id_login(user_login())
            );
            if (add_product_cat($data_cat)) {
                $result = 'success';
                $alert = "Thêm danh mục thành công.";
                redirect_to("?mod=product&controller=cat&result={$result}&alert={$alert}");
                exit();
            } else {
                $result['fail'] = "Thêm danh mục thất bại.";
            }
        }
    }
    $list_product_cat = get_list_cat();
    $data = array(
        'list_product_cat' => $list_product_cat
    );
    load_view('addProductCat', $data);
}

function editAction()
{
    $is_change = false;
    $id = (int) $_GET['id'];
    if (isset ($_POST['btn-edit'])) {
        $is_change = true;
        #Kiểm tra dữ liệu vào
        global $error, $result, $product_cat_title, $product_cat_desc, $slug, $status, $parent_cat;
        $error = array();
        $result = array();
        $product_cat_title = $_POST['title'];
        if (empty ($product_cat_title)) {
            $error['product_cat_title'] = "Không được để trống tên danh mục";
        }
        $product_cat_desc = $_POST['desc'];
        $slug = $_POST['slug'];

        $parent_cat = !empty ($_POST['parent-cat']) ? $_POST['parent-cat'] : NULL;
        $status = $_POST['status'];

        #kết luận
        if (empty ($error)) {
            $level = 0;
            if (!empty ($parent_cat)) {
                $level = (int) get_cat_info('level', $parent_cat) + 1;
            }
            if (empty ($slug)) {
                $slug = 'bai-viet/' . create_slug($product_cat_title);
            }
            $data_cat = array(
                'product_cat_title' => $product_cat_title,
                'product_cat_desc' => $product_cat_desc,
                'slug' => $slug,
                'status' => $status,
                'level' => $level,
                'parent_cat_id' => $parent_cat
            );
            if (update_product_cat($data_cat, "product_cat_id = {$id}")) {
                $result = 'success';
                $alert = "Cập nhật danh mục thành công.";
                redirect_to("?mod=product&controller=cat&result={$result}&alert={$alert}");
                exit();
            } else {
                $result['fail'] = "Cập nhậy danh mục thất bại.";
            }
        }
    }

    #lấy thông tin cat
    $product_cat_item = get_product_cat_item("product_cat_id = {$id}");
    $list_product_cat = get_list_cat();
    $data = array(
        'is_change' => $is_change,
        'product_cat_item' => $product_cat_item,
        'list_product_cat' => $list_product_cat
    );
    #load view
    load_view('editProductCat', $data);
}

function deleteAction()
{
    $id = $_GET['id'];
    if (delete_cat($id)) {
        $result = 'success';
        $alert = 'Xóa danh mục thành công';
    } else {
        $result = 'fail';
        $alert = 'Xóa danh mục thất bại';
    }
    redirect_to("?mod=product&controller=cat&result={$result}&alert={$alert}");
}

function multiAction()
{
    if (empty ($_POST['actions'])) {
        $result = 'fail';
        $alert = "Chưa chọn tác vụ";
        redirect_to("?mod=product&controller=cat&result={$result}&alert={$alert}");
        exit();
    }
    if (empty ($_POST['checkItem'])) {
        $result = 'fail';
        $alert = "Chọn ít nhất 1 bản ghi.";
        redirect_to("?mod=product&controller=cat&result={$result}&alert={$alert}");
        exit();
    }
    $action = $_POST['actions'];
    $array_id = $_POST['checkItem'];
    $id = $array_id[0];
    if ($action == 'delete')
        $id = join(',', $array_id);
    redirect_to("?mod=product&controller=cat&act={$action}&id={$id}");
}
