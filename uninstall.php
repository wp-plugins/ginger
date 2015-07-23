<?php
/**
 * Uninstall functions
 */

if ( ! current_user_can( 'activate_plugins' ) )
	return;


delete_option('ginger_general');
delete_option('ginger_banner');
delete_option('ginger_policy');

delete_option('gingerjscustom');
delete_option('ginger_jscustom_options');

delete_option('gingeradsense');

delete_option('gingerwpml');
delete_option('ginger_wpml_options');

delete_option('gingeranalytics');
delete_option('gingeranalytics_option');