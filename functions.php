<?php
/**
 * EuCoasters functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package EuCoasters
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function eu_coasters_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on EuCoasters, use a find and replace
		* to change 'eu-coasters' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'eu-coasters', get_template_directory() . '/languages' );

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

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Primary', 'eu-coasters' ),
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
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'eu_coasters_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'eu_coasters_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function eu_coasters_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'eu_coasters_content_width', 640 );
}
add_action( 'after_setup_theme', 'eu_coasters_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function eu_coasters_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'eu-coasters' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'eu-coasters' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'eu_coasters_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function eu_coasters_scripts() {
	wp_enqueue_style( 'eu-coasters-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_style_add_data( 'eu-coasters-style', 'rtl', 'replace' );

	wp_enqueue_script( 'eu-coasters-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}

add_action( 'wp_enqueue_scripts', 'eu_coasters_scripts' );

function home_enqueue_styles() {
    if(is_front_page()) {
        wp_enqueue_style('home', get_stylesheet_directory_uri() . '/css/home.css');
    }
}
add_action( 'wp_enqueue_scripts', 'home_enqueue_styles' );

function archives_enqueue_styles() {
    // Création d'un tableau avec les IDs des pages concernées
    $target_pages = [9, 11];
    if(is_page($target_pages)) {
        wp_enqueue_style('archives', get_stylesheet_directory_uri() . '/css/archives.css');
    }
}
add_action( 'wp_enqueue_scripts', 'archives_enqueue_styles' );

// Ajouter du style aux entités des CPT
add_action('wp_enqueue_scripts', function () {
    if (is_singular('parc') || is_singular('coaster')) {
        wp_enqueue_style('single-cpt-style', get_template_directory_uri() . '/css/single-cpt.css');
    }
});

// Ajouter du style aux archives des CPT
add_action('wp_enqueue_scripts', function () {
    if ( is_post_type_archive( 'parc' ) || is_post_type_archive( 'coaster' ) ) {
        wp_enqueue_style( 'archive-cpt', get_template_directory_uri() . '/css/archive-cpt.css' );
    }
});

// Ajouter du style à la page Contact
function contact_enqueue_styles() {
    if(is_page(96)) {
        wp_enqueue_style('contact', get_stylesheet_directory_uri() . '/css/contact.css');
    }
}
add_action( 'wp_enqueue_scripts', 'contact_enqueue_styles' );

require get_template_directory() . '/inc/custom-header.php';
require get_template_directory() . '/inc/template-tags.php';
require get_template_directory() . '/inc/template-functions.php';
require get_template_directory() . '/inc/customizer.php';

if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

// Custom taxonomy : Hide description field
function my_admin_area_custom_css() {
    echo '<style>
        .form-field.term-description-wrap {
            display:none;
        }
  </style>';
}

add_action('admin_head', 'my_admin_area_custom_css');

// Ajouter une colonne dans l'écran d'administration de la taxonomie "Pays"
add_filter('manage_edit-pays_columns', function ($columns) {
    $columns['code_pays'] = 'Code pays';
    return $columns;
});

add_action('manage_pays_custom_column', function ($content, $column_name, $term_id) {
    if ($column_name === 'code_pays') {
        // Récupérer la valeur du champ personnalisé "Code pays"
        $code_pays = get_term_meta($term_id, 'code_pays', true);
        if ($code_pays) {
            $content = esc_html($code_pays);
        } else {
            $content = '—'; // Valeur par défaut si le champ est vide
        }
    }
    return $content;
}, 10, 3);
// 10 : Priorité par défaut sur Wordpress / 3 : Nombre d'arguments passés dans la fonction

add_action('wp_enqueue_scripts', function () {
    if (is_singular('coaster')) {
        wp_enqueue_style('single-coaster-style', get_template_directory_uri() . '/css/single-coaster.css');
    }
});

//Hero section dynamique
function render_hero_section($args = []) {
    $defaults = [
        'background_image' => '',
        'title'            => 'Titre par défaut',
        'paragraph'        => 'Texte par défaut',
        'cta_1_title'      => 'CTA 1',
        'cta_1_link'       => '#',
        'cta_2_title'      => 'CTA 2',
        'cta_2_link'       => '#',
    ];
    $args = wp_parse_args($args, $defaults);

    ?>
    <section class="hero-section" style="background-image: url('<?php echo esc_url($args['background_image']); ?>');">
        <div class="hero-content">
            <h1><?php echo esc_html($args['title']); ?></h1>
            <p><?php echo esc_html($args['paragraph']); ?></p>

            <?php if (is_front_page()) : ?>
                <div class="cta-buttons">
                    <a href="<?php echo esc_url($args['cta_1_link']); ?>" class="cta-button cta-1">
                        <?php echo esc_html($args['cta_1_title']); ?>
                    </a>
                    <a href="<?php echo esc_url($args['cta_2_link']); ?>" class="cta-button cta-2">
                        <?php echo esc_html($args['cta_2_title']); ?>
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </section>
    <?php
}

