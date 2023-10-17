<?php
function modify_orders_init()
{
    register_post_type('orders', array(
        'label' => 'orders',
        'labels' => array(
            'name' => 'orders  ',
            'singular_name' => 'orders  ',
            'menu_name' => 'orders  ',
            'name_admin_bar' => 'orders  ',
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
        'supports' => array('title', 'excerpt', 'page-attributes'),
        'can_export' => true,
    ));

}

add_action('init', 'modify_orders_init');
/********
 *
 * Meta Boxes
 *
 *******/
add_action('add_meta_boxes', 'orders_meta_box');
function orders_meta_box()
{
    add_meta_box(
        'orders_meta_id',
        'Information',
        'modify_function_orders',
        'orders'
    );
}

function modify_function_orders()
{
    global $post;
    $meta = get_post_meta($post->ID );

    ?>
    <ul class="_list">
        <li><label><span><b> الاسم : </b></span></label> <?php echo $meta['name'][0]; ?> </li>
        <li><label><span><b> الجوال : </b></span></label> <?php echo $meta['phone'][0]; ?> </li>
        <li><label><span><b> البريد الالكتروني : </b></span></label> <?php echo $meta['email'][0]; ?> </li>
        <li><label><span><b> اسم المشروع    : </b></span></label> <?php echo $meta['project'][0]; ?> </li>
        <li><label><span><b> نبذة عن المشروع     : </b></span></label> <?php echo $meta['about'][0]; ?> </li>

        <li><label><span><b> الاجابات     : </b></span></label>
        <br>
            <ol>
               <?php
                $anss = unserialize($meta['answers'][0]);
                foreach ($anss as $an){
               ?>
                    <li><label><span><b> <?php echo  $an['title']; ?>     : </b></span></label>
                        <?php echo join(' , ' ,     $an['keys'] ); ?>
                    </li>
                    <?php } ?>
            </ol>

        </li>

    </ul>
    <?php
    /*
    <ul class="_list answers">
        <?php
        if ($answers) {
            foreach ($answers as $k => $answer) { ?>
                <li><label><span><b> Answer <?php echo ++$k; ?> : </b></span></label>
                    <input type="text" name="answer[]" value="<?php echo $answer; ?>">
                    <button class="button delete-this" type="button">Delete</button>
                </li>
            <?php }
        } ?>
    </ul>
    <button class="add-new-answer button" type="button">+ Add new Answer</button>
    <script>
        jQuery("body").on('click', '.add-new-answer', function () {
            let c = jQuery(".answers li").length + 1;
            let h = `<li><label><span><b> Answer ` + c + ` : </b></span></label>
                    <input type="text" name="answer[]">
                    <button class="button delete-this" type="button">Delete</button>
                </li>`;
            jQuery(".answers").append(h);
        });
        jQuery("body").on('click', '.delete-this', function () {
           jQuery(this).closest('li').remove();
        });
    </script>
    <?php
    */

}

function save_orders_meta($post_id = false, $post = false)
{
    // Check post type for teachers
    if ($post->post_type == 'orders') {
        update_post_meta($post_id, 'step', $_POST['step'] );
        delete_post_meta($post_id, 'answer');

        foreach ($_POST['answer'] as $k => $answer) {
            add_post_meta($post_id, 'answer', $answer);
        }
    }
}

add_action('save_post', 'save_orders_meta', 10, 2);


// Add the custom columns to the orders post type:
add_filter('manage_orders_posts_columns', 'set_custom_edit_orders_columns');
function set_custom_edit_orders_columns($columns)
{

    $columns['answers'] = 'Answers';

    return $columns;
}

// Add the data to the custom columns for the orders post type:
add_action('manage_orders_posts_custom_column', 'custom_orders_column', 10, 2);
function custom_orders_column($column, $post_id)
{
    switch ($column) {


        case 'answers' :
            $answers = get_post_meta($post_id, 'answer');
            if($answers) {
                foreach ($answers as $ans) {
                    echo $ans . ' , ';
                }
            }

            break;

    }
}

