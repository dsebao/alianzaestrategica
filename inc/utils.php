<?php 


// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Main urls
 */
function url(){
	echo get_bloginfo('url');
}

/**
 * Template urls
 */
function urlt(){
	echo get_bloginfo('template_url');
}

function getparams($g){
    if(isset($_GET[$g])){
        return $_GET[$g];
    } else {
        return '';
    }
}

 

/*
*
* url de la imagen de gravatar
*
*/
function get_the_avatar_url($get_avatar){
    preg_match('#src=["|\'](.+)["|\']#Uuis', $get_avatar, $matches);
    return $matches[1];
}


/**
 * 
 * Create html button for email notification
 *
 */
function htmlButton($l,$t){
    $button = '<div><!--[if mso]><v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word" href="'.$l.'" style="height:40px;v-text-anchor:middle;width:200px;" arcsize="15%" stroke="f" fillcolor="#4137CF"><w:anchorlock/><center><![endif]--><a href="'.$l.'" style="background-color:#4137CF;border-radius:6px;color:#ffffff;display:inline-block;font-family:sans-serif;font-size:13px;font-weight:bold;line-height:40px;text-align:center;text-decoration:none;width:200px;-webkit-text-size-adjust:none;">'.$t.'</a><!--[if mso]></center></v:roundrect><![endif]--></div>';
    return $button;
}



/**
 * Disable Emoji mess
 */
 
function disable_wp_emojicons() {
    remove_action( 'admin_print_styles', 'print_emoji_styles' );
    remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
    remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
    remove_action( 'wp_print_styles', 'print_emoji_styles' );
    remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
    remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
    remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
    add_filter( 'tiny_mce_plugins', 'disable_emojicons_tinymce' );
    add_filter( 'emoji_svg_url', '__return_false' );
}
add_action( 'init', 'disable_wp_emojicons' );

function disable_emojicons_tinymce( $plugins ) {
    return is_array( $plugins ) ? array_diff( $plugins, array( 'wpemoji' ) ) : array();
}

/**
 * Disable xmlrpc.php and feed link rss
 */
 
add_filter( 'xmlrpc_enabled', '__return_false' );
remove_action( 'wp_head' , 'rsd_link' );
remove_action( 'wp_head' , 'wlwmanifest_link' );
remove_action( 'wp_head' , 'feed_links', 2 );
remove_action( 'wp_head' , 'feed_links_extra' , 3 );
remove_action( 'wp_head' , 'rest_output_link_wp_head' );
remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
remove_action( 'template_redirect', 'rest_output_link_header', 11 );

/**
 * Remove Wp Embed js from footer
 *
 * @return void
 */
function my_deregister_scripts(){
	wp_dequeue_script( 'wp-embed' );
}
add_action( 'wp_footer', 'my_deregister_scripts' );

/**
 * emove Guttenberg scripts
 *
 * @return void
 */
function smartwp_remove_wp_block_library_css(){
	wp_dequeue_style( 'wp-block-library' );
	wp_dequeue_style( 'wc-block-style' );
}
add_action( 'wp_enqueue_scripts', 'smartwp_remove_wp_block_library_css', 100 );

/**
 * Feed links blocked
 *
 * @return void
 */
function itsme_disable_feed() {
	wp_die( __( 'No feed available, please visit the <a href="'. esc_url( home_url( '/' ) ) .'">homepage</a>!' ) );
}

add_action('do_feed', 'itsme_disable_feed', 1);
add_action('do_feed_rdf', 'itsme_disable_feed', 1);
add_action('do_feed_rss', 'itsme_disable_feed', 1);
add_action('do_feed_rss2', 'itsme_disable_feed', 1);
add_action('do_feed_atom', 'itsme_disable_feed', 1);
add_action('do_feed_rss2_comments', 'itsme_disable_feed', 1);
add_action('do_feed_atom_comments', 'itsme_disable_feed', 1);



/* ----------------------------------------------------------------------------
 * Remove WordPress version from header
 * ------------------------------------------------------------------------- */

function simple_remove_version_info() {
	return '';
}
add_filter( 'the_generator', 'simple_remove_version_info' );


/* ----------------------------------------------------------------------------
 * Remove welcome panel in dashboard
 * ------------------------------------------------------------------------- */

remove_action('welcome_panel', 'wp_welcome_panel');


/** 
 * Disable JSON REST API  
 */

add_filter('json_enabled', '__return_false');
add_filter('json_jsonp_enabled', '__return_false');

/**
 * PHP Logger
 */

function php_logger( $data ) {
    $output = $data;
    if ( is_array( $output ) )
        $output = implode( ',', $output );
        
    // print the result into the JavaScript console
    echo "<script>console.log( 'PHP LOG: " . $output . "' );</script>";
}


//Agregar imagenes a los posteos
function insert_attachment($file_handler,$post_id,$setthumb='false') {
	if ($_FILES[$file_handler]['error'] !== UPLOAD_ERR_OK) __return_false();

	require_once(ABSPATH . "wp-admin" . '/includes/image.php');
	require_once(ABSPATH . "wp-admin" . '/includes/file.php');
	require_once(ABSPATH . "wp-admin" . '/includes/media.php');

	$attach_id = media_handle_upload( $file_handler, $post_id );

	if ($setthumb) update_post_meta($post_id,'_thumbnail_id',$attach_id);
	return $attach_id;
}


function breadcrumbs() {
	/* === OPTIONS === */
	$text['home']     = 'Inicio'; // text for the 'Home' link
	$text['category'] = 'Archivo por categoria "%s"'; // text for a category page
	$text['search']   = 'Resultado de la busqueda "%s"'; // text for a search results page
	$text['tag']      = 'Articulos con el tag "%s"'; // text for a tag page
	$text['author']   = 'Articulos pyblicados por %s'; // text for an author page
	$text['404']      = 'Error 404'; // text for the 404 page
	$show_current   = 1; // 1 - show current post/page/category title in breadcrumbs, 0 - don't show
	$show_on_home   = 0; // 1 - show breadcrumbs on the homepage, 0 - don't show
	$show_home_link = 1; // 1 - show the 'Home' link, 0 - don't show
	$show_title     = 1; // 1 - show the title for the links, 0 - don't show
	$delimiter      = ' &raquo; '; // delimiter between crumbs
	$before         = '<span class="current">'; // tag before the current crumb
	$after          = '</span>'; // tag after the current crumb
	/* === END OF OPTIONS === */
	global $post;
	$home_link    = home_url('/');
	$link_before  = '<span typeof="v:Breadcrumb">';
	$link_after   = '</span>';
	$link_attr    = ' rel="v:url" property="v:title"';
	$link         = $link_before . '<a' . $link_attr . ' href="%1$s">%2$s</a>' . $link_after;
	$post == is_singular() ? get_queried_object() : false;	
	if( $post ){
		$parent_id    = $parent_id_2 = $post->post_parent;
	} else {
		$parent_id    = $parent_id_2 = 0;
	}
	$frontpage_id = get_option('page_on_front');
	if (is_home() || is_front_page()) {
		if ($show_on_home == 1) echo '<div class="breadcrumbs"><a href="' . $home_link . '">' . $text['home'] . '</a></div>';
	} else {
		echo '<div class="breadcrumbs" xmlns:v="http://rdf.data-vocabulary.org/#">';
		if ($show_home_link == 1) {
			echo '<a href="' . $home_link . '" rel="v:url" property="v:title">' . $text['home'] . '</a>';
			if ($frontpage_id == 0 || $parent_id != $frontpage_id) echo $delimiter;
		}
		if ( is_category() ) {
			$this_cat = get_category(get_query_var('cat'), false);
			if ($this_cat->parent != 0) {
				$cats = get_category_parents($this_cat->parent, TRUE, $delimiter);
				if ($show_current == 0) $cats = preg_replace("#^(.+)$delimiter$#", "$1", $cats);
				$cats = str_replace('<a', $link_before . '<a' . $link_attr, $cats);
				$cats = str_replace('</a>', '</a>' . $link_after, $cats);
				if ($show_title == 0) $cats = preg_replace('/ title="(.*?)"/', '', $cats);
				echo $cats;
			}
			if ($show_current == 1) echo $before . sprintf($text['category'], single_cat_title('', false)) . $after;
		} elseif ( is_search() ) {
			echo $before . sprintf($text['search'], get_search_query()) . $after;
		} elseif ( is_day() ) {
			echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;
			echo sprintf($link, get_month_link(get_the_time('Y'),get_the_time('m')), get_the_time('F')) . $delimiter;
			echo $before . get_the_time('d') . $after;
		} elseif ( is_month() ) {
			echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;
			echo $before . get_the_time('F') . $after;
		} elseif ( is_year() ) {
			echo $before . get_the_time('Y') . $after;
		} elseif ( is_single() && !is_attachment() ) {
			if ( get_post_type() != 'post' ) {
				$post_type = get_post_type_object(get_post_type());
				$slug = $post_type->rewrite;
				printf($link, $home_link . $slug['slug'] . '/', $post_type->labels->singular_name);
				if ($show_current == 1) echo $delimiter . $before . get_the_title() . $after;
			} else {
				$cat = get_the_category(); $cat = $cat[0];
				$cats = get_category_parents($cat, TRUE, $delimiter);
				if ($show_current == 0) $cats = preg_replace("#^(.+)$delimiter$#", "$1", $cats);
				$cats = str_replace('<a', $link_before . '<a' . $link_attr, $cats);
				$cats = str_replace('</a>', '</a>' . $link_after, $cats);
				if ($show_title == 0) $cats = preg_replace('/ title="(.*?)"/', '', $cats);
				echo $cats;
				if ($show_current == 1) echo $before . get_the_title() . $after;
			}
		} elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {
			$post_type = get_post_type_object(get_post_type());
			echo $before . $post_type->labels->singular_name . $after;
		} elseif ( is_attachment() ) {
			$parent = get_post($parent_id);
			$cat = get_the_category($parent->ID);
			if( isset($cat[0]) ){ 
				$cat = $cat[0];
			}
			if ($cat) {
				$cats = get_category_parents($cat, TRUE, $delimiter);
				$cats = str_replace('<a', $link_before . '<a' . $link_attr, $cats);
				$cats = str_replace('</a>', '</a>' . $link_after, $cats);
				if ($show_title == 0) $cats = preg_replace('/ title="(.*?)"/', '', $cats);
				echo $cats;
			}
			printf($link, get_permalink($parent), $parent->post_title);
			if ($show_current == 1) echo $delimiter . $before . get_the_title() . $after;
		} elseif ( is_page() && !$parent_id ) {
			if ($show_current == 1) echo $before . get_the_title() . $after;
		} elseif ( is_page() && $parent_id ) {
			if ($parent_id != $frontpage_id) {
				$breadcrumbs = array();
				while ($parent_id) {
					$page = get_page($parent_id);
					if ($parent_id != $frontpage_id) {
						$breadcrumbs[] = sprintf($link, get_permalink($page->ID), get_the_title($page->ID));
					}
					$parent_id = $page->post_parent;
				}
				$breadcrumbs = array_reverse($breadcrumbs);
				for ($i = 0; $i < count($breadcrumbs); $i++) {
					echo $breadcrumbs[$i];
					if ($i != count($breadcrumbs)-1) echo $delimiter;
				}
			}
			if ($show_current == 1) {
				if ($show_home_link == 1 || ($parent_id_2 != 0 && $parent_id_2 != $frontpage_id)) echo $delimiter;
				echo $before . get_the_title() . $after;
			}
		} elseif ( is_tag() ) {
			echo $before . sprintf($text['tag'], single_tag_title('', false)) . $after;
		} elseif ( is_author() ) {
	 		global $author;
			$userdata = get_userdata($author);
			echo $before . sprintf($text['author'], $userdata->display_name) . $after;
		} elseif ( is_404() ) {
			echo $before . $text['404'] . $after;
		} elseif ( has_post_format() && !is_singular() ) {
			echo get_post_format_string( get_post_format() );
		}
		if ( get_query_var('paged') ) {
			if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ' (';
			echo __('Page') . ' ' . get_query_var('paged');
			if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ')';
		}
		echo '</div><!-- .breadcrumbs -->';
	}
} // end dimox_breadcrumbs()


/*
    Get content via cUrl
*/

function url_get_contents ($Url) {
    if (!function_exists('curl_init')){ 
        die();
    }
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $Url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $output = curl_exec($ch);
    curl_close($ch);
    return $output;
}



/* 
    remove wordpress logo and menu admin bar
*/
function remove_admin_bar_links() {
    global $wp_admin_bar;
    $wp_admin_bar->remove_menu('wp-logo');          // Remove the WordPress logo
    $wp_admin_bar->remove_menu('about');            // Remove the about WordPress link
    $wp_admin_bar->remove_menu('wporg');            // Remove the WordPress.org link
    $wp_admin_bar->remove_menu('documentation');    // Remove the WordPress documentation link
    $wp_admin_bar->remove_menu('support-forums');   // Remove the support forums link
    $wp_admin_bar->remove_menu('feedback');         // Remove the feedback link
    $wp_admin_bar->remove_menu('updates');          // Remove the updates link
}
add_action( 'wp_before_admin_bar_render', 'remove_admin_bar_links' );


/* 
    Funtion to call images in a post
*/
function my_image($postid=0, $size='thumbnail') { //it can be thumbnail or full
    if ($postid<1){
        $postid = get_the_ID();
    }
    if(has_post_thumbnail($postid)){
        $imgpost = wp_get_attachment_image_src(get_post_thumbnail_id($postid), $size);
        return $imgpost[0];
    }
    elseif ($images = get_children(array(
        'post_parent' => $postid,
        'post_type' => 'attachment',
        'numberposts' => '1',
        'orderby' => 'menu_order',
        'order' => 'ASC',
        'post_mime_type' => 'image',)))
    foreach($images as $image) {
        $thumbnail=wp_get_attachment_image_src($image->ID, $size);
        return $thumbnail[0];
    } else {
        global $post, $posts;
        $first_img = '';
        ob_start();
        ob_end_clean();
        $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
        $first_img = $matches [1] [0];
        return $first_img;
    }
}


/* 
    Force medium size image to crop
*/
if(false === get_option('medium_crop')) {
    add_option('medium_crop', '1');
} else {
    update_option('medium_crop', '1');
}

/* 
    Cleaner Dashboard
*/
function disable_default_dashboard_widgets() {
	remove_meta_box('dashboard_recent_comments', 'dashboard', 'core');
	remove_meta_box('dashboard_incoming_links', 'dashboard', 'core');
	remove_meta_box('dashboard_plugins', 'dashboard', 'core');
	remove_meta_box('dashboard_quick_press', 'dashboard', 'core');
	remove_meta_box('dashboard_primary', 'dashboard', 'core');
	remove_meta_box('dashboard_secondary', 'dashboard', 'core');
	remove_meta_box('dashboard_recent_drafts', 'dashboard', 'core');
	//remove_meta_box('dashboard_right_now', 'dashboard', 'core');
}
add_action('admin_menu', 'disable_default_dashboard_widgets');



/**
 * Add a general nonce to requests
 */
function add_general_nonce(){
    $nonce = wp_create_nonce( 'noncefield' );
    echo "<meta name='csrf-token' content='$nonce'>";
}
// To add to front-end pages
add_action( 'wp_head', 'add_general_nonce' );


/**
 * Verify the submitted nonce
 */
function verify_general_nonce(){
    $nonce = isset($_SERVER['HTTP_X_CSRF_TOKEN']) ? $_SERVER['HTTP_X_CSRF_TOKEN']: '';
    if (!wp_verify_nonce( $nonce, 'noncefield')) {
        die();
    }
}

/**
 * Send email notification
 *
 * @param [string] $subject
 * @param [string] $content
 * @param [string] $email
 * @return boolean
 */
function sendNotification($subject,$content,$email){
	$thebody = '<!doctype html><html><head><meta name="viewport" content="width=device-width"> <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"> <title>{{subject}}</title> <style media="all" type="text/css"> @media all{.btn-primary table td:hover{background-color: #34495e !important;}.btn-primary a:hover{background-color: #34495e !important; border-color: #34495e !important;}}@media all{.btn-secondary a:hover{border-color: #34495e !important; color: #34495e !important;}}@media only screen and (max-width: 620px){table[class=body] h1{font-size: 28px !important; margin-bottom: 10px !important;}table[class=body] h2{font-size: 22px !important; margin-bottom: 10px !important;}table[class=body] h3{font-size: 16px !important; margin-bottom: 10px !important;}table[class=body] p, table[class=body] ul, table[class=body] ol, table[class=body] td, table[class=body] span, table[class=body] a{font-size: 16px !important;}table[class=body] .wrapper, table[class=body] .article{padding: 10px !important;}table[class=body] .content{padding: 0 !important;}table[class=body] .container{padding: 0 !important; width: 100% !important;}table[class=body] .header{margin-bottom: 10px !important;}table[class=body] .main{border-left-width: 0 !important; border-radius: 0 !important; border-right-width: 0 !important;}table[class=body] .btn table{width: 100% !important;}table[class=body] .btn a{width: 100% !important;}table[class=body] .img-responsive{height: auto !important; max-width: 100% !important; width: auto !important;}table[class=body] .alert td{border-radius: 0 !important; padding: 10px !important;}table[class=body] .span-2, table[class=body] .span-3{max-width: none !important; width: 100% !important;}table[class=body] .receipt{width: 100% !important;}}@media all{.ExternalClass{width: 100%;}.ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div{line-height: 100%;}.apple-link a{color: inherit !important; font-family: inherit !important; font-size: inherit !important; font-weight: inherit !important; line-height: inherit !important; text-decoration: none !important;}}</style> </head> <body class="" style="font-family: sans-serif; -webkit-font-smoothing: antialiased; font-size: 14px; line-height: 1.4; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; background-color: #f6f6f6; margin: 0; padding: 0;"> <table border="0" cellpadding="0" cellspacing="0" class="body" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; background-color: #f6f6f6;" width="100%" bgcolor="#f6f6f6"> <tr> <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;" valign="top">&nbsp;</td><td class="container" style="font-family: sans-serif; font-size: 14px; vertical-align: top; display: block; Margin: 0 auto !important; max-width: 580px; padding: 10px; width: 580px;" width="580" valign="top"> <div class="content" style="box-sizing: border-box; display: block; Margin: 0 auto; max-width: 580px; padding: 10px;"> <span class="preheader" style="color: transparent; display: none; height: 0; max-height: 0; max-width: 0; opacity: 0; overflow: hidden; mso-hide: all; visibility: hidden; width: 0;"></span> <table class="main" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; background: #fff; border-radius: 3px;" width="100%"> <tr> <td class="wrapper" style="font-family: sans-serif; font-size: 14px; vertical-align: top; box-sizing: border-box; padding: 20px;" valign="top"> <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;" width="100%"> <tr> <td style="font-family: sans-serif; font-size: 15px; vertical-align: top;" valign="top"> <span style="letter-spacing:4px;font-weight:700;color:#999999">' . $GLOBALS['SITENAME'] .'</span> </td></tr><tr> <td height="30"></td></tr><tr> <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;" valign="top">{{content}}<br></td></tr></table> </td></tr></table> <div class="footer" style="clear: both; padding-top: 10px; text-align: center; width: 100%;"> <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;" width="100%"> </table> </div></div></td><td style="font-family: sans-serif; font-size: 14px; vertical-align: top;" valign="top">&nbsp;</td></tr></table> </body></html>';

    $tpl = str_replace('{{content}}', $content, $thebody);
    $tpl = str_replace('{{subject}}', $subject, $tpl);
    $tpl = str_replace('{{site}}', $GLOBALS['SITENAME'], $tpl);

    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
    $headers .= 'From: '.$GLOBALS['SITENAME'].' <noreply@'.$GLOBALS['DOMAIN'].'>' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

    $sent = wp_mail($email, $subject, $tpl, $headers);
    if($sent){
    	return $sent;
    } else {
    	return false;
    }
}

/**
 * Create a log txt file in theme folder
 */
if (defined('WP_DEBUG_LOG') && WP_DEBUG_LOG) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    ini_set( 'error_log', get_template_directory_uri() . '/log.txt' );
}

/**
 * Detect page template
 *
 * @param array $pages Whatever template to detect, also parent pages
 * @return bool If current page template is viewed, return true
 */
function detectDashboard($pages = array()){
    //Detect the template
    $pagetemplate = get_page_template_slug();
}

/**
 * Detect files uploaded
 *
 * @param string $name The input name
 * @return bool
 */
function any_uploaded($name){
	if(is_array($_FILES[$name]['error'])){
		foreach ($_FILES[$name]['error'] as $ferror) {
			return ($ferror != UPLOAD_ERR_NO_FILE) ? true : false;
		}
	} else {
		return ($_FILES[$name]['error'] != UPLOAD_ERR_NO_FILE) ? true : false;
	}
}

/**
 * Rearrange array of $_FILE for better reading
 *
 * @param array $arr
 * @return array
 */
function rearrange_files($arr) {
    foreach($arr as $key => $all) {
        foreach($all as $i => $val) {
            $new_array[$i][$key] = $val;
        }
    }
    return $new_array;
}

/**
 * Create options items for a select using an array
 *
 * @param [array] $options Array of elements
 * @param string $selected The value that is selected
 * @return html
 */
function getOptionsCustom($options,$selected = ''){
    foreach ( $options as $a ) {	
		if(is_array($selected)){
			$m = array();
			foreach($selected as $x){
				($a == $x) ? $m[] = true : "";
			}
			if(in_array(true,$m))
				$z = 'selected';
			else 
				$z = '';	
		} else {
			$z = ($a == $selected) ? 'selected' : "";
		}

        echo "<option value='" . $a . "' ".$z.">" .$a ."</option>";
    }
}


/**
 * Create options based on certain category
 *
 * @param string $taxname Name of the taxonomy
 * @param string $selected The current item selected, based on ID
 * @param boolean $opt If true create upper label parent
 * @param string $value What to show in value of the option
 * @return string The Html
 */
function getOptionsCategory($taxname,$selected = '',$opt = false,$value = 'id'){
	$categories = get_terms( $taxname, array(
		'hide_empty' => false,
  	));

	foreach ($categories as $category) {
		if($opt){
			if (0 == $category->parent) {
				echo "<optgroup value=".$category->slug." label=".$category->name.">";
				$terms = get_terms( $taxname, array(
					'hide_empty' => false,
					'parent' => $category->term_id
				));

				foreach ($terms as $k) {
					$s = ($selected != '' && $selected == $k->name) ? " selected" : '';
					echo "<option value='".$k->name."' $s>".$k->name."</option>";
				}
				echo "</optgroup>";
		  	}
		} else {
			switch ($value){
				case 'slug':
					$val = $category->slug;
				break;
				case 'name':
					$val = $category->name;
				break;
				case 'id':
					$val = $category->term_id;
				break;
			}

			$s = ($selected != '' && $selected == $val) ? " selected" : '';
			echo "<option value='".$val."' $s>".$category->name."</option>";
		}
	}
}

function detectUniqueCuit($cuit){

	$cuits = new WP_Query("post_type=empresas&meta_key=empresa_cuit&meta_value=$cuit");
	$found = $cuits->posts;

	if(empty($found)){
		return true;
	} else {
		return false;
	}
}