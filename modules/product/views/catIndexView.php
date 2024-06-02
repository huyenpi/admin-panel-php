<?php
get_header();
?>
<div id="main-content-wp" class="list-product-page">
    <div class="wrap clearfix">
        <?php get_sidebar(); ?>
        <div id="content" class="fl-right">
            <div class="section" id="title-page">
                <div class="clearfix">
                    <h3 id="index" class="fl-left">Danh sách danh mục sản phẩm</h3>
                    <a href="?mod=product&controller=cat&act=addProductCat" title="" id="add-new" class="fl-left">Thêm mới</a>
                </div>
            </div>
            <?php echo get_result(); ?>
            <div class="section" id="detail-page">
                <div class="section-detail">
                    <div class="filter-wp clearfix">
                        <ul class="post-status fl-left">
                            <li class="all"><a href="?mod=product&controller=cat">Tất cả <span class="count">(<?php echo get_num_cat(); ?>)</span></a> |</li>
                            <li class="all"><a href="?mod=product&controller=cat&status=public">Công khai <span class="count">(<?php echo get_num_cat("status = 'public'"); ?>)</span></a> |</li>
                            <li class="all"><a href="?mod=product&controller=cat&status=private">Riêng tư <span class="count">(<?php echo get_num_cat("status = 'private'"); ?>)</span></a> |</li>
                            <li class="all"><a href="?mod=product&controller=cat&status=trash">Thùng rác <span class="count">(<?php echo get_num_cat("status = 'trash'"); ?>)</span></a> |</li>
                        </ul>
                        <form method="POST" class="form-s fl-right">
                            <input type="text" name="search" id="s" value="<?php echo $params['keyword']; ?>">
                            <input type="submit" name="btn-search" value="Tìm kiếm">
                        </form>
                    </div>
                    <?php
                    if (!empty($list_cat)) {
                        ?>
                        <form method = 'POST' action="?mod=product&controller=cat&act=multi">
                            <div class="actions">
                                <select name="actions">
                                    <option value="">Tác vụ</option>
                                    <option value="edit">Chỉnh sửa</option>
                                    <option value="delete">Bỏ vào thùng rác</option>
                                </select>
                                <input type="submit" name="btn-submit" value="Áp dụng">
                            </div>
                            <div class="note">
                                <p><b>Lưu ý:</b> Tác vụ chỉnh sửa chỉ có thể thao tác với 1 bản ghi/ 1 lần thực hiện. Nếu có nhiều bản ghi được chọn sẽ ưu tiên bản ghi đầu tiên.
                            </div>
                            <div class="table-responsive">
                                <table class="table list-table-wp">
                                    <thead>
                                        <tr>
                                            <td><input type="checkbox" name="checkAll" id="checkAll"></td>
                                            <td><span class="thead-text">STT</span></td>
                                            <td><span class="thead-text">Tiêu đề</span></td>
                                            <td><span class="thead-text">Slug</span></td>
                                            <td><span class="thead-text">Cấp</span></td>
                                            <td><span class="thead-text">Danh mục cha</span></td>
                                            <td><span class="thead-text">Trạng thái</span></td>
                                            <td><span class="thead-text">Người tạo</span></td>
                                            <td><span class="thead-text">Thời gian</span></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 0;
                                        $array_status = array(
                                            'public' => 'Công khai',
                                            'private' => "Riêng tư",
                                            'trash' => 'Đã xóa'
                                        );
                                        foreach ($list_cat as $product_cat_item) {
                                            $i++;
                                            ?>

                                            <tr>
                                                <td><input type="checkbox" name="checkItem[]" value="<?php echo $product_cat_item['product_cat_id']; ?>"class="checkItem"></td>
                                                <td>
                                                    <span class="tbody-text"><?php echo $i; ?></span>
                                                </td>
                                                <td>
                                                    <div class="clearfix">
                                                        <div class="tb-title fl-left">
                                                            <a href="<?php echo $product_cat_item['url_edit']; ?>" title=""><?php echo $product_cat_item['product_cat_title']; ?></a>
                                                        </div>
                                                        <ul class="list-operation fl-right">
                                                            <li><a href="<?php echo $product_cat_item['url_edit']; ?>" title="Sửa" class="edit"><i class="fa fa-pencil" aria-hidden="true"></i></a></li>
                                                            <li><a href="<?php echo $product_cat_item['url_delete']; ?>" title="Xóa" class="delete"><i class="fa fa-trash" aria-hidden="true"></i></a></li>
                                                        </ul>
                                                    </div>
                                                </td>
                                                <td><span class="tbody-text"><?php echo $product_cat_item['slug']; ?></span></td>
                                                <td><span class="tbody-text"><?php echo $product_cat_item['level']; ?></span></td>
                                                <td><span class="tbody-text"><?php echo get_info_cat('product_cat_title', $product_cat_item['parent_cat_id']); ?></span></td>
                                                <td><span class="tbody-text status <?php echo $product_cat_item['status']; ?>"><?php echo $array_status[$product_cat_item['status']]; ?></span></td>
                                                <td><span class="tbody-text"><?php echo get_info_user($product_cat_item['user_id'], 'username'); ?></span></td>
                                                <td><span class="tbody-text"><?php echo date("d/m/Y h:m:s", $product_cat_item['create_time']); ?></span></td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                    </tbody>
                                    <tfoot>
                                       
                                    </tfoot>
                                </table>
                            </div>
                        </form>
                        <?php
                    } else {
                        ?>
                        <div class="empty">
                            <p>Không tìm được kết quả nào phù hợp.</p>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
            <div class="section" id="paging-wp">
                <div class="section-detail clearfix">
                    <ul id="list-paging" class="fl-right">
                        <?php echo get_pagging($page, $num_page, "?mod=product&controller=cat", $params) ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
get_footer();
?>
