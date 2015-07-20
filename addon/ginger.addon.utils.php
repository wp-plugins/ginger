<?php
/*
 * Option Analitics: gingeranalytics_option -> Contine l'array con le impostazioni del plugin - gingeranalytics -> Contine le optin con il serial number e l'attivazione;
 *
 *
 */



$addons = ginger_include_addons();

function ginger_include_addons(){
    // check native gallery types
    $addons = array();
    $addondir = plugin_dir_path( __FILE__ );

    $files = scandir($addondir);


    foreach($files as $file){
        if(is_dir($addondir.'/'.$file) && $file != "." && $file != ".."){
            if(file_exists($addondir.'/'.$file.'/index.php')){
                require_once($addondir.'/'.$file.'/index.php');
                $addons[]=$file;
            }
        }
    }

    return $addons;
}


//// Ginger check api
function execute_request( $args ) {
    $target_url = create_url( $args );
    $data = wp_remote_get( $target_url );
    $data = json_decode(strip_tags(wp_remote_retrieve_body( $data )));
    return $data;
}

// Create an url based on
function create_url( $args ) {
    global $base_url;
    $base_url      = 'http://www.ginger-cookielaw.com/';
    $base_url = add_query_arg( 'wc-api', 'software-api', $base_url );
    return $base_url . '&' . http_build_query( $args );
    //exit;

}
add_action('ginger_add_menu', 'add_ginger_add_on');
function add_ginger_add_on(){
    add_submenu_page( 'ginger-setup', "Add-on", __("Add-on", "ginger"), 'manage_options', 'ginger-add-on', 'ginger_add_on_menu_page');
}

function ginger_add_on_menu_page(){

$wp_root = dirname( dirname( dirname( dirname( dirname( __FILE__ ) ) ) ) );
if ( file_exists( $wp_root . '/wp-load.php' ) ) {
   // require_once( $wp_root . "/wp-load.php" );
} else {
    exit;
}

if ( ! current_user_can( 'manage_options' ) ) die();

//$base_url      = 'http://www.ginger-cookielaw.com/';
//$email         = 'mb@matteobarale.com';
//$product_id    = 'gingeranalytics';
//$licence_key   = 'gingerba76a04b-18a0-47e6-89e2-c59848047c56';
//$instance  	   = 'ginger.dev';
//print_r($_GET);




$request = ( isset( $_GET['request'] ) ) ? $_GET['request'] : '';
$activationemail = ( isset( $_GET['activationmail'] ) ) ? $_GET['activationmail'] : '';
$activationcode = ( isset( $_GET['activationcode'] ) ) ? $_GET['activationcode'] : '';
$product_id = ( isset( $_GET['product_id'] ) ) ? $_GET['product_id'] : '';


$links = array(
    'invalid' => 'Invalid request',
    'generate_key' => 'Generate key',
    'check' => 'Check request',
    'activation' => 'Activation request',
    'activation_reset' => 'Application reset',
    'deactivation' => 'Deactivation'
);

//foreach ( $links as $key => $value ) {
//    echo '<a href="' . add_query_arg( 'request', $key ) . '">' . $value . '</a> | ';
//}
//echo '<br/><br/>';

//
// Valid activation request
if ( $request == 'activation' && $activationcode != '' && $activationemail != '' && $product_id != '' ) {
    $args = array(
        'request'     => 'activation',
        'email'       => $activationemail,
        'licence_key' => $activationcode,
        'product_id'  => $product_id,
        'instance'      => get_bloginfo('url'),
    );

    $data = execute_request( $args );
    //var_dump($data);
    if($data->activated == 1):
        $args = array(
            'activated'   => 1,
            'email'       => $activationemail,
            'licence_key' => $activationcode,
            'product_id'  => $product_id,
            'instance'    => get_bloginfo('url'),
        );
        $array_activate = update_option($product_id, $args);
    endif;
}

// Valid check request
if ( $request == 'check' ) {
    $args = array(
        'wc-api'	  => 'software-api',
        'request'     => 'check',
        'email'		  => $activationemail,
        'licence_key' => $activationcode,
        'product_id'  => $product_id
    );

    $data = execute_request( $args );
    //('<pre>');
    //print_r(json_decode($data['body']));
    //echo('</pre>');

}

// Valid activation reset request
if ( $request == 'activation_reset' ) {
    $args = array(
        'request'     => 'activation_reset',
        'email'       => $activationemail,
        'licence_key' => $activationcode,
        'product_id'  => $product_id,
        'secret_key'  => $secret_key,
    );

    echo '<b>Valid activation reset request:</b><br />';
    $data = execute_request( $args );
    //echo('<pre>');
    //print_r(json_decode($data['body']));
    //echo('</pre>');
}



//
// Valid deactivation reset request
if ( $request == 'deactivation' && $activationcode != '' && $activationemail != '' && $product_id != '' ) {
    $args = array(
        'request'       => 'deactivation',
        'email'       => $activationemail,
        'licence_key' => $activationcode,
        'product_id'  => $product_id,
        'instance'    => get_bloginfo('url'),
    );

    echo '<b>Valid deactivation request:</b><br />';
    execute_request( $args );
    delete_option( $product_id );
}

?>

<div class="wrap">
    <h2><?php _e("Ginger Available Add-ons", "ginger"); ?></h2>
    <hr>
    <?php do_action("ginger_addon_activation_page"); ?>
</div>
<?php
}

require_once('ginger.addoncheck.php');
