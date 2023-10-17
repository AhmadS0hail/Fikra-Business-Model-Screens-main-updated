<?php
const GENERAL_OPTION_NAME = 'fikra-';

$op = get_option(GENERAL_OPTION_NAME);


get_template_part('includes/admin/general_option');
get_template_part('includes/questions/functions');
get_template_part('includes/templates/functions');
get_template_part('includes/order/functions');


add_action('after_setup_theme', 'theme_setup_');


function theme_setup_()

{

//    add_theme_support('menus');

    add_theme_support('post-thumbnails');


    add_post_type_support('page', 'excerpt');


    register_nav_menus(

        [
            'top-menu' => 'القائمة الرئيسية',
            'footer-menu1' => 'قائمة الفوتر - خدماتنا',
            'footer-menu2' => 'قائمة الفوتر - مراجع',
            'footer-menu3' => 'قائمة الفوتر - عامة',
        ]

    );


}


add_action('admin_head', 'add_css_admin_head');

function add_css_admin_head()
{

    ?>

    <style>

    ._list {

        line-height: 30px;


    }

    ._list li {

        padding: 5px;

        overflow: hidden;

    }

    ._list li:nth-child(odd) {

        background: #f3f3f3;


    }

    ._list input[type=text] {

        width: 400px;

    }

    ._list li textarea {

        height: 100px;

        width: 100%;


    }

    ._list li span {

        width: 120px;

        display: inline-block;

        float: <?php echo is_rtl() ? 'right' : 'left';?>;

    }


    ._list li span.select2, ._list li span.select2 span.selection, span.select2-selection.select2-selection--multiple {

        width: 100% !important;

        display: inline-block;

        float: none;

    }


    ._list li span.select2 span {

        width: auto;

        display: inline-block;

        float: none;

    }


    .hidden {

        display: none;

    }

    .ui-tabs .ui-tabs-nav li {
        float: right;
    }

    </style><?php


}


class Fikra_API extends WP_REST_Controller
{

    public function __construct()
    {
        // Register the REST API endpoints.
        add_action('rest_api_init', array($this, 'register_routes'));
    }

    /**
     * Register the custom routes for the API.
     */
    public function register_routes()
    {
        $version = '1';
        $namespace = 'fikra/v' . $version;
        $base = '';

        register_rest_route($namespace, '/home' . $base, array(
            'methods' => WP_REST_Server::READABLE,
            'callback' => array($this, 'get_data'),
        ));

        register_rest_route($namespace, '/questions' . $base, array(
            'methods' => WP_REST_Server::READABLE,
            'callback' => array($this, 'get_questions'),

        ));
        register_rest_route($namespace, '/add-order' . $base, array(
            'methods' => WP_REST_Server::CREATABLE,
            'callback' => array($this, 'post_answers'),

        ));
    }

    /**
     * Get data for the custom endpoint.
     *
     * @param WP_REST_Request $request The REST API request.
     * @return WP_REST_Response The REST API response.
     */
    public function post_answers($request)
    {

        // Retrieve data for the endpoint and return it as a response.
        $formOne = $request['order_data']['formOne'];
        $formTwo = $request['order_data']['formTwo'];
        $formThree = $request['order_data']['formThree'];

        $keys = [];
        $answers = [];
        foreach ($formTwo as $ques_id => $k2) {
            $x = explode('question_', $ques_id);
            $qid = $x[1];
            $answers[] = ['title' => get_the_title($qid), 'keys' => $k2];

            foreach ($k2 as $key2) {
                $keys[] = $key2;
            }
        }

        foreach ($formThree as $ques_id => $k2) {
            $x = explode('question_', $ques_id);
            $qid = $x[1];
            $answers[] = ['title' => get_the_title($qid), 'keys' => $k2];

            foreach ($k2 as $key2) {
                $keys[] = $key2;
            }
        }

        $my_post = array(
            'post_title' => wp_strip_all_tags($formOne['name']),
            'post_status' => 'publish',
            'post_author' => 1,
            'post_type' => 'orders'
        );


        // Insert the post into the database


        $post_id = wp_insert_post($my_post);


        if ($post_id) {

            update_post_meta($post_id, 'name', wp_strip_all_tags($formOne['name']));
            update_post_meta($post_id, 'email', $formOne['email']);
            update_post_meta($post_id, 'phone', $formOne['phone']);
            update_post_meta($post_id, 'project', wp_strip_all_tags($formOne['project']));
            update_post_meta($post_id, 'about', wp_strip_all_tags($formOne['about']));
//            update_post_meta($post_id, 'projectDomain', wp_strip_all_tags($formOne['projectDomain']));
            update_post_meta($post_id, 'answers', $answers);
            update_post_meta($post_id, 'keys', $keys);

        }


        $questions_ = get_posts(['post_type' => 'templates', 'posts_per_page' => -1]);
        $templates = [];
        foreach ($questions_ as $questions_1) {
            $c = 0;
            $templates['template_' . $questions_1->ID] = 0;
            $keywords = [];
            $keywords1 = wp_get_post_terms($questions_1->ID, 'Keywords');
            if ($keywords1) {
                foreach ($keywords1 as $kw) {
                    $keywords[] = $kw->name;
                }
            }
            foreach ($keys as $ans_key) {
                if (in_array($ans_key, $keywords)) {
                    $templates[$questions_1->ID] = ++$c;
                }
            }
        }

        $final_template = [];
        arsort($templates);
        foreach ($templates as $template_id => $score) {
            if ($score > 0) {
                $meta = get_post_meta($template_id);
                $final_template[] = [
                    'id' => $template_id,
                    'imgURL' => get_the_post_thumbnail_url($template_id, 'large'),
//                    'imgURL' => $meta['file_ar'][0],
                    'nameAR' => get_the_title($template_id),
                    'nameEN' => $meta['title_en'][0],
                    'viewLink' => $meta['file_ar'][0],
                    'downloadLink' => $meta['file_en'][0],
                ];
            }
        }
        $data = ['outputData' => $final_template];
        return new WP_REST_Response($data, 200);
    }

    public function get_data($request)
    {
        global $op;
        // Retrieve data for the endpoint and return it as a response.
        $data = [
            'data' => [
                'title' => get_bloginfo('name'),
                'description' => get_bloginfo('description'),
                'social' => [
                    'facebook' => $op['facebook'],
                    'twitter' => $op['twitter'],
                    'instagram' => $op['instagram'],
                    'linkedin' => $op['linkedin'],
                    'youtube' => $op['youtube'],
                ],
                'logo' => $op['logo'],
                'copyright' => $op['copyRight'],
                'email' => $op['email'],
                'mobile' => $op['mobile']
            ]];

        return new WP_REST_Response($data, 200);
    }

    /**
     * Get data by ID for the custom endpoint.
     *
     * @param WP_REST_Request $request The REST API request.
     * @return WP_REST_Response The REST API response.
     */
    public function get_questions($request)
    {

        $questions_1 = [];
        $questions_2 = [];
        $questions_3 = [];

        $q = new WP_Query(['post_type' => 'question', 'posts_per_page' => -1, 'order_by' => 'menu_order', 'order' => 'asc', 'meta_key' => 'step', 'meta_value' => 2]);
        if ($q->have_posts()) : while ($q->have_posts()) : $q->the_post();
            $type = get_post_meta(get_the_ID(), 'type', true);
            $answers = [];
            $answers_2 = [];
            $ans = wp_get_post_terms(get_the_ID(), 'Keywords' );

            if ($ans) {
                foreach ($ans as $an) {
                    $answers[] = ['value' => $an->name, 'id' => 'F2Q' . $an->term_id];
                    $answers_2[] =   $an->name  ;
                }
            }
            $questions_2[] = [
                'id' => 'question_' . get_The_ID(),
                'qid' => get_The_ID(),
                'type' => $type == 'select' ? 'select' : 'Multiple',
                'options' => $answers,
                'options2' => $answers_2,
                'heading' => get_The_title(),
                'subHeading' => null,
                'description' => get_the_excerpt(),
                'inputType'=>$type
            ];

        endwhile; endif;
        wp_reset_postdata();
        wp_reset_query();

        $q1 = new WP_Query(['post_type' => 'question', 'posts_per_page' => -1, 'order_by' => 'menu_order', 'order' => 'asc', 'meta_key' => 'step', 'meta_value' => 1]);
        if ($q1->have_posts()) : while ($q1->have_posts()) : $q1->the_post();
            $type = get_post_meta(get_the_ID(), 'type', true);
            $answers = [];
            $answers_2 = [];
            $ans = wp_get_post_terms(get_the_ID(), 'Keywords' );

            if ($ans) {
                foreach ($ans as $an) {
                    $answers[] = ['value' => $an->name, 'id' => 'F2Q' . $an->term_id];
                    $answers_2[] =   $an->name  ;
                }
            }
            $questions_1[] = [
                'id' => 'question_' . get_The_ID(),
                'qid' => get_The_ID(),
                'type' => $type == 'select' ? 'select' : 'Multiple',
                'options' => $answers,
                'options2' => $answers_2,
                'heading' => get_The_title(),
                'subHeading' => null,
                'description' => get_the_excerpt(),
                'inputType'=>$type
            ];

        endwhile; endif;
        wp_reset_postdata();
        wp_reset_query();

        $q3 = new WP_Query(['post_type' => 'question', 'posts_per_page' => -1, 'order_by' => 'menu_order', 'order' => 'asc', 'meta_key' => 'step', 'meta_value' => 3]);
        if ($q3->have_posts()) : while ($q3->have_posts()) : $q3->the_post();
            $type = get_post_meta(get_the_ID(), 'type', true);

            $answers_2 = [];



            $answers = [];
            $ans = wp_get_post_terms(get_the_ID(), 'Keywords' );

            if ($ans) {
                foreach ($ans as $an) {
                    $answers[] = ['value' => $an->name, 'id' => 'F3Q' . $an->term_id];
                    $answers_2['F3Q' . $an->term_id] =   $an->name  ;
                }
            }
            $questions_3[] = [
                'id' => 'question_' . get_The_ID(),
                'qid' => get_The_ID(),
                'type' => $type == 'select' ? 'select' : 'Multiple',
                'options' => $answers,
                'options2' => $answers_2,
                'heading' => get_The_title(),
                'subHeading' => null,
                'description' => get_the_excerpt(),
                'inputType'=>$type

            ];

        endwhile; endif;
        wp_reset_postdata();
        wp_reset_query();
        // Retrieve data for the given ID and return it as a response.
        $data = [
            'formFirstQuestions' => $questions_1,
            'formTwoQuestions' => $questions_2,
            'formThreeQuestions' => $questions_3
        ];
        return new WP_REST_Response($data, 200);
    }


}

// Instantiate the custom API class and register its routes.
$my_custom_api = new Fikra_API();

function cc_mime_types($mimes)
{
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}

add_filter('upload_mimes', 'cc_mime_types');

function fix_svg_thumb_display()

{


    echo '



   <style> td.media-icon img[src$=".svg"], img[src$=".svg"].attachment-post-thumbnail {



      width: 100% !important;



      height: auto !important;



    }</style>



  ';


}

add_action('admin_head', 'fix_svg_thumb_display');
