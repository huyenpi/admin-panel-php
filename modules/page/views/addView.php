<?php get_header(); ?>
<div id="main-content-wp" class="add-cat-page">
    <div class="wrap clearfix">
        <?php get_sidebar(); ?>
        <div id="content" class="fl-right">      
            <div class="section" id="title-page">
                <div class="clearfix">
                    <h3 id="index" class="fl-left">Thêm trang</h3>
                </div>
            </div>
            <div class="section" id="detail-page">
                <?php echo get_result(); ?>
                <div class="section-detail">
                    <form action="" method="POST" enctype="multipart/form-data">
                        <label for="title">Tiêu đề</label>
                        <input type="text" name="title" id="title" value="<?php echo set_value('page_title'); ?>">
                        <?php echo form_error('page_title'); ?>
                        <label for="title">Slug ( Friendly_url )</label>
                        <input type="text" name="slug" id="slug" value="<?php echo set_value('slug'); ?>">
                        <?php echo form_error('slug'); ?>
                        <label for="desc">Mô tả</label>
                        <textarea name="desc" id="desc"><?php echo set_value('page_desc'); ?></textarea>
                        <?php echo form_error('page_desc'); ?>
                        <label for="content">Nội dung</label>
                        <textarea name="content" id="content" class="ckeditor"><?php echo set_value('page_content'); ?></textarea>
                        <?php echo form_error('page_content'); ?>
                        <label>Hình ảnh</label>
                        <div id="uploadFile">
                            <input type="file" name="thumb" id="thumb">
                            <img src="public/images/img-thumb.png">
                        </div>
                        <?php echo form_error('thumb'); ?>
                        <?php echo form_error('thumb_type'); ?>
                        <?php echo form_error('thumb_size'); ?>
                        <label for="status">Trạng thái</label>
                        <select name="status" id="status">
                            <option value="">-- Chọn trạng thái --</option>
                            <option value="publish" <?php echo set_value('status') == 'publish' || empty(set_value('status')) ? 'selected' : '' ?>>Xuất bản</option>
                            <option value="pending" <?php echo set_value('status') == 'pending' ? 'selected' : '' ?>>Chờ duyệt</option>
                        </select>
                        <button type="submit" name="btn-add" id="btn-add">Lưu</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $("#thumb").change(function () {
            if (this.files && this.files[0]) {
                var fileReader = new FileReader();
                fileReader.onload = function (event) {
                    console.log(fileReader.result);
                    $('#uploadFile img').attr('src', event.target.result);
                };
                fileReader.readAsDataURL(this.files[0]);
            }
        });
    })
</script>
<?php get_footer(); ?>



