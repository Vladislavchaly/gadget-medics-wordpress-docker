<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8"/>
    <meta http-equiv="Imagetoolbar" content="No"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php esc_html_e('Preview Form', 'fluentform') ?></title>
    <?php
    wp_head();
    ?>
    <style type="text/css">
        #ff_preview_header {
            width: 100%;
            background: #393939;
            padding: 10px 25px;
            color: white !important;
            border-top: 1px solid #616161;
        }

        .ff_preview_title {
            display: inline-block;
            font-weight: bold;
            color: white !important;
        }

        .ff_preview_action {
            display: inline-block;
            float: right;
            color: white !important;
        }

        .ff_preview_body {
            padding: 20px 30px 32px;
            background-color: #FFF;
            border: 1px solid #FFF;
            border-bottom: 4px solid #D3D3D3;
            max-width: 800px;
            margin: 30px auto;
        }

        div#ff_preview_top {
            padding: 0 0 20px;
            background-color: #F1F1F1;
            overflow: hidden;
        }

        .ff_preview_fotter {
            margin-top: 30px;
            display: block;
            overflow: hidden;
            max-width: 800px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
<div id="ff_preview_top">
    <div id="ff_preview_header">
        <div class="ff_preview_title">
            Fluent Form Preview ID: <a target="_blank"
                                       href="<?php echo admin_url('admin.php?page=fluent_forms&form_id=' . $form_id . '&route=editor') ?>"><?php echo $form_id; ?></a>
        </div>
        <div class="ff_preview_action">
            Shortcode: [fluentform id='<?php echo $form_id ?>']
        </div>
    </div>
    <div class="ff_preview_body">
        <?php echo do_shortcode('[fluentform id="' . $form_id . '"]'); ?>
    </div>
    <div class="ff_preview_fotter">
        <p>You are seeing preview version of WP Fluent Forms. This form is only accessible for Admin users. Other users
            may not access this page. To use this for in a page please use the following shortcode: [fluentform
            id='<?php echo $form_id ?>']</p>
    </div>
</div>
<?php
wp_footer();
?>
</body>
</html>