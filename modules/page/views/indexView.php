<?php get_header(); ?>
<div id="main-content-wp" class="list-post-page">
    <div class="wrap clearfix">
        <?php get_sidebar(); ?> 
        <div id="content" class="fl-right">           
            <div class="section" id="title-page">
                <div class="clearfix">
                    <h3 id="index" class="fl-left">Danh sách trang</h3>
                    <a href="?mod=page&act=add" title="" id="add-new" class="fl-left">Thêm mới</a>
                </div>
            </div>            
            <div class="section" id="detail-page">
                <div class="section-detail">
                    <div class="filter-wp clearfix">
                        <ul class="post-status fl-left">
                            <li class="all"><a href="?mod=page">Tất cả <span class="count">(<?php echo get_total_page(); ?>)</span></a> |</li>
                            <li class="publish"><a href="?mod=page&status=publish">Đã đăng <span class="count">(<?php echo get_num_page("status = 'publish'"); ?>)</span></a> |</li>
                            <li class="pending"><a href="?mod=page&status=pending">Chờ duyệt <span class="count">(<?php echo get_num_page("status = 'pending'"); ?>)</span></a> |</li>
                            <li class="trash"><a href="?mod=page&status=trash">Thùng rác <span class="count">(<?php echo get_num_page("status = 'trash'"); ?>)</span> |</a></li>
                        </ul>
                        <form method="POST" class="form-s fl-right">
                            <input type="text" name="search" id="search" value="<?php echo $params['keyword']; ?>">
                            <input type="submit" name="btn-search" value="Tìm kiếm">
                        </form>
                    </div>
                    <?php
                    if (empty($list_page)) {
                        ?>
                        <div class = 'empty'>
                            <p>Không có kết quả nào phù hợp.</p>
                        </div>

                        <?php
                    } else {
                        ?>

                        <form method = "POST" action = "?mod=page&act=multi" class = "form-actions">
                            <div class = "actions">
                                <select name = "actions">
                                    <option value = "">Tác vụ</option>
                                    <option value = "edit">Chỉnh sửa</option>
                                    <option value = "delete">Bỏ vào thùng rác</option>
                                </select>
                                <input type = "submit" name = "btn-submit" value = "Áp dụng">
                            </div>
                            <div class='note'>
                                <p><b>Lưu ý</b>: Tác vụ chỉnh sửa thông tin trang chỉ thực hiện được 1 bản ghi/ 1 lần thao tác. Khi có nhiều lựa chọn sẽ ưu tiên thực hiện lựa chọn đầu tiên.
                            </div>
                            <?php echo get_result();
                            ?>
                            <div class="table-responsive">
                                <table class="table list-table-wp">
                                    <thead>
                                        <tr>
                                            <td><input type="checkbox" name="checkAll" id="checkAll"></td>
                                            <td><span class="thead-text">STT</span></td>
                                            <td><span class="thead-text">Tiêu đề</span></td>
                                            <td><span class="thead-text">Ảnh đại diện</span></td>
                                            <td><span class="thead-text">slug</span></td>
                                            <td><span class="thead-text">Trạng thái</span></td>
                                            <td><span class="thead-text">Thời gian</span></td>
                                            <td><span class="thead-text">Người tạo</span></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <?php
                                            $i = ($page - 1) * $num_per_page;
                                            $status_array = array(
                                                'publish' => 'Đã đăng',
                                                'pending' => 'Chờ duyệt',
                                                'trash' => 'Đã xóa'
                                            );
                                            foreach ($list_page as $item) {
                                                $i++;
                                                ?>
                                                <td><input type = "checkbox" name = "checkItem[]" class = "checkItem" value="<?php echo $item['page_id'] ?>"></td>
                                                <td><span class = "tbody-text"><?php echo $i; ?></span>
                                                <td>
                                                    <div class='clearfix'>
                                                        <div class = "tb-title fl-left">
                                                            <a href = "<?php echo $item['url_edit'] ?>" title = ""><?php echo $item['page_title']; ?></a>
                                                        </div>
                                                        <ul class = "list-operation fl-right">
                                                            <li><a href = "<?php echo $item['url_edit'] ?>" title = "Sửa" class = "edit"><i class = "fa fa-pencil" aria-hidden = "true"></i></a></li>
                                                            <li><a href = "<?php echo $item['url_delete'] ?>" title = "Xóa" class = "delete"><i class = "fa fa-trash" aria-hidden = "true"></i></a></li>
                                                        </ul>
                                                    </div>
                                                </td>
                                                <td><div class = "tbody-img"><img src ="<?php echo!empty($item['page_thumb']) ? $item["page_thumb"] : "public/images/img-thumb.png"; ?>"/></div></td>
                                                <td><span class = "tbody-text"><?php echo!empty($item['slug']) ? $item['slug'] : "#"; ?></span></td>
                                                <td><span class = "tbody-text <?php echo 'status ' . $item['status']; ?>"><?php echo $status_array[$item['status']]; ?></span></td>
                                                <td><span class = "tbody-text"><?php echo date("d/m/Y h:m:s", $item['create_time']); ?></span></td>
                                                <td><span class = "tbody-text"><?php echo $item['fullname_user']; ?></span></td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td><input type="checkbox" name="checkAll" id="checkAll"></td>
                                            <td><span class="tfoot-text">STT</span></td>
                                            <td><span class="tfoot-text">Tiêu đề</span></td>
                                            <td><span class="tfoot-text">Ảnh đại diện</span></td>
                                            <td><span class="tfoot-text">slug</span></td>
                                            <td><span class="tfoot-text">Trạng thái</span></td>
                                            <td><span class="tfoot-text">Người tạo</span></td>
                                            <td><span class="tfoot-text">Thời gian</span></td>
                                        </tr>
                                    </tfoot>
                                </table>

                            </div>
                        </form>
                        <?php
                    }
                    ?>
                </div>
            </div>
            <div class="section" id="paging-wp">
                <div class="section-detail clearfix">
                    <ul id="list-paging" class="fl-right">
                        <?php echo get_pagging($page, $num_page, "?mod=page", $params); ?>
                    </ul>
                </div>
            </div>

        </div>
    </div>
</div>
<?php get_footer(); ?>
