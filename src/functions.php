<?php
add_theme_support( 'post-thumbnails' );
/**
 * Add theme support for various WordPress features.
 *
 * @return void
 */
function wp_blank_setup() {
	// Support programmable title tag.
	add_theme_support( 'title-tag' );

	// Support custom logo.
	add_theme_support( 'custom-logo' );

	/**
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on wp-blank, use a find and replace
	 * to change 'wp-blank' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'wp-blank', get_template_directory() . '/languages' );

	// Register top menu.
	register_nav_menus(
		array(
			'top' => esc_html__( 'Top Menu', 'wp-blank' ),
		)
	);
}
add_action( 'after_setup_theme', 'wp_blank_setup' );

/**
 * Specify JS bundle path.
 *
 * @return void
 */
function wp_blank_load_scripts() {
	wp_enqueue_style( 'jquery', get_template_directory_uri() . '/js/jquery.min.js' );
	wp_enqueue_style( 'bootstrap-js', get_template_directory_uri() . '/assets/styles/bootstrap/js/bootstrap.min.js' );
}
add_action( 'wp_enqueue_scripts', 'wp_blank_load_scripts' );

/**
 * Specify CSS bundle path.
 *
 * @return void
 */
function wp_blank_load_styles() {
	wp_enqueue_style( 'main', get_template_directory_uri() . '/../dist/bundle.css' );
	wp_enqueue_style( 'bootstrap-css', get_template_directory_uri() . '/assets/styles/bootstrap/css/bootstrap.min.css' );
}
add_action( 'wp_enqueue_scripts', 'wp_blank_load_styles' );

/**
 * Register widget area.
 *
 * @return void
 */
function wp_blank_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'wp-blank' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here to appear in your sidebar.', 'wp-blank' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'wp_blank_widgets_init' );


function yourmodule_create_shortcode_custom_post_type(){
 
    $args = array(
		'post_type'      => 'guides',
		'posts_per_page' => '10',
		'publish_status' => 'published',
	);
 
    $query = new WP_Query($args);
    if($query->have_posts()) :

		$result = "";
        while($query->have_posts()):
            $query->the_post() ;

			$result .= '<div class="card shadow-sm">';
				if(get_the_post_thumbnail_url()) {
					$result .= '<img src="'.get_the_post_thumbnail_url().'" />';
				}

				$result .= '<div class="card-body">';
					$result .= '<h3>'.get_the_title().'</h3>';
					$result .= '<p class="card-text">'.get_the_content().'</p>';
				$result .= '</div>';
			$result .= '</div>';
				
				// <div class="card-body">
				// 	<p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
				// 	<div class="d-flex justify-content-between align-items-center">
				// 		<div class="btn-group">
				// 			<button type="button" class="btn btn-sm btn-outline-secondary">View</button>
				// 			<button type="button" class="btn btn-sm btn-outline-secondary">Edit</button>
				// 		</div>
				// 		<small class="text-muted">9 mins</small>
				// 	</div>
				// </div>
				// </div>
            // $result .= get_the_post_thumbnail();
            // $result .= get_the_title();
            // $result .= get_the_content();
        endwhile;

        wp_reset_postdata();
    endif;    
    return $result;            
}
 
add_shortcode( 'guides-list', 'yourmodule_create_shortcode_custom_post_type' );

/**


add_action("admin_menu" , "hicaliber_admin_page_settings");
function hicaliber_admin_page_settings() {
	add_submenu_page(
		"edit.php?post_type=guides",
		'Settings',
        'Settings',
		"manage_options",
		"my-custom-submenu-page",
		"settings_page_callback"
		// basename(__FILE__), "custom_fuction",
	);
	
}



 * Display callback for the submenu page.
function settings_page_callback() { 

	
    ?>
		<div class="wrap">
			<h1><?php _e( 'Guides Settings', 'hicaliber' ); ?></h1>
			<p><?php _e( 'Style settings', 'hicaliber' ); ?></p>
			
			<form id="giveasap_subscribe_form" class="giveasap_form" method="post">
			<div class="form-group">
				<label for="section_title">Section Title</label>
				<input type="text" name="section_title" value="" />
			</div>
			<div class="form-group">
				<label for="section_title">Section Title</label>
				<input type="text" name="section_title" value="" />
			</div>
			<div class="form-group">
				<label for="section_title">Section Title</label>
				<input type="text" name="section_title" value="" />
			</div>
			<div class="form-group">
				<label for="section_title">Section Title</label>
				<input type="text" name="section_title" value="" />
			</div>
            <input type="text" name="sg_giveaway_subscriber" value="" />
            <?php
            do_action('sg_form_edit_before_button', $giveasap_front);
            wp_nonce_field('sg_form_edit', 'sg_form_edit_nonce');
            ?>
            <button type="submit" class="giveasap_button" name="giveasap_edit">
                <?php
                _e('Update', 'giveasap');
                ?>
            </button>

        </form>

		</div>
    <?php
}
 */
