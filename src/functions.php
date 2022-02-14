<?php

use ParagonIE\Sodium\Core\Curve25519\Ge\P2;


/**
 * Add theme support for various WordPress features.
 *
 * @return void
 */
function wp_blank_setup()
{
	// Support programmable title tag.
	add_theme_support('title-tag');

	// Support custom logo.

	/**
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on wp-blank, use a find and replace
	 * to change 'wp-blank' to the name of your theme in all the template files.
	 */
	load_theme_textdomain('wp-blank', get_template_directory() . '/languages');

	// Add default posts and comments RSS feed links to head.
	add_theme_support('automatic-feed-links');
	/*
         * Let WordPress manage the document title.
         * By adding theme support, we declare that this theme does not use a
         * hard-coded <title> tag in the document head, and expect WordPress to
         * provide it for us.
         */
	add_theme_support('title-tag');
	/*
         * Enable support for Post Thumbnails on posts and pages.
         *
         * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
         */
	add_theme_support('post-thumbnails');
	set_post_thumbnail_size(1568, 9999);
	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus(
		array(
			'menu-1' => __('Primary', 'wp-blank'),
			'footer' => __('Footer Menu', 'wp-blank'),
			'social' => __('Social Links Menu', 'wp-blank'),
		)
	);
	/*
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		)
	);
	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 190,
			'width'       => 190,
			'flex-width'  => false,
			'flex-height' => false,
		)
	);
	// Add theme support for selective refresh for widgets.
	add_theme_support('customize-selective-refresh-widgets');
	// Add support for Block Styles.
	add_theme_support('wp-block-styles');
	// Add support for full and wide align images.
	add_theme_support('align-wide');
	// Add support for editor styles.
	add_theme_support('editor-styles');
	// Enqueue editor styles.
	add_editor_style('style-editor.css');

	// Register top menu.
	register_nav_menus(
		array(
			'top' => esc_html__('Top Menu', 'wp-blank'),
		)
	);
}
add_action('after_setup_theme', 'wp_blank_setup');

/**
 * Specify JS bundle path.
 *
 * @return void
 */
function wp_blank_load_scripts()
{
	wp_enqueue_style('jquery', get_template_directory_uri() . '/js/jquery.min.js');
	wp_enqueue_style('bootstrap-js', get_template_directory_uri() . '/assets/styles/bootstrap/js/bootstrap.min.js');
}
add_action('wp_enqueue_scripts', 'wp_blank_load_scripts');

/**
 * Specify CSS bundle path.
 *
 * @return void
 */
function wp_blank_load_styles()
{
	wp_enqueue_style('main', get_template_directory_uri() . '/../dist/bundle.css');
	wp_enqueue_style('bootstrap-css', get_template_directory_uri() . '/assets/styles/bootstrap/css/bootstrap.min.css');
}
add_action('wp_enqueue_scripts', 'wp_blank_load_styles');

/**
 * Register widget area.
 *
 * @return void
 */
function wp_blank_widgets_init()
{
	register_sidebar(
		array(
			'name'          => esc_html__('Sidebar', 'wp-blank'),
			'id'            => 'sidebar-1',
			'description'   => esc_html__('Add widgets here to appear in your sidebar.', 'wp-blank'),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action('widgets_init', 'wp_blank_widgets_init');


function guide_shortcode($params = "")
{
	$filter = sanitize_text_field($_GET["filter"]);
	$class = "btn-outline-dark";
	$args = array(
		'post_type'      => 'guides',
		'posts_per_page' => '10',
		'publish_status' => 'published',
	);
	if ($filter == "featured") {
		$class = "btn-primary";
		$args['meta_query'] = [
			[
				'key' => 'featured',
				'value' => 1
			]
		];
	}

	$mdRows = 0;
	$smRows = 0;
	$xsRows = 0;
	$inlineimage = false;

	$query = new WP_Query($args);
	if ($query->have_posts()) :

		if ($params["smrows"]) {
			$smRows = $params["smrows"];
		}

		if ($params["xsrows"]) {
			$xsRows = $params["xsrows"];
		}

		if ($params["mdrows"]) {
			$mdRows = $params["mdrows"];
		}

		if (filter_var($params["inlineimage"], FILTER_VALIDATE_BOOLEAN)) {
			$inlineimage = true;
		}


		$result = "<div class='row w-25 mb-5 ms-auto'>";

		if ($filter == "featured") {
			$result .= "
			<div class='col'>
				<a class='btn btn-outline-dark text-center d-block' href='" . home_url() . "'>Recent</a>
			</div>";
		} else {
			$result .= "
			<div class='col'>
				<a class='btn btn-primary text-center d-block' href='" . home_url() . "'>Recent</a>
			</div>";
		}

		$result .= "
			<div class='col'>
				<a class='btn  " . $class . " text-center d-block' href='" . home_url() . "/?filter=featured'>Featured</a>
			</div>";

		$result .= "</div>";
		$result .= "<div class='container mb-5'>";
		$result .= "<div class='row row-cols-" . $xsRows . " row-cols-sm-" . $smRows . " row-cols-md-" . $mdRows . " g-3'>";

		while ($query->have_posts()) :

			$query->the_post();
			$content = get_the_content();
			$title = get_the_title();
			$image = get_the_post_thumbnail_url();
			$terms = get_the_terms(get_the_ID(), 'categories');
			$isFeatured = get_post_meta(get_the_ID(), 'featured');

			$category = "Uncategorized";

			foreach ($terms as $term) {
				$category = $term->name;
			}

			if (!$inlineimage) {
				$result .= format_card_block($title, $content, $image, $category);
			} else {
				$result .= format_card_inline_block($title, $content, $image, $category);
			}

		endwhile;

		$result .= '</div>';
		$result .= '</div>';
		wp_reset_postdata();
	endif;
	return $result;
}

add_shortcode('guides-list', 'guide_shortcode');

function format_card_block($title, $content, $image, $category)
{
	$result = "";
	$result .= "<div class='col'>";
	$result .= '<div class="card shadow-sm card-custom">';

	$result .= '<div class="card-img">';
	if ($image) {
		$result .= '<img src="' . $image . '" />';
	} else {
		$result .= '<svg class="bd-placeholder-img card-img-top" width="100%" height="225" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: Thumbnail" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#55595c"></rect><text x="50%" y="50%" fill="#eceeef" dy=".3em">Thumbnail</text></svg>';
	}
	$result .= '</div>';

	$result .= '<div class="card-body">';
	$result .= '<button type="button" class="btn btn-outline-dark mb-2">' . $category . '</button>';

	$result .= '<h3>' . $title . '</h3>';
	$result .= '<p class="card-text">' . mb_strimwidth($content, 0, 200, '...') . '</p>';
	$result .= '</div>';
	$result .= '</div>';
	$result .= '</div>';

	return $result;
}
function format_card_inline_block($title, $content, $image, $category)
{
	$result = "";
	$result .= "<div class='col'>";
	$result .= '<div class="card shadow-sm card-custom inline-block">';

	$result .= '<div class="col d-flex align-items-start">';
	$result .= '<div class="card-img w-25">';
	if ($image) {
		$result .= '<img src="' . $image . '" />';
	} else {
		$result .= '<svg class="bd-placeholder-img card-img-top" width="100%" height="225" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: Thumbnail" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#55595c"></rect><text x="50%" y="50%" fill="#eceeef" dy=".3em">Thumbnail</text></svg>';
	}
	$result .= '</div>';

	$result .= '<div class="card-body w-75">';
	$result .= '<h3>' . $title . '</h3>';
	$result .= '<p class="card-text">' . mb_strimwidth($content, 0, 100, '...') . '</p>';
	$result .= '<button type="button" class="btn btn-outline-dark">' . $category . '</button>';
	$result .= '</div>';
	$result .= '</div>';
	$result .= '</div>';
	$result .= '</div>';

	return $result;
}
