<?php
/*
 * File per la gestione del backend e delle funzionalità
 *
 *
 *
 *
 * */

//Inizzializzo il plugin e le relative pagine del plugin
add_action( 'admin_menu', 'register_ginger_menu_page' );
function register_ginger_menu_page(){
    add_menu_page( 'ginger', 'Ginger Cookie', 'manage_options', 'ginger-setup', 'ginger_menu_page', plugins_url( 'ginger/img/ginger-color.png' ));
    do_action("ginger_add_menu");
}

function ginger_menu_page(){
    require_once(plugin_dir_path( __FILE__ )."/ginger.admin.php");
}
function ginger_about_menu_page(){
    require_once(plugin_dir_path( __FILE__ )."/ginger.about.php");
}
//Aggingo style e script per ginger backend
add_action( 'admin_enqueue_scripts', 'ginger_add_admin_js' );
function ginger_add_admin_js( $hook ) {
    if( is_admin() ) {
        // Add the color picker css file
        wp_enqueue_style( 'wp-color-picker' );
        // Include our custom jQuery file with WordPress Color Picker dependency
        wp_enqueue_script( 'ginger-script-handle', plugins_url( 'js/ginger.js', __FILE__ ), array(), false, true );
        wp_enqueue_script( 'ginger-script-color', plugins_url( 'js/ginger.color.js', __FILE__ ), array("wp-color-picker"), false, true );
    }
}

//Salvataggio e creazione pagina cookie policy
function save_privacy_page($title,$content){
    $my_post = array(
      'post_title'    => $title,
      'post_content'  => $content,
      'post_status'   => 'publish',
      'post_author'   => '',
      'post_category' => '',
      'post_type'     => 'page'
    );


    $id = wp_insert_post( $my_post );
	return($id);
}


//Attivazione plugin abilito le impostazioni di base se non inserite.
function ginger_plugin_activate() {
    $options = get_option('ginger_general');
    if (!is_array($options)){
        $options = array('enable_ginger' => '0', 'ginger_cache' => 'yes', 'ginger_opt' => 'in', 'ginger_scroll' => '1', 'ginger_click_out' => '0' , 'ginger_force_reload' => '0' , 'ginger_keep_banner' => '0' );
        update_option('ginger_general', $options);

        $options =   array (
            'ginger_banner_type' => 'bar',
            'ginger_banner_position' => 'top',
            'ginger_banner_text' => addslashes(__("This website uses cookies. By continuing to use the site you are agreeing to its use of cookies.", "ginger")),
            'ginger_Iframe_text' => addslashes(__("This content has been disabled because you have not accepted cookies.", "ginger")),
            'accept_cookie_button_text' => 'Accept',
            'theme_ginger' => 'light',
            'background_color' => '',
            'text_color' => '',
            'button_color' => '',
            'link_color' => '',
            'disable_cookie_button_status' => '0',
            'read_more_button_status' => '0',
        );
        update_option('ginger_banner', $options);
    }
}

function ginger_app_price($appname, $appdata = false){
    if(!$appdata)
        $appdata = ginger_app_data($appname);
    $price = $appdata["price"];
    if($price == "0"){
            echo '<small style="color: green">(';
            _e("Free", "ginger");
            echo ')</small>';
    }else{
            echo '<small style="color: green">(';
            _e("price: ", "ginger");
            echo $price;
            echo '&euro;)</small>';
    }

}


function ginger_app_data($appname){

    $url = "http://www.ginger-cookielaw.com/api/?pname=".$appname;
    $response = wp_remote_get($url);
    if($response) {
        $array = json_decode($response["body"], true);
        return $array[$appname];
    }
}
