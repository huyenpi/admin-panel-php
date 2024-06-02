<?php get_header(); ?>
<div id="main-content-wp" class="add-cat-page">
    <div class="wrap clearfix">
        <?php get_sidebar(); ?>
        <div id="content" class="fl-right">
            <div class="section" id="title-page">
                <div class="clearfix">
                    <h3 id="index" class="fl-left">Thêm sản phẩm mới</h3>
                </div>
                <?php echo get_result(); ?>
                <div class="section" id="detail-page">
                    <div class="section-detail">
                        <form method="POST" action="" enctype="multipart/form-data">
                            <label for="title">Tiêu đề</label>
                            <input type="text" name="product_title" id="title"
                                value="<?php echo set_value('product_title'); ?>">
                            <?php echo form_error('product_title'); ?>
                            <label for="title">Slug ( Friendly_url )</label>
                            <input type="text" name="slug" id="slug" value="<?php echo set_value('slug'); ?>">
                            <?php echo form_error('slug'); ?>
                            <label for="desc">Mô tả</label>
                            <textarea name="product_desc" id="desc"><?php echo set_value('product_desc'); ?></textarea>
                            <?php echo form_error('product_desc'); ?>
                            <label for="content">Nội dung</label>
                            <textarea name="product_content" id="content"
                                class="ckeditor"><?php echo set_value('product_content'); ?></textarea>
                            <?php echo form_error('product_content'); ?>
                            <label>Hình ảnh</label>
                            <div id="uploadFile">
                                <input type="file" name="thumb" id="thumb">
                                <img
                                    src="<?php echo !empty (set_value('upload_file')) ? set_value('upload_file') : "public/images/img-thumb.png"; ?>">
                                <?php echo form_error('product_thumb'); ?>
                            </div>

                            <?php if (!empty ($list_product_cat)) {
                                ?>

                                <label for="cat">Danh mục cha</label>
                                <select name="cat" id="cat">
                                    <option value="">-- Chọn danh mục --</option>
                                    <?php
                                    foreach ($list_product_cat as $product_cat_item) {
                                        ?>

                                        <option value="<?php echo $product_cat_item['product_cat_id'] ?>" <?php echo $product_cat_item['product_cat_id'] == set_value('product_cat_id') ? 'selected' : ''; ?>>
                                            <?php echo $product_cat_item['product_cat_title'] ?>
                                        </option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            <?php }
                            ?>
                            <?php echo form_error('product_id'); ?>
                            <label for='status'>Trạng thái</label>
                            <select name="status" id='status'>
                                <option value="public" <?php echo set_value('status') == 'public' || empty (set_value('status')) ? 'selected' : '' ?>>Công khai</option>
                                <option value="private" <?php echo set_value('status') == 'private' ? 'selected' : '' ?>>
                                    Riêng tư</option>
                            </select>
                            <label for="title">Số lượng</label>
                            <input type="number" name="quantity" id="quantity" value="<?php echo set_value('quantity'); ?>">
                            <?php echo form_error('quantity'); ?>
                            <br/>
                            <br/>
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