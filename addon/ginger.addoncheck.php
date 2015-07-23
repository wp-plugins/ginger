<?php

if ( ! wp_next_scheduled( 'ginger_check_hook' ) ) {
    wp_schedule_event( time(), 'daily', 'ginger_check_hook' );
}

add_action( 'ginger_check_hook', 'ginger_check_function' );

function ginger_check_function() {
    $ginger_addon = array(
        'gingeranalytics',
        'gingeradsense',
        'gingercustomurl',
        'gingerwpml'
    );
    foreach($ginger_addon as $addon):
        $addon_to_check = get_option($addon);
        if($addon_to_check && $addon_to_check['activated'] == 1):
            $args = array(
                'wc-api'	  => 'software-api',
                'request'     => 'check',
                'email'		  => $addon_to_check['email'],
                'licence_key' => $addon_to_check['licence_key'],
                'product_id'  => $addon_to_check['product_id'],
                'instance'    => $addon_to_check['instance']
            );

            $data = execute_request( $args );
            if(!$data->success && !is_wp_error($data)):
                $addon_to_check['activated'] = 0; update_option('gingeranalytics', $addon_to_check);
            endif;
        endif;
    endforeach;
}