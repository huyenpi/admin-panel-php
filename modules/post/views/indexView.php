
<?php
get_header();
?>
<div id="main-content-wp" class="list-post-page">
    <div class="wrap clearfix">
        <?php get_sidebar(); ?>
        <div id="content" class="fl-right">
            <div class="section" id="title-page">
                <div class="clearfix">
                    <h3 id="index" class="fl-left">Danh sách bài viết</h3>
                    <a href="?mod=post&act=add" title="" id="add-new" class="fl-left">Thêm mới</a>
                </div>
            </div>
            <div class="section" id="detail-page">
                <div class="section-detail">
                    <div class="filter-wp clearfix">
                        <ul class="post-status fl-left">
                            <li class="all"><a href="?mod=post">Tất cả <span class="count">(<?php echo get_num_post(); ?>)</span></a> |</li>
                            <li class="publish"><a href="?mod=post&status=publish">Đã đăng <span class="count">(<?php echo get_num_post("`status` = 'publish'"); ?>)</span></a> |</li>
                            <li class="pending"><a href="?mod=post&status=pending">Chờ duyệt <span class="count">(<?php echo get_num_post("`status` = 'pending'"); ?>)</span></a></li>
                            <li class="trash"><a href="?mod=post&status=trash">Thùng rác <span class="count">(<?php echo get_num_post("`status` = 'trash'"); ?>)</span></a></li>
                        </ul>
                        <form method="POST" action="" class="form-s fl-right">
                            <input type="text" name="search" id="s" value="<?php echo $params['keyword']; ?>">
                            <input type="submit" name="btn-search" value="Tìm kiếm">
                        </form>
                    </div>
                    <?php
                    if (!empty($list_post)) {
                        ?>
                        <form method="POST" action="?mod=post&act=multi" class="form-actions">
                            <div class="actions">
                                <select name="actions">
                                    <option value="">Tác vụ</option>
                                    <option value="edit">Chỉnh sửa</option>
                                    <option value="delete">Bỏ vào thùng rác</option>
                                </select>
                                <input type="submit" name="btn-submit" value="Áp dụng">

                            </div>
                            <div class="note"
                                 <p><b>Lưu ý:</b> Tác vụ chỉnh sửa thông tin chỉ thực hiện được 1 bản ghi/ 1 lần thao tác. Khi có nhiều lựa chọn sẽ ưu tiên thực hiện lựa chọn đầu tiên.
                            </div>
                            <?php echo get_result(); ?>
                            <div class="table-responsive">
                                <table class="table list-table-wp">
                                    <thead>
                                        <tr>
                                            <td><input type="checkbox" name="checkAll" id="checkAll"></td>
                                            <td><span class="thead-text">STT</span></td>
                                            <td><span class="thead-text">Tiêu đề</span></td>
                                            <td><span class="thead-text">Ảnh đại diện</span></td>
                                            <td><span class="thead-text">Slug</span></td>
                                            <td><span class="thead-text">Danh mục</span></td>
                                            <td><span class="thead-text">Trạng thái</span></td>
                                            <td><span class="thead-text">Người tạo</span></td>
                                            <td><span class="thead-text">Thời gian</span></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 0;
                                        $status_array = array(
                                            'publish' => 'Đã đăng',
                                            'pending' => 'Chờ duyệt',
                                            'trash' => 'Đã xóa'
                                        );
                                        foreach ($list_post as $post_item) {
                                            $i++;
                                            ?>

                                            <tr>
                                                <td><input type="checkbox" name="checkItem[]" class="checkItem" value="<?php echo $post_item['post_id']; ?>"></td>
                                                <td><span class="tbody-text"><?php echo $i; ?></span>
                                                <td >
                                                    <div class="clearfix">
                                                        <div class="tb-title fl-left">
                                                            <a href="<?php echo $post_item['url_edit']; ?>" title=""><?php echo $post_item['post_title']; ?></a>
                                                        </div>
                                                        <ul class="list-operation fl-right">
                                                            <li><a href="<?php echo $post_item['url_edit']; ?>" title="Sửa" class="edit"><i class="fa fa-pencil" aria-hidden="true"></i></a></li>
                                                            <li><a href="<?php echo $post_item['url_delete']; ?>" title="Xóa" class="delete"><i class="fa fa-trash" aria-hidden="true"></i></a></li>
                                                        </ul>
                                                    </div>
                                                </td>
                                                <td><div class="tbody-img"><img src="<?php echo!empty($post_item['post_thumb']) ? $post_item['post_thumb'] : 'public/images/img-thumb.png'; ?>"/></div></td>
                                                <td><span class="tbody-text"><?php echo $post_item['slug']; ?></span></td>
                                                <td><span class="tbody-text"><?php echo get_info_post_cat("post_cat_id = {$post_item['post_cat_id']}", 'post_cat_title'); ?></span></td>
                                                <td><span class="tbody-text status <?php echo $post_item['status'] ?>"><?php echo $status_array[$post_item['status']]; ?></span></td>
                                                <td><span class="tbody-text"><?php echo get_info_user($post_item['user_id'], 'username'); ?></span></td>
                                                <td><span class="tbody-text"><?php echo date("d/m/Y h:m:s", $post_item['create_time']); ?></span></td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td><input type="checkbox" name="checkAll" id="checkAll"></td>
                                            <td><span class="thead-text">STT</span></td>
                                            <td><span class="thead-text">Tiêu đề</span></td>
                                            <td><span class="thead-text">Ảnh đại diện</span></td>
                                            <td><span class="thead-text">Slug</span></td>
                                            <td><span class="thead-text">Danh mục</span></td>
                                            <td><span class="thead-text">Trạng thái</span></td>
                                            <td><span class="thead-text">Người tạo</span></td>
                                            <td><span class="thead-text">Thời gian</span></td>
                                        </tr>
                                    </tfoot>
                                </table>


                            </div>
                        </form>
                        <?php
                    } else {
                        ?>
                        <div  class="empty">
                            <p>Không có kết quả nào phù hợp.</p>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
            <div class="section" id="paging-wp">
                <div class="section-detail clearfix">
                    <ul id="list-paging" class="fl-right">
                        <?php echo get_pagging($page, $num_page, "?mod=post", $params) ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
get_footer();
?>
