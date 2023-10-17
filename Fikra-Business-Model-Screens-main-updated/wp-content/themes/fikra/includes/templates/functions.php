<?php
function modify_templates_init()
{
    register_post_type('templates', array(
        'label' => 'Templates',
        'labels' => array(
            'name' => 'Templates  ',
            'singular_name' => 'Templates  ',
            'menu_name' => 'Templates  ',
            'name_admin_bar' => 'Templates  ',
        ),
        'description' => '',
        'public' => false,
        'publicly_queryable' => false,
        'query_var' => false,
        'rewrite' => false,
        'has_archive' => false,
        'hierarchical' => false,
        'exclude_from_search' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_admin_bar' => true,
        'show_in_nav_menus' => false,
        'menu_icon' => 'dashicons-media-document',
        'supports' => array('title', 'excerpt', 'thumbnail','page-attributes'),
        'can_export' => true,
    ));

    // Add new taxonomy, NOT hierarchical (like tags)
    $labels = array(
        'name'                       => 'Keywords',
        'singular_name'              => 'Keyword',
        'all_items'                  => 'Keywords',
        'parent_item'                => null,
        'menu_name'                  => 'Keywords',
    );

    $args = array(
        'hierarchical'          => true,
        'labels'                => $labels,
        'show_ui'               => true,
        'show_admin_column'     => true,
        'update_count_callback' => '_update_post_term_count',
        'query_var'             => true,
        'rewrite'               => array( 'slug' => 'Keywords' ),
    );

    register_taxonomy( 'Keywords', ['templates','question'], $args );

}

add_action('init', 'modify_templates_init');
/********
 *
 * Meta Boxes
 *
 *******/
add_action('add_meta_boxes', 'templates_meta_box');
function templates_meta_box()
{
    add_meta_box(
        'templates_meta_id',
        'Information',
        'modify_function_templates',
        'templates'
    );
}

function modify_function_templates()
{
    global $post;
//    $keywords = get_post_meta($post->ID, 'keywords');
    $title_en = get_post_meta($post->ID, 'title_en', true);
    $file_ar = get_post_meta($post->ID, 'file_ar', true);
    $file_en = get_post_meta($post->ID, 'file_en', true);
    $file_ar_id = get_post_meta($post->ID, 'file_ar_id', true);
    $file_en_id = get_post_meta($post->ID, 'file_en_id', true);

    $file_ar_ = wp_get_attachment_url($file_ar_id);
    $file_en_ = wp_get_attachment_url($file_en_id);

    ?>
    <ul class="_list">
        <li><label><span><b> Title (English) : </b></span></label>
            <input type="text" name="title_en" value="<?php echo $title_en; ?>">

        </li>


        <li>

            <label><span>ملف النموذج 1</span></label>

            <input type="text" name="file_ar" id="file_ar" size="25" value="<?php echo $file_ar_id ? $file_ar_ : $file_ar   ; ?>">
            <input type="hidden" name="file_ar_id" id="file_ar_id" size="25" value="<?php echo $file_ar_id; ?>">

            <button data-inputid="file_ar" type="button"

                    class="button  upload_img"> الملف 1

            </button>


        </li>
        <li>

            <label><span>ملف النموذج 2</span></label>

            <input type="text" name="file_en" id="file_en" size="25" value="<?php echo $file_en_id ? $file_en_ : $file_en   ; ?>">
            <input type="hidden" name="file_en_id" id="file_en_id" size="25" value="<?php echo $file_en_id; ?>">

            <button data-inputid="file_en" type="button"

                    class="button  upload_img2"> الملف 2

            </button>


        </li>


    </ul>
    <?php
    /*
    <h3>
        <b><u>Keywords:</u></b>
    </h3>
    <ul class="_list keywords">
        <?php
        if ($keywords) {
            foreach ($keywords as $k => $keyword) { ?>
                <li><label><span><b> Keyword <?php echo ++$k; ?> : </b></span></label>
                    <input type="text" name="keyword[]" value="<?php echo $keyword; ?>">
                    <button class="button delete-this" type="button">Delete</button>
                </li>
            <?php }
        } ?>
    </ul>
    <button class="add-new-Keyword button" type="button">+ Add new Keyword</button>
   */?>
    <script>
        // jQuery("body").on('click', '.add-new-Keyword', function () {
        //     let c = jQuery(".keywords li").length + 1;
        //     let h = `<li><label><span><b> Keyword ` + c + ` : </b></span></label>
        //             <input type="text" name="keyword[]">
        //             <button class="button delete-this" type="button">Delete</button>
        //         </li>`;
        //     jQuery(".keywords").append(h);
        // });
        // jQuery("body").on('click', '.delete-this', function () {
        //     jQuery(this).closest('li').remove();
        // });

        jQuery(document).ready(function ($) {
            var file_frame, file_frame2;
            jQuery('body').on('click', '.upload_img', function (event) {

                var inputid = jQuery(this).attr('data-inputid');
                event.preventDefault();
                // If the media frame already exists, reopen it.
                if (file_frame) {
                    file_frame.open();
                    return;
                }
                // Create the media frame.
                file_frame = wp.media.frames.file_frame = wp.media({
                    title: jQuery(this).data('uploader_title'),
                    button: {
                        text: jQuery(this).data('uploader_button_text'),
                    },
                    multiple: false  // Set to true to allow multiple files to be selected
                });
                // When an image is selected, run a callback.
                file_frame.on('select', function () {
                    // We set multiple to false so only get one image from the uploader
                    attachment = file_frame.state().get('selection').first().toJSON();
                    jQuery("#" + inputid).val(attachment.url);
                    jQuery("#"+inputid+"_id").val(attachment.id);
                    // Do something with attachment.id and/or attachment.url here
                });
                // Finally, open the modal
                file_frame.open();
            });
            jQuery('body').on('click', '.upload_img2', function (event) {


                var imgid = jQuery(this).attr('data-imgid');


                var inputid = jQuery(this).attr('data-inputid');


                event.preventDefault();


                // If the media frame already exists, reopen it.


                if (file_frame2) {


                    file_frame2.open();


                    return;


                }


                // Create the media frame.


                file_frame2 = wp.media.frames.file_frame2 = wp.media({


                    title: jQuery(this).data('uploader_title'),


                    button: {


                        text: jQuery(this).data('uploader_button_text'),


                    },


                    multiple: false  // Set to true to allow multiple files to be selected


                });


                // When an image is selected, run a callback.


                file_frame2.on('select', function () {


                    // We set multiple to false so only get one image from the uploader


                    attachment = file_frame2.state().get('selection').first().toJSON();


                    // var p = jQuery(this).parent();


                    // console.log(p.html());


                    // p.find("img").attr("src",attachment.url);


                    // p.find("img").removeClass("uk-hidden");


                    // p.find("input[type=hidden]").val(attachment.url);


                    console.log(imgid);


                    jQuery("#" + imgid).attr("src", attachment.url);


                    jQuery("#" + imgid).show();


                    jQuery("#" + inputid).val(attachment.url);
                    jQuery("#"+inputid+"_id").val(attachment.id);


                    // Do something with attachment.id and/or attachment.url here


                });


                // Finally, open the modal


                file_frame2.open();


            });

        });
    </script>

    <?php


}

function save_templates_meta($post_id = false, $post = false)
{
    // Check post type for teachers
    if ($post->post_type == 'templates') {
        update_post_meta($post_id, 'title_en', $_POST['title_en']);
        update_post_meta($post_id, 'file_ar', $_POST['file_ar']);
        update_post_meta($post_id, 'file_en', $_POST['file_en']);
        update_post_meta($post_id, 'file_ar_id', $_POST['file_ar_id']);
        update_post_meta($post_id, 'file_en_id', $_POST['file_en_id']);

//        delete_post_meta($post_id, 'keywords');
//        foreach ($_POST['keyword'] as $k => $answer) {
//            add_post_meta($post_id, 'keywords', $answer);
//        }
    }
}

add_action('save_post', 'save_templates_meta', 10, 2);

