<?php
/**
 * The nomagic function file
 */
?>

<?php
/* Add style sheets and js */

function nomagic_wordpress_resources() {

    wp_enqueue_style('style', get_stylesheet_uri());
    wp_enqueue_style('custom_css', get_template_directory_uri() . '/css/custom_css.php');
}

add_action('wp_enqueue_scripts', 'nomagic_wordpress_resources');

/* Add js for admin dashboard */

function nomagic_wordpress_admin_resources() {
    wp_enqueue_script('nomagic', get_template_directory_uri() . '/js/wp-nomagic.js', array('jquery'));
}

add_action('admin_enqueue_scripts', 'nomagic_wordpress_admin_resources');

//Theme Setup
function nomagicwordpress_setup() {
    /* Add Navigation menu */
    register_nav_menus(array(
        'primary' => __('Primary Menu'),
        'footer' => __('Footer Menu'),
    ));

    /* Adding diff layout for the wordpress posts */
    add_theme_support('post-formats', array('aside', 'gallery', 'link'));

    /* Add featured image support */
    add_theme_support('post-thumbnails');
}

add_action('after_setup_theme', 'nomagicwordpress_setup');

/* Theme links color option */

function nomagic_customize_register($wp_customize) {
    $wp_customize->add_setting('nomagic_link_color', array(
        'default' => '#0063c3',
        'transport' => 'refresh',
    ));
    $wp_customize->add_setting('nomagic_btn_color', array(
        'default' => '#0063c3',
        'transport' => 'refresh',
    ));
    $wp_customize->add_section('nomagic_standard_colors', array(
        'title' => __('Standard Colors', 'nomagic'),
        'priority' => 30,
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'nomagic_link_color_control', array(
        'label' => __('Link Color', 'nomagic'),
        'section' => 'nomagic_standard_colors',
        'settings' => 'nomagic_link_color',
    )));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'nomagic_btn_color_control', array(
        'label' => __('Button Color', 'nomagic'),
        'section' => 'nomagic_standard_colors',
        'settings' => 'nomagic_btn_color',
    )));
}

add_action('customize_register', 'nomagic_customize_register');

/* output customize CSS */

function nomagic_wordpress_customize_css() {
    ?>
    <style type="text/css">
        a:link,
        a:visited{
            color:<?php echo get_theme_mod('nomagic_link_color') ?>;
        }
        .btn-a,
        .btn-a:link,
        .btn-a:visited{
            background-color:<?php echo get_theme_mod('nomagic_btn_color') ?>;
        }
    </style>

<?php
}

add_action('wp_head', 'nomagic_wordpress_customize_css');

/* Add widget section */

function nomagicwidgetInit() {
    register_sidebar(array(
        'name' => 'Sidebar',
        'id' => 'sidebar1',
        'before_widget' => '<div class="widget-item">',
        'after_widget' => '</div>'
    ));
    register_sidebar(array(
        'name' => 'Footer Area 1',
        'id' => 'footer1'
    ));
    register_sidebar(array(
        'name' => 'Footer Area 2',
        'id' => 'footer2'
    ));
    register_sidebar(array(
        'name' => 'Footer Area 3',
        'id' => 'footer3'
    ));
    register_sidebar(array(
        'name' => 'Footer Area 4',
        'id' => 'footer4'
    ));
}

add_action('widgets_init', 'nomagicwidgetInit');

/* Customize excerpt word count length */

function custom_excerpt_length() {
    return 22;
}

add_filter('excerpt_length', 'custom_excerpt_length');

/* Add theme options menu */

function add_theme_menu_item() {
    add_menu_page("Theme Panel", "Theme Panel", "manage_options", "theme-panel", "theme_settings_page", null, 99);
}

add_action("admin_menu", "add_theme_menu_item");

/* Theme options Settings page */

function theme_settings_page() {
    ?>
    <div class="wrap">
        <h1>Theme Panel</h1>
        <form method="post" action="options.php">
            <?php
            /* option group is "section"
              Output nonce, action, and option_page fields for a settings page.
              Please note that this function must be called inside of the form tag for the options page
             */
            settings_fields("section");

            /* Prints out all settings sections added to a particular settings page.
              Parameters $page(string) (required) The slug name of the page whose settings sections you want to output.
              This should match the page name used in add_settings_section().
             */

            do_settings_sections("theme-options");
            submit_button();
            ?>
    <?php
    global $options;

    $options = get_option('nomagic_theme_options');
    ?>
        </form>
    </div>
    <?php
}

function display_theme_panel_fields() {
    add_settings_section("section", "All Settings", null, "theme-options");
    register_setting("section", 'nomagic_theme_options');
    /* Adding Social links to theme */
    add_settings_field("twitter_url", "Twitter Url", "display_twitter_element", "theme-options", "section");
    add_settings_field("facebook_url", "Facebook Url", "display_facebook_element", "theme-options", "section");
    add_settings_field("youtube_url", "Youtube Url", "display_youtube_element", "theme-options", "section");
    add_settings_field("pinteres_url", "Pinteres Url", "display_pinteres_element", "theme-options", "section");
    add_settings_field("instagram_url", "Instagram Url", "display_instagram_element", "theme-options", "section");

    /* Adding custom fields options to theme */
    add_settings_field("nomagic_custom_css", "Custom Css", "add_nomagic_custom_css_element", "theme-options", "section");
    add_settings_field("nomagic_custom_js", "Custom Js", "add_nomagic_custom_js_element", "theme-options", "section");

    /* Adding site logo option */
    add_settings_field("header_logo", "Main Logo", "add_nomagic_header_logo_element", "theme-options", "section");

    /* Adding Footer option */
    add_settings_field("nomagic_footer", "Footer", "add_nomagic_footer_element", "theme-options", "section");
}

add_action("admin_init", "display_theme_panel_fields");

function add_nomagic_footer_element() {
    ?>
    <textarea cols="50" name="nomagic_theme_options[nomagic_footer]" id="nomagic_theme_options[nomagic_footer]" rows="4" style="background: none repeat scroll 0% 0% ; height: 100px; margin: 0pt auto; padding: 5px; width: 382px;"><?php $options = get_option('nomagic_theme_options');
    echo $options['nomagic_footer']; ?></textarea>
    <?php
}

function add_nomagic_header_logo_element() {
    wp_enqueue_script('jquery');
    // This will enqueue the Media Uploader script
    wp_enqueue_media();
    ?>
    <div>
        <input type="text" name="nomagic_theme_options[header_logo]" id="nomagic_theme_options[header_logo]" class="regular-text nomagic-logo-upload-btn" value="<?php $options = get_option('nomagic_theme_options');
    echo $options['header_logo']; ?>">
        <input type="button" name="upload-btn" id="upload-btn" class="button-secondary" value="Upload Image">
        <input type="button" name="remove-btn" id="remove-btn" class="button-secondary" value="Remove Image">

    </div>
    <?php
    preview_header_logo();
}

function preview_header_logo() {
    ?>
    <a href=""><img id="preview_header_logo" name="preview_header_logo" src="<?php $options = get_option('nomagic_theme_options');
    echo $options['header_logo']; ?>" alt="" height="100" width="100"> </a>
    <?php
}

function add_nomagic_custom_js_element() {
    ?>
    <textarea cols="50" name="nomagic_theme_options[nomagic_custom_js]" id="nomagic_theme_options[nomagic_custom_js]" rows="4" style="background: none repeat scroll 0% 0% ; height: 100px; margin: 0pt auto; padding: 5px; width: 382px;"><?php $options = get_option('nomagic_theme_options');
    echo $options['nomagic_custom_js']; ?></textarea>
    <?php
}

function add_nomagic_custom_css_element() {
    ?>
    <textarea cols="50" name="nomagic_theme_options[nomagic_custom_css]" id="nomagic_theme_options[nomagic_custom_css]" rows="4" style="background: none repeat scroll 0% 0% ; height: 100px; margin: 0pt auto; padding: 5px; width: 382px;"><?php $options = get_option('nomagic_theme_options');
    echo $options['nomagic_custom_css']; ?></textarea>
    <?php
}

$dir_path = get_theme_root(); // theme directory path
add_action('template_redirect', 'nomagic_theme_custom_print_css');
add_action('template_redirect', 'nomagic_theme_js_print_js');

function nomagic_theme_js_print_js() {
    include_once ($dir_path . '/js/custom-js.php');
}

function nomagic_theme_custom_print_css() {
    include_once ($dir_path . '/css/custom_css.php');
}

function display_instagram_element() {
    ?>
    <input type="text" name="nomagic_theme_options[instagram_url]" id="nomagic_theme_options[instagram_url]" value="<?php $options = get_option('nomagic_theme_options');
    echo $options['instagram_url']; ?>" />
    <?php
}

function display_pinteres_element() {
    ?>
    <input type="text" name="nomagic_theme_options[pinteres_url]" id="nomagic_theme_options[pinteres_url]" value="<?php $options = get_option('nomagic_theme_options');
    echo $options['pinteres_url']; ?>" />
    <?php
}

function display_twitter_element() {
    ?>
    <input type="text" name="nomagic_theme_options[twitter_url]" id="nomagic_theme_options[twitter_url]" value="<?php $options = get_option('nomagic_theme_options');
    echo $options['twitter_url']; ?>" />
    <?php
}

function display_facebook_element() {
    ?>
    <input type="text" name="nomagic_theme_options[facebook_url]" id="nomagic_theme_options[facebook_url]" value="<?php $options = get_option('nomagic_theme_options');
    echo $options['facebook_url']; ?>" />
    <?php
}

function display_youtube_element() {
    ?>
    <input type="text" name="nomagic_theme_options[youtube_url]" id="nomagic_theme_options[youtube_url]" value="<?php $options = get_option('nomagic_theme_options');
    echo $options['youtube_url']; ?>" />
    <?php
}
?>