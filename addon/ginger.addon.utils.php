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
    if ( is_wp_error( $data ) ) {
        return $data;
    }else{
        $data = json_decode(strip_tags(wp_remote_retrieve_body( $data )));
        return $data;
    }

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


$request = ( isset( $_GET['request'] ) ) ? $_GET['request'] : '';
$activationemail = ( isset( $_GET['activationmail'] ) ) ? $_GET['activationmail'] : '';
$activationcode = ( isset( $_GET['activationcode'] ) ) ? $_GET['activationcode'] : '';
$product_id = ( isset( $_GET['product_id'] ) ) ? $_GET['product_id'] : '';


// Valid activation request
    $notice = false;
if ( $request == 'activation' && $activationcode != '' && $activationemail != '' && $product_id != '' ) {
    $args = array(
        'request'     => 'activation',
        'email'       => $activationemail,
        'licence_key' => $activationcode,
        'product_id'  => $product_id,
        'instance'      => get_bloginfo('url'),
    );

    $data = execute_request( $args );
    if($data->activated == 1){
        $args = array(
            'activated'   => 1,
            'email'       => $activationemail,
            'licence_key' => $activationcode,
            'product_id'  => $product_id,
            'instance'    => get_bloginfo('url'),
        );
        $array_activate = update_option($product_id, $args);
        $notice = $data->message;
    }else{
    $notice = $data->error;
    }
}else if($request == 'activation' && ($activationcode == '' || $activationemail == '' || $product_id == '' )){

    $notice = __("Fill all required fields!", "ginger");
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

$notice = __("Valid activation reset request", "ginger");
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
    $notice = __("Valid deactivation request", "ginger");
    execute_request( $args );
    delete_option( $product_id );
}

    if($notice){
        ?>
        <script type="text/javascript">
            location.href='admin.php?page=<?php echo $_GET["page"]; ?>&notice=<?php echo urlencode($notice); ?>';
        </script>
        <?php
    }

    if(isset($_GET["notice"]) && $_GET["notice"])$notice=$_GET["notice"];
?>
<style>
.ginger-addon{
    width: 44%;
    min-width: 420px;
    float:left;
    background-color:#FCDCAB;
    margin: 0px 10px 10px 0px;
    min-height:300px
}
.ginger-thumb{
    width: 120px;
    float:left;
    margin-right: 20px;
    margin-bottom: 10px;
}
.ginger-addon tbody tr{
    background-color:#FBD69D !important;
}

.ginger-addon thead tr{
    background-color:#FCDCAB !important;
}
.ginger-addon h3{
    margin-top:0px
}
</style>
<div class="wrap">
    <?php
    if($notice){
        echo '<div class="updated"><p>'.$notice.'</p></div>';
    }
        ?>
    <h2><?php _e("Ginger Available Add-ons", "ginger"); ?></h2>
    <hr>
    <?php do_action("ginger_addon_activation_page"); ?>
</div>
<?php
}

require_once('ginger.addoncheck.php');