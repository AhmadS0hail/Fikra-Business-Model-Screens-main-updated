<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>

    <link rel="icon" href="<?php echo get_stylesheet_directory_uri() ?>/src/favicon.ico"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title><?php bloginfo('name'); ?><?php wp_title() ?></title>
    <?php
    global $op;
    $locations = get_nav_menu_locations();
    $location = 'top-menu'; // Replace with the name of your menu location
    $footer_1_location = 'footer-menu1'; // Replace with the name of your menu location
    $footer_2_location = 'footer-menu2'; // Replace with the name of your menu location
    $footer_3_location = 'footer-menu3'; // Replace with the name of your menu location
    $top_menu = [];
    $footer_menu1 = [];
    $footer_menu2 = [];
    $footer_menu3 = [];
    // Check if the location exists
    if (isset($locations[$location])) {
        // Get the menu items for the location
        $menu_items = wp_get_nav_menu_items($locations[$location]);

        // Loop through the menu items and do something with each item
        foreach ($menu_items as $menu_item) {
            $url = '';
            if($menu_item->object == 'custom'){
                $url = $menu_item->url;
                $titl = $menu_item->title;
            }elseif($menu_item->object == 'post' || $menu_item->object == 'page'){
                $url = get_permalink($menu_item->object_id);
                $titl = get_the_title($menu_item->object_id);

            }
            // Do something with the menu item
            if ( $menu_item->menu_item_parent == 0) {
                $top_menu[$menu_item->ID] = [
                    'id' => $menu_item->ID,
                    'title' => $titl,
                    'url' => $url,
                    'parent' => $menu_item->menu_item_parent,
                    'child' => [],
                    'classes' => join(' ' , $menu_item->classes),
                ];


            } elseif ($menu_item->menu_item_parent > 0) {
                $top_menu[$menu_item->menu_item_parent]['child'][] = [
                    'id' => $menu_item->ID,
                    'title' => $titl,
                    'url' => $url,
                    'parent' => $menu_item->menu_item_parent,
                    'child' => [],
                    'classes' => '',
                    ];
            }


        }
    }


    if (isset($locations[$footer_1_location])) {
        // Get the menu items for the location
        $menu_items = wp_get_nav_menu_items($locations[$footer_1_location]);

        // Loop through the menu items and do something with each item
        foreach ($menu_items as $menu_item) {
            // Do something with the menu item
            $footer_menu1[] = [
                'title' => $menu_item->title,
                'url' => $menu_item->url,
            ];

        }
    }
    if (isset($locations[$footer_2_location])) {
        // Get the menu items for the location
        $menu_items = wp_get_nav_menu_items($locations[$footer_2_location]);

        // Loop through the menu items and do something with each item
        foreach ($menu_items as $menu_item) {
            // Do something with the menu item
            $footer_menu2[] = [
                'title' => $menu_item->title,
                'url' => $menu_item->url,
            ];

        }
    }
    if (isset($locations[$footer_3_location])) {
        // Get the menu items for the location
        $menu_items = wp_get_nav_menu_items($locations[$footer_3_location]);

        // Loop through the menu items and do something with each item
        foreach ($menu_items as $menu_item) {
            // Do something with the menu item
            $footer_menu3[] = [
                'title' => $menu_item->title,
                'url' => $menu_item->url,
            ];

        }
    }


    $settings_ = json_encode([

        'title' => get_bloginfo('name'),
        'url' => $op['url'],
        'description' => get_bloginfo('description'),
        'social' => [
            'facebook' => $op['facebook'],
            'twitter' => $op['twitter'],
            'instagram' => $op['instagram'],
            'linkedin' => $op['linkedin'],
            'youtube' => $op['youtube'],
        ],
        'logo' => $op['logo'],
        'footer_logo' => $op['logo2'],
        'copyright' => $op['copyRight'],
        'email' => $op['email'],
        'mobile' => $op['mobile'],
        'top_menu' => $top_menu,
        'footer_menu1' => $footer_menu1,
        'footer_menu2' => $footer_menu2,
        'footer_menu3' => $footer_menu3,
        'tlink' => get_bloginfo("url") . '/wp-content/themes/fikra',
        'tdomain' => get_bloginfo("url"),

    ]);
    ?>

    <script type="text/javascript">
        window._settings = '<?php echo $settings_ ?>';
    </script>
    <?php
    // Path to the directory containing the files
    $dir_path = get_stylesheet_directory() . '/dist/assets';

    if ($handle = opendir($dir_path)) {
        while (false !== ($entry = readdir($handle))) {
            if ($entry != "." && $entry != "..") {
                // Do something with the file


                if (strpos($entry, '.css') !== false) {
                    // Include the CSS file in a <link> tag
                    echo '<link rel="stylesheet" href="' . get_stylesheet_directory_uri() . '/dist/assets/' . $entry . '">' . "\n";
                }

                // Check if it's a JS file
                if (strpos($entry, '.js') !== false) {
                    // Include the JS file in a <script> tag
                    echo '<script type="module" crossorigin  src="' . get_stylesheet_directory_uri() . '/dist/assets/' . $entry . '"></script>' . "\n";
                }
            }
        }
        closedir($handle);
    }
    ?>

    <style>

        @font-face {
            font-family: 'Azer';
            src: url('<?php echo get_stylesheet_directory_uri() ?>/src/assets/29LTAzer-Regular.woff2') format('woff2'),
            url('<?php echo get_stylesheet_directory_uri() ?>/src/assets/29LTAzer-Regular.woff') format('woff');
            font-weight: normal;
            font-style: normal;
            font-display: swap;
        }

        @font-face {
            font-family: 'Azer';
            src: url('<?php echo get_stylesheet_directory_uri() ?>/src/assets/29LTAzer-Medium.woff2') format('woff2'),
            url('<?php echo get_stylesheet_directory_uri() ?>/src/assets/29LTAzer-Medium.woff') format('woff');
            font-weight: 500;
            font-style: normal;
            font-display: swap;
        }

        @font-face {
            font-family: 'Azer';
            src: url('<?php echo get_stylesheet_directory_uri() ?>/src/assets/29LTAzer-Medium.woff2') format('woff2'),
            url('<?php echo get_stylesheet_directory_uri() ?>/src/assets/29LTAzer-Medium.woff') format('woff');
            font-weight: 700;
            font-style: normal;
            font-display: swap;
        }

        .bm_img {
            background-image: url("<?php echo get_stylesheet_directory_uri() ?>/src/assets/img/bm_img.jpg");
        }
    </style>

    <?php get_header();
    ?>

</head>
<body class="bg-mainBG">
<div id="app" dir="rtl"></div>
<?php get_footer(); ?>
</body>
</html>
