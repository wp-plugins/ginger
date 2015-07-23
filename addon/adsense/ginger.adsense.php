<?php
/**
 * Created by PhpStorm.
 * User: matteobarale
 * Date: 26/06/15
 * Time: 12:02
 */

add_action('ginger_add_menu', 'add_ginger_adsense');
function add_ginger_adsense(){
    add_submenu_page( 'ginger-setup', "Ginger Adsense", __("Google Adsense", "ginger"), 'manage_options', 'ginger-adsense', 'ginger_adsense');
}

function ginger_adsense(){

    $wp_root = dirname(dirname( dirname( dirname( dirname( dirname( __FILE__ ) ) ) ) ));
    if ( file_exists( $wp_root . '/wp-load.php' ) ) {
        require_once( $wp_root . "/wp-load.php" );
    } else {
        exit;
    }

    if ( ! current_user_can( 'manage_options' ) ) die();


    $option_analitycs = get_option('gingeradsense');
    $activationemail = $option_analitycs['email'];
    $activationcode = $option_analitycs['licence_key'];
    $product_id = $option_analitycs['product_id'];
    $instance = $option_analitycs['instance'];


    $args = array(
    'wc-api'	  => 'software-api',
    'request'     => 'check',
    'email'		  => $activationemail,
    'licence_key' => $activationcode,
    'product_id'  => $product_id,
    'instance'    => $instance
    );

    $data = execute_request( $args );
    if($data->success == 1): //Inizio Verifica ?>
    <div class="wrap">
        <h2>Ginger - Adsense Add On</h2>
       <p><?php _e("No configuration required!", "ginger"); ?></p>

    </div>
    <?php else: //La licenza sembra non essere valida; ?>
        <?php $option = get_option('gingeradsense');
                $option['activated'] = 0; update_option('gingeradsense', $option); ?>
    <div class="wrap">
        <h2>Ginger - Adsense Add On</h2>
        <p><?php _e("Licence key look inactive. Addon disabled", "ginger"); ?></p>
        <p><?php _e("If you think is an error contact us here:", "ginger"); ?> <a href="http://www.ginger-cookielaw.com/">www.ginger-cookielaw.com/</a></p>
    </div>
    <?php endif; ?>


<?php }
add_filter('ginger_script_async_tags', 'ginger_addsesneremover',10,3);
function ginger_addsesneremover($array){
    return array_merge($array, array('adsbygoogle'));
}