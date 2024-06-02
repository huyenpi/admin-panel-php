<?php get_header(); ?>
<div id="main-content-wp" class="change-pass-page">
    <div class="section" id="title-page">
        <div class="clearfix">
            <a href="?mod=user&controller=team&act=add" title="" id="add-new" class="fl-left">Thêm mới</a>
            <h3 id="index" class="fl-left">Cập nhật tài khoản</h3>
        </div>
    </div>
    <div class="wrap clearfix">
        <?php get_sidebar('user'); ?>
        <div id="content" class="fl-right">                       
            <div class="section" id="detail-page">
                <?php echo get_result(); ?> 
                <div class="section-detail">
                    <form method="POST">
                        <label for="current_password">Mật khẩu hiện tại</label>
                        <input type="password" name="current_password" id="current_password">
                        <?php echo form_error('current_password'); ?>
                        <label for="new-password">Mật khẩu mới</label>
                        <input type="password" name="new_password" id="new_password">
                        <?php echo form_error('new_password'); ?>
                        <label for="confirm_password">Xác nhận mật khẩu</label>
                        <input type="password" name="confirm_password" id="confirm_password">
                        <?php echo form_error('confirm_password'); ?>
                        <button type="submit" name="btn-reset" id="btn-reset">Cập nhật</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>