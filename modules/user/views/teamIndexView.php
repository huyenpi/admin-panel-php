<?php get_header(); ?>
<div id="main-content-wp" class="list-post-page">
    <div class="section" id="title-page">
        <div class="clearfix">
            <a href="?mod=user&controller=team&act=add" title="" id="add-new" class="fl-left">Thêm mới</a>
            <h3 id="index" class="fl-left">Nhóm quản trị </h3>

        </div>
    </div>
    <div class="wrap clearfix">
        <?php get_sidebar('user'); ?>
        <div id="content" class="fl-right">
            <div class="section" id="detail-page">
                <div class="section-detail">
                    <div class="filter-wp clearfix">
                        <ul class="post-status fl-left">
                            <li class="all"><a href="">Tất cả <span class="count">(<?php echo get_total_member(); ?>)</span></a> |</li>
                            <li class="all"><a href="">Đanh hoạt động <span class="count">(<?php echo get_num_active_user(); ?>)</span></a> |</li>
                            <li class="pending"><a href="">Đã xóa <span class="count">(<?php echo get_num_deleted_user(); ?>)</span></a></li>
                        </ul>
                        <form action="?mod=user&controller=team" method="POST" class="form-s fl-right">
                            <input type="text" name="search" id="search" value="<?php echo $keyword; ?>">
                            <input type="submit" name="btn-search" value="Tìm kiếm">
                        </form>
                    </div>
                    <form method="POST" action="?mod=user&controller=team&act=multi" class="form-actions">
                        <div class="actions">
                            <select name="actions">
                                <option value="0">Tác vụ</option>
                                <option value="reset">Đổi mật khẩu</option>
                                <option value="edit">Cập nhật thông tin</option>
                                <option value="delete">Xóa</option>
                            </select>
                            <input type="submit" name="btn-submit" value="Áp dụng">

                        </div>
                        <?php echo get_result(); ?>
                        <div class="table-responsive">
                            <?php if (!empty($list_users)) {
                                ?>

                                <table class="table list-table-wp">
                                    <thead>
                                        <tr>
                                            <td><input type="checkbox" name="checkAll" id="checkAll"></td>
                                            <td><span class="thead-text">STT</span></td>
                                            <td><span class="thead-text">Họ tên</span></td>
                                            <td><span class="thead-text">ID</span></td>
                                            <td><span class="thead-text">Địa chỉ</span></td>
                                            <td><span class="thead-text">Số điện thoại</span></td>
                                            <td><span class="thead-text">Thời gian tạo</span></td>
                                            <td><span class="thead-text">Trạng thái</span></td>
                                            <td><span class="thead-text">Hành động</span></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = ($page - 1) * $num_per_page;
                                        foreach ($list_users as $user) {
                                            $i++;
                                            ?>
                                            <tr>
                                                <td><input type = "checkbox" name = "checkItem[]" value="<?php echo $user['user_id'] ?>" class = "checkItem"></td>
                                                <td><span class = "tbody-text"><?php echo $i; ?></h3></span>
                                                <td class = "clearfix">
                                                    <div class = "tb-title fl-left">
                                                        <span href = "" title = ""><?php echo $user['fullname']; ?></span>
                                                    </div>

                                                </td>
                                                <td><span class = "tbody-text"><?php echo $user['user_id']; ?></span></td>
                                                <td><span class = "tbody-text"><?php echo $user['address']; ?></span></td>
                                                <td><span class = "tbody-text"><?php echo $user['phone']; ?></span></td>
                                                <td><span class = "tbody-text"><?php echo date('d/m/Y h:m:s', $user['create_time']); ?></span></td>
                                                <td><span class = "tbody-text"><?php echo $user['status']; ?></span></td>
                                                <td class="clearfix"><ul class = "list-operation">
                                                        <li><a href ="<?php echo $user['url_edit']; ?>" title = "Sửa" class = "edit"><i class = "fa fa-pencil" aria-hidden = "true"></i></a></li>
                                                        <li><a href = "<?php echo $user['url_delete']; ?>" title = "Xóa" class = "delete"><i class = "fa fa-trash" aria-hidden = "true"></i></a></li>
                                                    </ul></td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                        <tr>
                                            <td><input type="checkbox" name="checkAll" id="checkAll"></td>
                                            <td><span class="thead-text">STT</span></td>
                                            <td><span class="thead-text">Họ tên</span></td>
                                            <td><span class="thead-text">ID</span></td>
                                            <td><span class="thead-text">Địa chỉ</span></td>
                                            <td><span class="thead-text">Số điện thoại</span></td>
                                            <td><span class="thead-text">Thời gian tạo</span></td>
                                            <td><span class="thead-text">Trạng thái</span></td>
                                            <td><span class="thead-text">Hành động</span></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <p>Lưu ý: Tác vụ đổi mật khẩu và cập nhật thông tin chỉ thực hiện được 1 bản ghi/ 1 lần thao tác. Khi có nhiều lựa chọn sẽ ưu tiên thực hiện lựa chọn đầu tiên.

                                    <?php
                                } else {
                                    ?>
                                <p class="empty">Không có kết quả nào phù hợp.</p>
                                <?php
                            }
                            ?>
                        </div>
                    </form>
                </div>
            </div>
            <div class="section" id="paging-wp">
                <div class="section-detail clearfix">
                    <ul id="list-paging" class="fl-right">
                        <?php echo get_pagging($page, $num_page, "?mod=user&controller=team", $keyword); ?>
                    </ul>
                </div>
            </div>

        </div>
    </div>
</div>
<?php get_footer(); ?>