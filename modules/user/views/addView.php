<?php get_header(); ?>
<div id="main-content-wp" class="info-account-page">
    <div class="section" id="title-page">
        <div class="clearfix">
            <a href="?mod=user&controller=team&act=add" title="" id="add-new" class="fl-left">Thêm mới</a>
            <h3 id="index" class="fl-left">Thêm thành viên mới</h3>
        </div>
    </div>
    <div class="wrap clearfix">
        <?php get_sidebar('user'); ?>
        <div id="content" class="fl-right">                       
            <div class="section" id="detail-page">
                <?php echo get_result(); ?> 
                <div class="section-detail">
                    <form action="?mod=user&controller=team&act=add" method="POST">
                        <label for="fullname">Họ và tên</label>
                        <input type="text" name="fullname" id="fullname" value="<?php echo set_value('fullname'); ?>">
                        <?php echo form_error('fullname'); ?>
                        <label for="username" >Tên đăng nhập</label>
                        <input type="text" name="username" id="username" value="<?php echo set_value('username'); ?>" placeholder="admin">
                        <?php echo form_error('username'); ?>
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" value="<?php echo set_value('email'); ?>">
                        <?php echo form_error('email'); ?>
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" value="<?php echo set_value('password'); ?>">
                        <?php echo form_error('password'); ?>
                        <label for="phone">Số điện thoại</label>
                        <input type="number" name="phone" id="phone" value="<?php echo set_value('phone'); ?>">
                        <?php echo form_error('phone'); ?>
                        <label for="address">Địa chỉ</label>
                        <textarea name="address" id="address"><?php echo set_value('address'); ?></textarea>
                        <?php echo form_error('address'); ?>
                        <button type="submit" name="btn-add" id="btn-update">Lưu</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php get_footer();
?>


