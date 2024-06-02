<?php

function delete_cat($id)
{
    return db_update("tbl_product_cats", array('status' => 'trash'), "product_cat_id IN ({$id})");
}

function update_product_cat($data, $where = "")
{
    return db_update("tbl_product_cats", $data, $where);
}

function get_product_cat_item($where)
{
    $where = !empty ($where) ? " WHERE " . $where : "";
    return db_fetch_row("SELECT * FROM tbl_product_cats{$where}");
}

function get_num_cat($where = "")
{
    if (!empty ($where)) {
        $where = " WHERE " . $where;
    }
    return db_num_rows("SELECT * FROM tbl_product_cats{$where}");
}

function get_info_cat($field, $id)
{
    $$field = "";
    $cat = array();
    if (!empty ($id)) {
        $cat = db_fetch_row("SELECT * FROM tbl_product_cats WHERE product_cat_id = {$id}");
    }
    if (!empty ($cat)) {
        $$field = $cat["{$field}"];
    }
    return !empty ($$field) ? $$field : "#";
}

function delete_product($where)
{
    return db_update("tbl_products", array('status' => 'trash'), $where);
}

function add_product_cat($data)
{
    return db_insert("tbl_product_cats", $data);
}

function get_cat_info($id, $field)
{
    $$field = "";
    if (!empty ($cat_item = db_fetch_row("SELECT * FROM tbl_product_cats WHERE product_cat_id = '{$id}'")))
        $$field = $cat_item["{$field}"];
    return $$field;
}

function add_product($data)
{
    return db_insert("`tbl_products`", $data);
}

function update_product($str_id, $data)
{
    return db_update("`tbl_products`", $data, "`product_id` IN ($str_id)");
}

function get_product($where = "")
{
    if (!empty ($where)) {
        $where = " WHERE " . $where;
    }
    return db_fetch_row("SELECT * FROM `tbl_products`{$where}");
}

function get_total_cat($where = "")
{
    if (!empty ($where)) {
        $where = "WHERE " . $where;
    }
    $total = db_num_rows("SELECT * FROM `tbl_product_cats`{$where}");
    return $total;
}

function get_num_product($where = "")
{

    if (!empty ($where)) {
        $where = " WHERE " . $where;
    }
    return db_num_rows("SELECT * FROM `tbl_products`{$where}");
}

function get_list_cat_per_page($start, $num_per_page, $where = "")
{
    if (!empty ($where)) {
        $where = "WHERE " . $where;
    }
    $list_cat = db_fetch_array("SELECT * FROM `tbl_product_cats`{$where} ORDER BY `product_cat_id` DESC LIMIT {$start},{$num_per_page}");
    if (!empty ($list_cat)) {
        foreach ($list_cat as &$cat) {
            $cat['url_edit'] = "?mod=product&controller=cat&act=edit&id={$cat['product_cat_id']}";
            $cat['url_delete'] = "?mod=product&controller=cat&act=delete&id={$cat['product_cat_id']}";
        }
    }
    return $list_cat;
}

function get_list_product_per_page($start, $num_per_page, $where = "")
{
    if (!empty ($where)) {
        $where = "WHERE " . $where;
    }
    $list_product = db_fetch_array("SELECT * FROM `tbl_products`{$where} ORDER BY `product_id` DESC LIMIT {$start},{$num_per_page}");
    foreach ($list_product as &$product_item) {
        $product_item['url_edit'] = "?mod=product&act=edit&id={$product_item['product_id']}";
        $product_item['url_delete'] = "?mod=product&act=delete&id={$product_item['product_id']}";
    }
    return $list_product;
}

;

function get_info_product_cat($where, $field)
{
    $product_item = db_fetch_row("SELECT * FROM `tbl_product_cats` WHERE $where");
    $$field = "";
    if (!empty ($product_item)) {
        $$field = $product_item["{$field}"];
    }
    return $$field;
}

function get_list_cat($where = "")
{
    if (!empty ($where)) {
        $where = " WHERE " . $where;
    }
    $list_cat = db_fetch_array("SELECT * FROM `tbl_product_cats`{$where}");
    return $list_cat;
}

function get_list_product($where = "")
{
    if (!empty ($where)) {
        $where = " WHERE " . $where;
    }
    $list_product = db_fetch_array("SELECT * FROM `tbl_products`{$where}");
    return $list_product;
}

?>