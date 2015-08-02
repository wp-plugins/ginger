<?php
//Logger
$option_logger = get_option('gingerlogger');
if($option_logger && $option_logger['activated'] == 1):
    require_once('ginger.logger.php');
endif;

add_action("ginger_addon_activation_page", "ginger_logger_activation_page");

function ginger_logger_activation_page()
{
    $appname = "logger";
    $app_data = ginger_app_data($appname);
    $option_ginger_analitics = get_option('gingerlogger');
    ?>

    <div class="ginger-addon">
        <table class="form-table striped">
            <thead>
            <tr>
                <td colspan="2">
                    <img class="ginger-thumb" src="<?php echo $app_data["thumb"]; ?>" />
                    <h3><?php _e("Acceptance Logger", "ginger"); ?>
                        <?php
                        ginger_app_price($appname, $app_data);
                        ?></h3>
                    <small><?php _e("This add-on log user's acceptance and show reports on admin page. Very useful in case of disputes", "ginger"); ?></small>
                    <br style="clear: both" />
                    <p>
                        <a href="http://www.ginger-cookielaw.com/prodotto/<?php echo $appname; ?>/" target="_BLANK" class="button button-primary" <?php if($option_ginger_analitics && $option_ginger_analitics['activated'] == 1){ echo "disabled='disabled' "; } ?>><?php _e("Get Activation Code", "ginger"); ?></a>
                    </p>
                </td>
            </tr>
            </thead>
            <tbody>
            <tr>

                <td>
                    <fieldset>
                        <legend class="screen-reader-text"><span><?php _e("Acceptance Logger", "ginger"); ?></span></legend>
                        <p>
                            <label>
                                <?php _e("Active add-on", "ginger");?>:&nbsp;
                            </label>
                            <?php if ($option_ginger_analitics && $option_ginger_analitics['activated'] == 1): ?>
                            <img id="img_google_logger"
                                 src="<?php echo plugins_url('/ginger/img/ok.png'); ?>"
                                 style="max-width: 20px; max-height: 20px; vertical-align: middle">

                        <form method="get" action="<?php echo admin_url('admin.php?page=ginger-add-on'); ?>">
                            <input type="hidden" name="page" value="ginger-add-on">
                            <input id="activationcode" type="text" name="activationcode"
                                   value="<?php echo $option_ginger_analitics['licence_key']; ?>" placeholder=""
                                   size="30px">
                            <input id="activationmail" type="text" name="activationmail"
                                   value="<?php echo $option_ginger_analitics['email']; ?>" placeholder="" size="30px">
                            <input type="hidden" name="product_id" value="gingerlogger">
                            <input type="hidden" name="request" value="deactivation">
                            <input type="submit" class="button" value="<?php _e('Deactivate', 'ginger') ?>">
                        </form>
                        <?php else: ?>
                            <img id="img_google_logger"
                                 src="<?php echo plugins_url('/ginger/img/xx.png'); ?>"
                                 style="max-width: 20px; max-height: 20px; vertical-align: middle">
                            <form method="get" action="<?php echo admin_url('admin.php?page=ginger-add-on'); ?>">
                                <input type="hidden" name="page" value="ginger-add-on">
                                <input id="activationcode" type="text" name="activationcode" value=""
                                       placeholder="<?php _e('Insert here the add-on activation code.', 'ginger') ?>"
                                       size="30px">
                                <input id="activationmail" type="text" name="activationmail" value=""
                                       placeholder="<?php _e('Insert here your activation mail.', 'ginger') ?>" size="30px">
                                <input type="hidden" name="product_id" value="gingerlogger">
                                <input type="hidden" name="request" value="activation">
                                <input type="submit" class="button" value="<?php _e('Activate', 'ginger') ?>">
                            </form>
                        <?php endif; ?>
                        </p>
                    </fieldset>
                </td>
            </tr>

            </tbody>
        </table>
    </div>
<?php

}


function ginger_do_log($url = "", $status = "Y"){
    global $wpdb;
    if($url == "")
        $url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $table_name = $wpdb->prefix . 'logger_ginger';
    $ipuser = ginger_get_ip_address();
    $now =  current_time( 'mysql' );
    $wpdb->insert(
        $table_name,
        array(
            'time' => $now,
            'ipaddress' => $ipuser,
            'url' => $url,
            'status' => $status
        ),
        array(
            '%s',
            '%s',
            '%s',
            '%s'
        )
    );
}


function ginger_get_ip_address() {
    // check for shared internet/ISP IP
    if (!empty($_SERVER['HTTP_CLIENT_IP']) && ginger_validate_ip($_SERVER['HTTP_CLIENT_IP'])) {
        return $_SERVER['HTTP_CLIENT_IP'];
    }

    // check for IPs passing through proxies
    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        // check if multiple ips exist in var
        if (strpos($_SERVER['HTTP_X_FORWARDED_FOR'], ',') !== false) {
            $iplist = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            foreach ($iplist as $ip) {
                if (ginger_validate_ip($ip))
                    return $ip;
            }
        } else {
            if (ginger_validate_ip($_SERVER['HTTP_X_FORWARDED_FOR']))
                return $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
    }
    if (!empty($_SERVER['HTTP_X_FORWARDED']) && ginger_validate_ip($_SERVER['HTTP_X_FORWARDED']))
        return $_SERVER['HTTP_X_FORWARDED'];
    if (!empty($_SERVER['HTTP_X_CLUSTER_CLIENT_IP']) && ginger_validate_ip($_SERVER['HTTP_X_CLUSTER_CLIENT_IP']))
        return $_SERVER['HTTP_X_CLUSTER_CLIENT_IP'];
    if (!empty($_SERVER['HTTP_FORWARDED_FOR']) && ginger_validate_ip($_SERVER['HTTP_FORWARDED_FOR']))
        return $_SERVER['HTTP_FORWARDED_FOR'];
    if (!empty($_SERVER['HTTP_FORWARDED']) && ginger_validate_ip($_SERVER['HTTP_FORWARDED']))
        return $_SERVER['HTTP_FORWARDED'];

    // return unreliable ip since all else failed
    return $_SERVER['REMOTE_ADDR'];
}

/**
 * Ensures an ip address is both a valid IP and does not fall within
 * a private network range.
 */
function ginger_validate_ip($ip) {
    if (strtolower($ip) === 'unknown')
        return false;

    // generate ipv4 network address
    $ip = ip2long($ip);

    // if the ip is set and not equivalent to 255.255.255.255
    if ($ip !== false && $ip !== -1) {
        // make sure to get unsigned long representation of ip
        // due to discrepancies between 32 and 64 bit OSes and
        // signed numbers (ints default to signed in PHP)
        $ip = sprintf('%u', $ip);
        // do private network range checking
        if ($ip >= 0 && $ip <= 50331647) return false;
        if ($ip >= 167772160 && $ip <= 184549375) return false;
        if ($ip >= 2130706432 && $ip <= 2147483647) return false;
        if ($ip >= 2851995648 && $ip <= 2852061183) return false;
        if ($ip >= 2886729728 && $ip <= 2887778303) return false;
        if ($ip >= 3221225984 && $ip <= 3221226239) return false;
        if ($ip >= 3232235520 && $ip <= 3232301055) return false;
        if ($ip >= 4294967040) return false;
    }
    return true;
}



function ginger_logger_create_table($product_id){
    if($product_id == "gingerlogger"){
        global $wpdb;
        $table_name = $wpdb->prefix . 'logger_ginger';
        $charset_collate = $wpdb->get_charset_collate();
        $sql = "CREATE TABLE $table_name (
		id int(10) NOT NULL AUTO_INCREMENT,
		time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
		ipaddress varchar(45),
		url text NOT NULL,
		status varchar(1) DEFAULT 'Y' NOT NULL,
		UNIQUE KEY id (id)
    	) $charset_collate;";
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );
    }
}

add_action("ginger_activated_addon", "ginger_logger_create_table");

// init to check date and save log
add_action("init", "ginger_activity_log");
function ginger_activity_log(){
    if(!((isset($_GET["ginger_action"]) && $_GET["ginger_action"] == "time") || (isset($_GET["ginger_action"]) && $_GET["ginger_action"] == "log"))) {
        return;
    }
    if($_GET["ginger_action"] == "time"){

        header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
        header("Pragma: no-cache"); // HTTP 1.0.
        header("Expires: 0"); // Proxies.
        echo  time();
        exit;
    }
    if($_GET["ginger_action"] == "log"){
        if(!isset($_GET["url"]) || $_GET["url"] == "") exit;
        if(!isset($_GET["time"]) || $_GET["time"] == "") exit;
        if(!isset($_GET["status"]) || $_GET["status"] == "") exit;

        if(($_GET["time"] + 10) < time()) exit;
        header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
        header("Pragma: no-cache"); // HTTP 1.0.
        header("Expires: 0"); // Proxies.
        // echo time();
        if(function_exists("ginger_do_log")){
            ginger_do_log($_GET["url"], $_GET["status"]);
        }
        exit;
    }

}