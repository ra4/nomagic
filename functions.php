<?php
	/**
		* The nomagic functions file
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
	
	/* Nomagic Theme links color option */
	
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
		
		/* Adding Display date option */
		add_settings_field("nomagic_post_date_chkbox", "Hide the post publish date", "add_nomagic_post_date_chkbox_element", "theme-options", "section");
		
		/* Hide Avatars on comments */
		add_settings_field("nomagic_hide_avatars_from_comment_chkbox", "Do you want to Hide avatar in comments?", "add_nomagic_hide_avatars_from_comment_chkbox_element", "theme-options", "section");
	}
	
	add_action("admin_init", "display_theme_panel_fields");
	
	function add_nomagic_hide_avatars_from_comment_chkbox_element() {
		$options =  get_option('nomagic_theme_options');
		$comment_avatars_chk=$options['nomagic_hide_avatars_from_comment_chkbox'];
	?>
	<input type="checkbox" name="nomagic_theme_options[nomagic_hide_avatars_from_comment_chkbox]" id="nomagic_theme_options[nomagic_hide_avatars_from_comment_chkbox]" <?php if($comment_avatars_chk==1)echo 'checked="checked"'; ?> value="1" <?php ?>>
    <?php
	}
	function add_nomagic_post_date_chkbox_element() {
		$options =  get_option('nomagic_theme_options');
		$chk=$options['nomagic_post_date_chkbox'];
	?>
	<input type="checkbox" name="nomagic_theme_options[nomagic_post_date_chkbox]" id="nomagic_theme_options[nomagic_post_date_chkbox]" <?php if($chk==1)echo 'checked="checked"'; ?> value="1" <?php ?>>
    <?php
	}
	
	function add_nomagic_footer_element() {
	?>
    <textarea cols="50" name="nomagic_theme_options[nomagic_footer]" id="nomagic_theme_options[nomagic_footer]" rows="4" style="background: #fff repeat scroll 0% 0% ; height: 100px; margin: 0pt auto; padding: 5px; width: 382px;"><?php $options = get_option('nomagic_theme_options');
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
	<textarea cols="50" name="nomagic_theme_options[nomagic_custom_js]" id="nomagic_theme_options[nomagic_custom_js]" rows="4" style="background: #fff repeat scroll 0% 0% ; height: 100px; margin: 0pt auto; padding: 5px; width: 382px;"><?php $options = get_option('nomagic_theme_options');
	echo $options['nomagic_custom_js']; ?></textarea>
	<?php
	}
	
	function add_nomagic_custom_css_element() {
	?>
	<textarea cols="50" name="nomagic_theme_options[nomagic_custom_css]" id="nomagic_theme_options[nomagic_custom_css]" rows="4" style="background: #fff repeat scroll 0% 0% ; height: 100px; margin: 0pt auto; padding: 5px; width: 382px;"><?php $options = get_option('nomagic_theme_options');
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
	
	/* add metabox for post specific css*/
	add_action( 'add_meta_boxes', 'nomagic_postcss_meta_box_add' );
	function nomagic_postcss_meta_box_add(){
		add_meta_box( 'post_specific_css_meta_box_id', 'Custom Css', 'nomagic_postcss_meta_box', get_post_type(), 'normal', 'high' );
	}
	
	function nomagic_postcss_meta_box($post){
		$values = get_post_custom( $post->ID );
		$text = isset( $values['single_custom_css'] ) ? esc_attr( $values['single_custom_css'][0] ):'';
		echo '<textarea id="single_custom_css" name="single_custom_css" style="width:100%; min-height:200px;">' . $text . '</textarea>';
		wp_nonce_field( 'nomagic_postspecific_css_meta_box_nonce', 'postspecific_css_meta_box_nonce' );
	}
	add_action( 'save_post', 'custompostcss_meta_box_save' );
	function custompostcss_meta_box_save( $post_id ){
		// Bail if we're doing an auto save
		if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
		
		// if our nonce isn't there, or we can't verify it, bail
		if( !isset( $_POST['postspecific_css_meta_box_nonce'] ) || !wp_verify_nonce( $_POST['postspecific_css_meta_box_nonce'], 'nomagic_postspecific_css_meta_box_nonce' ) ) return;
		
		// if our current user can't edit this post, bail
		if( !current_user_can( 'edit_post' ) ) return;
		
		// now we can actually save the data
		$allowed = array( 
		'a' => array( // on allow a tags
		'href' => array() // and those anchors can only have href attribute
		)
		);
		
		// Make sure your data is set before trying to save it
		if( isset( $_POST['single_custom_css'] ) )
		update_post_meta( $post_id, 'single_custom_css', wp_kses( $_POST['single_custom_css'], $allowed ) );
		
		
	}
	/* Displaying Css for Specific Post type*/
	add_action( 'wp_head', 'specific_post_style' );
	function specific_post_style() {
		$post_id= get_the_ID();
		if( is_singular()){
			echo '<style type="text/css">' . "\n";
			$post_class = get_post_meta( $post_id, 'single_custom_css', true );
			echo html_entity_decode($post_class);
			echo '</style>' . "\n";
		}
		
	}
	/* add metabox for post specific js*/
	add_action( 'add_meta_boxes', 'nomagic_postjs_meta_box_add' );
	function nomagic_postjs_meta_box_add(){
		add_meta_box( 'post_specific_js_meta_box_id', 'Custom Java Script', 'nomagic_postjs_meta_box', get_post_type(), 'normal', 'high' );
	}
	
	function nomagic_postjs_meta_box($post){
		$values = get_post_custom( $post->ID );
		$text = isset( $values['single_custom_js'] ) ? esc_attr( $values['single_custom_js'][0] ):'';
		echo '<textarea id="single_custom_js" name="single_custom_js" style="width:100%; min-height:200px;">' . $text . '</textarea>';
		wp_nonce_field( 'nomagic_postspecific_js_meta_box_nonce', 'postspecific_js_meta_box_nonce' );
	}
	add_action( 'save_post', 'custompostjs_meta_box_save' );
	function custompostjs_meta_box_save( $post_id ){
		// Bail if we're doing an auto save
		if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
		
		// if our nonce isn't there, or we can't verify it, bail
		if( !isset( $_POST['postspecific_js_meta_box_nonce'] ) || !wp_verify_nonce( $_POST['postspecific_js_meta_box_nonce'], 'nomagic_postspecific_js_meta_box_nonce' ) ) return;
		
		// if our current user can't edit this post, bail
		if( !current_user_can( 'edit_post' ) ) return;
		
		// now we can actually save the data
		$allowed = array( 
		'a' => array( // on allow a tags
		'href' => array() // and those anchors can only have href attribute
		)
		);
		
		// Make sure your data is set before trying to save it
		if( isset( $_POST['single_custom_js'] ) )
		update_post_meta( $post_id, 'single_custom_js', wp_kses( $_POST['single_custom_js'], $allowed ) );
		
		
	}
	/* Displaying js for Specific Post type*/
	add_action( 'wp_head', 'specific_post_script' );
	function specific_post_script() {
		$post_id= get_the_ID();
		if( is_singular()){
			echo '<script>' . "\n";
			$post_class = get_post_meta( $post_id, 'single_custom_js', true );
			echo html_entity_decode($post_class);
			echo '</script>' . "\n";
		}
		
	}
	
?>