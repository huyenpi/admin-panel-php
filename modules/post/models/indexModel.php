<?php

function delete_cat($id) {
    return db_update("tbl_post_cats", array('status' => 'trash'), "post_cat_id IN ({$id})");
}

function update_post_cat($data, $where = "") {
    return db_update("tbl_post_cats", $data, $where);
}

function get_post_cat_item($where) {
    $where = !empty($where) ? " WHERE " . $where : "";
    return db_fetch_row("SELECT * FROM tbl_post_cats{$where}");
}

function get_num_cat($where = "") {
    if (!empty($where)) {
        $where = " WHERE " . $where;
    }
    return db_num_rows("SELECT * FROM tbl_post_cats{$where}");
}

function get_info_cat($field, $id) {
    $$field = "";
    $cat = array();
    if (!empty($id)) {
        $cat = db_fetch_row("SELECT * FROM tbl_post_cats WHERE post_cat_id = {$id}");
    }
    if (!empty($cat)) {
        $$field = $cat["{$field}"];
    }
    return !empty($$field) ? $$field : "#";
}

function delete_post($where) {
    return db_update("tbl_posts", array('status' => 'trash'), $where);
}

function add_post_cat($data) {
    return db_insert("tbl_post_cats", $data);
}

function get_cat_info($id, $field) {
    $$field = "";
    if (!empty($cat_item = db_fetch_row("SELECT * FROM tbl_post_cats WHERE post_cat_id = '{$id}'")))
        $$field = $cat_item["{$field}"];
    return $$field;
}

function add_post($data) {
    return db_insert("`tbl_posts`", $data);
}

function update_post($str_id, $data) {
    return db_update("`tbl_posts`", $data, "`post_id` IN ($str_id)");
}

function get_post($where = "") {
    if (!empty($where)) {
        $where = " WHERE " . $where;
    }
    return db_fetch_row("SELECT * FROM `tbl_posts`{$where}");
}

function get_total_cat($where = "") {
    if (!empty($where)) {
        $where = "WHERE " . $where;
    }
    $total = db_num_rows("SELECT * FROM `tbl_post_cats`{$where}");
    return $total;
}

function get_num_post($where = "") {

    if (!empty($where)) {
        $where = " WHERE " . $where;
    }
    return db_num_rows("SELECT * FROM `tbl_posts`{$where}");
}

function get_list_cat_per_page($start, $num_per_page, $where = "") {
    if (!empty($where)) {
        $where = "WHERE " . $where;
    }
    $list_cat = db_fetch_array("SELECT * FROM `tbl_post_cats`{$where} ORDER BY `post_cat_id` DESC LIMIT {$start},{$num_per_page}");
    if (!empty($list_cat)) {
        foreach ($list_cat as &$cat) {
            $cat['url_edit'] = "?mod=post&controller=cat&act=edit&id={$cat['post_cat_id']}";
            $cat['url_delete'] = "?mod=post&controller=cat&act=delete&id={$cat['post_cat_id']}";
        }
    }
    return $list_cat;
}

function get_list_post_per_page($start, $num_per_page, $where = "") {
    if (!empty($where)) {
        $where = "WHERE " . $where;
    }
    $list_post = db_fetch_array("SELECT * FROM `tbl_posts`{$where} ORDER BY `post_id` DESC LIMIT {$start},{$num_per_page}");
    foreach ($list_post as &$post_item) {
        $post_item['url_edit'] = "?mod=post&act=edit&id={$post_item['post_id']}";
        $post_item['url_delete'] = "?mod=post&act=delete&id={$post_item['post_id']}";
    }
    return $list_post;
}

;

function get_info_post_cat($where, $field) {
    $post_item = db_fetch_row("SELECT * FROM `tbl_post_cats` WHERE $where");
    $$field = "";
    if (!empty($post_item)) {
        $$field = $post_item["{$field}"];
    }
    return $$field;
}

function get_list_cat($where = "") {
    if (!empty($where)) {
        $where = " WHERE " . $where;
    }
    $list_post = db_fetch_array("SELECT * FROM `tbl_post_cats`{$where}");
    return $list_post;
}

function get_list_post($where = "") {
    if (!empty($where)) {
        $where = " WHERE " . $where;
    }
    $list_post = db_fetch_array("SELECT * FROM `tbl_posts`{$where}");
    return $list_post;
}

?>