<?php
function modify_question_init()
{
    register_post_type('question', array(
        'label' => 'Question',
        'labels' => array(
            'name' => 'Question  ',
            'singular_name' => 'Question  ',
            'menu_name' => 'Question  ',
            'name_admin_bar' => 'Question  ',
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

add_action('init', 'modify_question_init');
/********
 *
 * Meta Boxes
 *
 *******/
add_action('add_meta_boxes', 'question_meta_box');
function question_meta_box()
{
    add_meta_box(
        'question_meta_id',
        'Information',
        'modify_function_question',
        'question'
    );
}

function modify_function_question()
{
    global $post;
    $answers = get_post_meta($post->ID, 'answer');
    $step = get_post_meta($post->ID, 'step' , true);
    $type = get_post_meta($post->ID, 'type' , true);
    ?>
    <ul class="_list">
        <li><label><span><b> Step number : </b></span></label>
            <label><input type="radio" name="step" value="2" <?php echo $step == 2 ? 'checked' : '' ?>> 2</label>
            <label><input type="radio" name="step" value="3" <?php echo $step == 3 ? 'checked' : '' ?>> 3</label>
        </li>
        <li><label><span><b> Type : </b></span></label>
            <label><input type="radio" name="type" value="checkbox" <?php echo $type == 'checkbox' ? 'checked' : '' ?>> Checkbox</label>
            <label><input type="radio" name="type" value="select" <?php echo $type == 'select' ? 'checked' : '' ?>> Dropdown list</label>
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

function save_question_meta($post_id = false, $post = false)
{
    // Check post type for teachers
    if ($post->post_type == 'question') {
        update_post_meta($post_id, 'step', $_POST['step'] );
        update_post_meta($post_id, 'type', $_POST['type'] );
        delete_post_meta($post_id, 'answer');

        foreach ($_POST['answer'] as $k => $answer) {
            add_post_meta($post_id, 'answer', $answer);
        }
    }
}

add_action('save_post', 'save_question_meta', 10, 2);



