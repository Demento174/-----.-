<?php
/**
 * Printmetalls functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage Printmetalls
 * @since 1.0
 */
/**
 * Директория для шаблонов twig
 */
Timber::$dirname ='template-parts/blocks';
/**
 * Main setup
 */
add_action( 'after_setup_theme', 'template_setup');
function template_setup() {

    load_theme_textdomain( 'template', get_template_directory() . '/languages' );

    add_theme_support( 'automatic-feed-links' );

    add_theme_support( 'post-thumbnails' );

    register_nav_menus( array(
        'header_menu' => 'Основное меню'
    ) );
    add_theme_support( 'title-tag' );

    add_theme_support( 'post-thumbnails' );

    add_theme_support( 'html5', array(
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ) );

    add_theme_support( 'post-formats', array(
        'aside',
        'image',
        'video',
        'quote',
        'link',
        'gallery',
        'audio',
    ) );

    add_theme_support( 'customize-selective-refresh-widgets' );
}

/**
 * connect js scripts and css in head
 */

add_action( 'wp_enqueue_scripts', 'template_scripts' );
function template_scripts(){
	//JQ
	wp_enqueue_script( 'template-js-jquery', get_template_directory_uri().'/libs/jquery.min.js', array(), '3.3.1');
	wp_enqueue_script( 'template-js-jq_migrate', 'http://code.jquery.com/jquery-migrate-1.2.1.js', array(), '1.2.1');
	//FONTS
	wp_enqueue_style('template-style-fonts', get_template_directory_uri().'/assets/fonts/fonts.css');

	//Bootstrap
	wp_enqueue_style('template-style-bootstrap', get_template_directory_uri().'/libs/bootstrap/bootstrap.min.css');
	wp_enqueue_script( 'template-js-bootstrap', get_template_directory_uri().'/libs/bootstrap/bootstrap.js', array(), '412');

	//font_awesome
	wp_enqueue_style('template-style-font_awesome', get_template_directory_uri().'/libs/font_awesome/font-awesome.min.css');
	wp_enqueue_script( 'template-js-font_awesome', get_template_directory_uri().'/libs/font_awesome/fontawesome.min.js', array(), '412');

	//fancybox
	wp_enqueue_script( 'template-js-fancybox', get_template_directory_uri().'/libs/fancybox/jquery.fancybox.min.js', array());
	wp_enqueue_style('template-style-fancybox', get_template_directory_uri().'/libs/fancybox/jquery.fancybox.min.css');

	//owl
	wp_enqueue_script( 'template-js-owl', get_template_directory_uri().'/libs/owl/owl.carousel.min.js', array());
	wp_enqueue_style('template-style-owl', get_template_directory_uri().'/libs/owl/owl.carousel.min.css');
	wp_enqueue_style('template-style-owl', get_template_directory_uri().'/libs/owl/owl.theme.default.min.css');

	//common
	wp_enqueue_script( 'template-js-javaScript', get_template_directory_uri().'/assets/js/common.js', array());
	wp_enqueue_style('template-style-main', get_template_directory_uri().'/assets/less/main.less');
	wp_enqueue_style('template-style-media', get_template_directory_uri().'/assets/less/media.less');
	wp_enqueue_style('template-style-animate', get_template_directory_uri().'/assets/css/CssAnimation.css');
}

/**
 * Static front page
 */
add_filter( 'frontpage_template',  'template_front_page_template' );
function template_front_page_template( $template ) {
    return is_home() ? '' : $template;
}

/**
 * Menu to ACF plugin
 */
$args = array(

    'page_title' => 'Настройка Сайта',

    'menu_title' => 'Настройка Сайта',

    'menu_slug' => 'option_site',

    'position' => 25,

    'parent_slug' => '',

    'icon_url' => 'dashicons-admin-tools',

    'redirect' => true,

    'post_id' => 'options',

    'autoload' => false,

    'update_button'		=> __('Update', 'acf'),

    'updated_message'	=> __("Options Updated", 'acf')
);

acf_add_options_page( $args );

/**
 * logo and backGround Admin panel
 */

add_action('login_head', 'custom_login_page');

add_action('login_head', 'my_custom_login_logo');

add_action('add_admin_bar_menus', 'reset_admin_wplogo');

function custom_login_page() {

    echo '<link rel="stylesheet" type="text/css" href="' . get_bloginfo( 'template_directory' ) . '/css/admin.css" />';
}

function my_custom_login_logo(){

    echo '<style type="text/css">
	
	h1 a { background-image:url('.get_bloginfo('template_directory').'/img/logo_admin.png) !important; }
	
	</style>';
}

function reset_admin_wplogo(  ){

    remove_action( 'admin_bar_menu', 'wp_admin_bar_wp_menu', 10 ); // удаляем стандартную панель (логотип)

    add_action( 'admin_bar_menu', 'my_admin_bar_wp_menu', 10 ); // добавляем свою
}

function my_admin_bar_wp_menu( $wp_admin_bar ) {

    $wp_admin_bar->add_menu( array(

        'id'    => 'wp-logo',

        'title' => '<img style="max-width:40px;height:40px;" src="'. get_bloginfo('template_directory') .'/img/logo_admin.png" alt="" >', // иконка dashicon

        'href'  => home_url('/about/'),

        'meta'  => array(

            'title' => 'О моем сайте',
        ),
    ) );
}


/**
Announcement of the article
 */
function the_truncated_post($post) {

    $filtered = strip_tags( preg_replace('@<style[^>]*?>.*?</style>@si', '', preg_replace('@<script[^>]*?>.*?</script>@si', '',$post->post_content)) );

    echo substr($filtered, 0, strrpos(substr($filtered, 0, 450), ' ')) . '...';
}


/**
 * upload social icons
 * gets parameters name social icon or all
 */
function social_icon($socNet=''){

    $social_array=get_field('social_networks','option');

    $social_icons=array();

    $social_icons_bar='';

    $color='';

    foreach ($social_array as $item){

        $social_title=$item['social_title'];

        unset($item['social_title']);

        $social_icons[$social_title]=$item;
    }

    if($socNet=='all'){

        foreach ($social_icons as $key=> $item){

            $icon=$item['social_icon'];

            $key!=='instagram' ? $color=$item['social_color'] : $color='linear-gradient(45deg, #f09433 0%,#e6683c 25%,#dc2743 50%,#cc2366 75%,#bc1888 100%)';

            $link=$item['social_link'];

            $social_icons_bar.='<span class="social_icon" style="background: '.$color.'">';

            $social_icons_bar.='<a href='.$link.' target="_blank">'.$icon.'</a>';

            $social_icons_bar.='</span>';

        }


    }elseif (isset($social_icons[$socNet])){

        $color='';

        $icon=$social_icons[$socNet]['social_icon'];

        $socNet!=='instagram' ? $color=$social_icons[$socNet]['social_color'] : $color='linear-gradient(45deg, #f09433 0%,#e6683c 25%,#dc2743 50%,#cc2366 75%,#bc1888 100%)';

        $link=$social_icons[$socNet]['social_link'];

        $social_icons_bar='<span class="social_icon" style="background: '.$color.'">';

        $social_icons_bar.='<a href='.$link.' target="_blank">'.$icon.'</a>';

        $social_icons_bar.='</span>';


    }else{

        return '';

    }



    return $social_icons_bar;
}


/**
 * disable wp editor
 */
add_action( 'admin_init', 'disable_content_editor' );
function disable_content_editor() {

    $post_id = $_GET['post'] ? $_GET['post'] : $_POST['post_ID'] ;

    if( !isset( $post_id ) ) return;

    $template_file = get_post_meta($post_id, '_wp_page_template', true);

    if ( $template_file == 'template-parts/template-main.php' || $template_file == 'template-parts/template-team.php' || $template_file == 'template-parts/template-contact.php' || $template_file == 'template-parts/template-sanitary_standarts.php' || $template_file == 'template-parts/template-first_lesson.php' || $template_file == 'template-parts/template-questions.php' || $template_file == 'template-parts/template-reviews.php'  ) {

        remove_post_type_support( 'page', 'editor' );

    }
}

/**
 * disable menu item
 */
add_action('admin_menu', 'remove_admin_menu');
function remove_admin_menu() {
    remove_menu_page('plugins.php'); // Плагины
    remove_menu_page('edit.php'); // Посты блога
//    remove_menu_page('upload.php'); // Медиабиблиотека
    remove_menu_page('edit-comments.php'); // Комментарии
    remove_menu_page('themes.php'); // Внешний вид
    remove_menu_page('edit.php?post_type=page'); // Страницы
//    remove_menu_page('options-general.php');  //Удаляем раздел Настройки
    remove_menu_page('tools.php'); // Инструменты
//    remove_menu_page('users.php'); // Пользователи
    remove_menu_page('link-manager.php'); // Ссылки
}

/**
 * include files in template
 */

function my_get_template_part($template, $data = array()){
    extract($data);

    require locate_template($template.'.php');
}

/**

 * Custom Posts Types

 */

add_action('init', 'register_posts_types');
function register_posts_types(){
	//------------------marks

	$labels_dish = array(
		'name' => _x( 'Блюда', 'dishs' ),
		'singular_name' => _x( 'Блюда', 'dishs' ),
		'add_new' => _x( 'Добавить новое блюдо', 'dishs' ),
		'add_new_item' => _x( 'Добавить новое блюдо', 'dishs' ),
		'edit_item' => _x( 'Редактировать блюдо', 'dishs' ),
		'new_item' => _x( 'Новая страница блюда', 'reviews' ),
		'view_item' => _x( 'Посмотреть страницу блюда', 'dishs' ),
		'search_items' => _x( 'Искать', 'dishs' ),
		'not_found' => _x( 'Нет такой страницы блюда', 'dishs' ),
		'not_found_in_trash' => _x( 'Нет удаленных блюд', 'dishs' ),
		'parent_item_colon' => _x( 'Родитель объекта:', 'dishs' ),
		'menu_name' => _x( 'Блюда', 'dishs' ),
	);

	$args_dish = array(
		'labels' => $labels_dish,
//		'show_in_menu' => 'cars',
		'hierarchical' => false,
		'supports' => array( 'title', 'thumbnail', 'editor','custom-fields'),
		'public' => true,
		'map_meta_cap' => true,
		'show_ui' => true,
		'menu_position'=>12,
		'menu_icon' => 'dashicons-image-filter',
		'show_in_nav_menus' => false,
		'publicly_queryable' => true,
//        'permalink_epmask'=>EP_ALL,
		'exclude_from_search' => true,
		'has_archive' => true,
		'query_var' => true,
		'can_export' => false,
		'rewrite' => true,
		'capability_type' => 'page',
	);




	register_post_type( 'dish', $args_dish );
}
add_action ( 'init', 'create_tax_specialOffers' );
function create_tax_specialOffers(){
	$labels = array(
		'name' => _x('Категории блюд', 'taxonomy general name'),
		'singular_name' => _x('Категория блюда', 'taxonomy singular name'),
		'search_items' => __('Поиск по категориям'),
		'all_items' => __('Все категории'),
		'parent_item' => __('Родительская категория'),
		'parent_item_colon' => __('Родительская категория:'),
		'edit_item' => __('Редактировать категорию'),
		'update_item' => __('Обновить категорию'),
		'add_new_item' => __('Добавить новую категорию'),
		'new_item_name' => __('Имя новой категории'),
		'menu_name' => __('Категории блюд'),
	);

	register_taxonomy('tax_dish', array('dish'), array(
		'hierarchical' => true,
		'labels' => $labels,
		'show_ui' => true,
		'query_var' => true,
		'rewrite' => false
	));
}

/**
 * logs
 */
function logs($txt = "")
{
    try{
        $fp = fopen(__DIR__ . "/log_new.txt", "a"); // Открываем файл в режиме записи
        if(is_array($txt)){

            fwrite($fp,"\n". date("d-m-Y_H:i:s")." -- > ".print_r($txt,TRUE));

        }else{
            fwrite($fp,"\n". date("d-m-Y_H:i:s")." -- > ".$txt);
        }


        fclose($fp); //Закрытие файла
    }catch (Exception $e) { return false; }

    return true;
}
