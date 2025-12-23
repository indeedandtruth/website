<?php

use Timber\Site;

/**
 * Class StarterSite
 */
class StarterSite extends Site {
	public function __construct() {
		add_action( 'after_setup_theme', array( $this, 'theme_supports' ) );
		add_action( 'after_setup_theme', array( $this, 'register_menus' ) );
		add_action( 'init', array( $this, 'register_post_types' ) );
		add_action( 'init', array( $this, 'register_taxonomies' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'register_admin_scripts' ) );
		add_action( 'wp_default_scripts', array( $this, 'dequeue_jquery_migrate') );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

		add_filter( 'timber/context', array( $this, 'add_to_context' ) );
		add_filter( 'timber/twig', array( $this, 'add_to_twig' ) );
		add_filter( 'timber/twig/environment/options', array( $this, 'update_twig_environment_options' ) );

		add_action( 'acf/init', array($this, 'register_acf_blocks' ) );

		parent::__construct();
	}

	/**
	 * This is where you can register custom post types.
	 */
	public function register_post_types() {

	}

	/**
	 * This is where you can register custom taxonomies.
	 */
	public function register_taxonomies() {

	}

	/**
	 * This is where you can register admin scripts
	 */
	public function register_admin_scripts($hook) {
		if ( 'nav-menus.php' !== $hook ) {
			return;
		}
		wp_enqueue_script( 'idat-admin-menus', get_stylesheet_directory_uri() . '/static/admin-menus.js', array(), '1.0.0', true);
	}

	/**
	 * This is where you can register custom menus
	 */
	public function register_menus() {
		register_nav_menus([
			'top' => 'Top Menu',
			'bottom' => 'Bottom Menu'
		]);
	}

	/**
	 * This is where you can eqnuue scripts and styles.
	 */
	public function enqueue_scripts() {
		// Conditionally enqueue block styles only when blocks are used on the page
		if ( has_block( 'acf/stats' ) || $this->has_stats_in_content() ) {
			wp_enqueue_style('stats-block', get_stylesheet_directory_uri() . '/blocks/stats/stats.css', array(), null );
		}
		if ( has_block( 'acf/cta' ) ) {
			wp_enqueue_style('cta-block', get_stylesheet_directory_uri() . '/blocks/cta/cta.css', array(), null );
		}
		wp_enqueue_style('startersite', get_stylesheet_uri(), array(), null );
		wp_register_script('alpine', 'https://cdn.jsdelivr.net/npm/alpinejs@3.15.x/dist/cdn.min.js', array(), null, true);
		wp_enqueue_script('startersite', get_template_directory_uri() . '/static/site.js', array('jquery','alpine'), '1.0.1', true );
	}
	
	/**
	 * Check if stats block is used in Twig templates (like index.twig)
	 */
	private function has_stats_in_content() {
		// Check if we're on the homepage where stats are used in Twig
		return is_front_page() || is_home();
	}

	public function dequeue_jquery_migrate( $scripts ) {
		if ( ! is_admin() && ! empty( $scripts->registered['jquery'] ) ) {
			$scripts->registered['jquery']->deps = array_diff(
				$scripts->registered['jquery']->deps,
				[ 'jquery-migrate' ]
			);
		}
	}

	/**
	 * This is where you add some context
	 *
	 * @param string $context context['this'] Being the Twig's {{ this }}.
	 */
	public function add_to_context( $context ) {
		$context['site'] = $this;
		$context['menu_top'] = Timber::get_menu('top', [
			'depth' => 2,
		]);
		$context['menu_bottom'] = Timber::get_menu('bottom', [
			'depth' => 2,
		]);
		$context['logo'] = get_stylesheet_directory_uri() . '/static/logo.svg';
		return $context;
	}

	public function theme_supports() {
		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
			)
		);

		/*
		 * Enable support for Post Formats.
		 *
		 * See: https://codex.wordpress.org/Post_Formats
		 */
		/*add_theme_support(
			'post-formats',
			array(
				'aside',
				'image',
				'video',
				'quote',
				'link',
				'gallery',
				'audio',
			)
		);*/

		add_theme_support( 'menus' );

		add_post_type_support( 'page', 'excerpt' );
		
	}

	/**
	 * his would return 'foo bar!'.
	 *
	 * @param string $text being 'foo', then returned 'foo bar!'.
	 */
	public function myfoo( $text ) {
		$text .= ' bar!';
		return $text;
	}

	/**
	 * This is where you can add your own functions to twig.
	 *
	 * @param Twig\Environment $twig get extension.
	 */
	public function add_to_twig( $twig ) {
		/**
		 * Required when you want to use Twig’s template_from_string.
		 * @link https://twig.symfony.com/doc/3.x/functions/template_from_string.html
		 */
		// $twig->addExtension( new Twig\Extension\StringLoaderExtension() );

		//$twig->addFilter( new Twig\TwigFilter( 'myfoo', [ $this, 'myfoo' ] ) );

		return $twig;
	}

	/**
	 * Updates Twig environment options.
	 *
	 * @link https://twig.symfony.com/doc/2.x/api.html#environment-options
	 *
	 * \@param array $options An array of environment options.
	 *
	 * @return array
	 */
	function update_twig_environment_options( $options ) {
	    // $options['autoescape'] = true;

	    return $options;
	}

	/**
	 * ACF
	 */
	function register_acf_blocks() {
		if (!class_exists('ACF')) {
			return;
		}
		
		$theme_path = dirname(__FILE__, 2);
		
		/**
		 * Register blocks using WordPress's register_block_type() which automatically
		 * reads block.json and should handle style enqueuing. However, ACF blocks with
		 * custom renderTemplate may not always trigger automatic style loading, so we
		 * also conditionally enqueue in enqueue_scripts() as a fallback.
		 *
		 * @link https://developer.wordpress.org/reference/functions/register_block_type/
		 */
		register_block_type( $theme_path . '/blocks/stats' );
		register_block_type( $theme_path . '/blocks/cta' );
	}
	
}
