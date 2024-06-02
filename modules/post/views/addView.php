<?php get_header(); ?>
<div id="main-content-wp" class="add-cat-page">
    <div class="wrap clearfix">
        <?php get_sidebar(); ?>
        <div id="content" class="fl-right">
            <div class="section" id="title-page">
                <div class="clearfix">
                    <h3 id="index" class="fl-left">Thêm bài viết mới</h3>
                </div>
                <?php echo get_result(); ?>
                <div class="section" id="detail-page">
                    <div class="section-detail">
                        <form method="POST" action="" enctype="multipart/form-data">
                            <label for="title">Tiêu đề</label>
                            <input type="text" name="post_title" id="title" value="<?php echo set_value('post_title'); ?>">
                            <?php echo form_error('post_title'); ?>
                            <label for="title">Slug ( Friendly_url )</label>
                            <input type="text" name="slug" id="slug" value="<?php echo set_value('slug'); ?>">
                            <?php echo form_error('slug'); ?>
                            <label for="desc">Mô tả</label>
                            <textarea name="post_desc" id="desc"><?php echo set_value('post_desc'); ?></textarea>
                            <?php echo form_error('post_desc'); ?>
                            <label for="content">Nội dung</label>
                            <textarea name="post_content" id="content" class="ckeditor"><?php echo set_value('post_content'); ?></textarea>
                            <?php echo form_error('post_content'); ?>
                            <label>Hình ảnh</label>
                            <div id="uploadFile">
                                <input type="file" name="thumb" id="thumb">
                                <img src="<?php echo!empty(set_value('upload_file')) ? set_value('upload_file') : "public/images/img-thumb.png"; ?>">
                                <?php echo form_error('post_thumb'); ?>
                            </div>

                            <?php if (!empty($list_post_cat)) {
                                ?>

                                <label for="cat">Danh mục cha</label>
                                <select name="cat" id="cat">
                                    <option value="">-- Chọn danh mục --</option>
                                    <?php
                                    foreach ($list_post_cat as $cat_item) {
                                        ?>

                                        <option value="<?php echo $cat_item['post_cat_id'] ?>" <?php echo $cat_item['post_cat_id'] == set_value('post_cat_id') ? 'selected' : ''; ?>>
                                            <?php echo $cat_item['post_cat_title'] ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            <?php }
                            ?>
                            <?php echo form_error('post_cat_id'); ?>
                            <label for='status'>Trạng thái</label>
                            <select name="status" id='status'>
                                <option value="publish" <?php echo set_value('status') == 'publish' || empty(set_value('status')) ? 'selected' : '' ?>>Xuất bản</option>
                                <option value="pending" <?php echo set_value('status') == 'pending' ? 'selected' : '' ?>>Chờ duyệt</option>
                            </select>
                            <button type="submit" name="btn-add" id="btn-add">Cập nhật</button>
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



