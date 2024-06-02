<?php

function get_pagging($page, $num_page, $base_url, $params) {//?mod=product&act=main&cat_id=1
    $str_params = "";
    if (!empty($params)) {
        foreach ($params as $key => $value) {
            $str_params .= "&" . $key . "=" . $value;
        }
    }
    $str_pagging = "";
    if ($page > 1) {
        $page_pre = $page - 1;
        $str_pagging .= "<li ><a href='{$base_url}&page={$page_pre}{$str_params}'><<</a></li>";
    }
    for ($i = 1; $i <= $num_page; $i++) {
        $active = $i == $page ? "class='active'" : "";
        $str_pagging .= "<li {$active} ><a href='{$base_url}&page={$i}{$str_params}'>{$i}</a></li>";
    }
    if ($page < $num_page) {
        $page_next = $page + 1;
        $str_pagging .= "<li ><a href='{$base_url}&page={$page_next}{$str_params}'>>></a></li>";
    }
    return $str_pagging;
}

?>
