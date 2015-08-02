<?php

add_action('ginger_add_menu', 'add_ginger_logger');
function add_ginger_logger(){
    add_submenu_page( 'ginger-setup', "Ginger Logger", __("Activity Logger", "ginger"), 'manage_options', 'ginger-logger', 'ginger_logger');
}

function ginger_logger(){
    global $wpdb;
    $wp_root = dirname(dirname( dirname( dirname( dirname( dirname( __FILE__ ) ) ) ) ));
    if ( file_exists( $wp_root . '/wp-load.php' ) ) {
        require_once( $wp_root . "/wp-load.php" );
    } else {
        exit;
    }

    if ( ! current_user_can( 'manage_options' ) ) die();

    if(isset($_POST["submit"]) && !wp_verify_nonce($_POST['ginger_options'], 'save_ginger_logger')){
        return;
    }

    if(isset($_POST["action"]) && $_POST["action"] == "deleteall"){
        $wpdb->query( "DELETE FROM {$wpdb->prefix}logger_ginger WHERE 1" );
    }

    $option_logger = get_option('gingerlogger');
    $activationemail = $option_logger['email'];
    $activationcode = $option_logger['licence_key'];
    $product_id = $option_logger['product_id'];
    $instance = $option_logger['instance'];


    $args = array(
        'wc-api'	  => 'software-api',
        'request'     => 'check',
        'email'		  => $activationemail,
        'licence_key' => $activationcode,
        'product_id'  => $product_id,
        'instance'    => $instance
    );

    $data = execute_request( $args );
    if($data->success == 1):  ?>
        <div class="wrap">
            <h2>Ginger - Logger Add On</h2>
            <?php



            $pagenum = isset( $_GET['pagenum'] ) ? absint( $_GET['pagenum'] ) : 1;
            $limit = 20;
            $offset = ( $pagenum - 1 ) * $limit;
            $entries = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}logger_ginger WHERE 1 ORDER BY id DESC LIMIT $offset, $limit" );

            echo '<div class="wrap">';

            ?>
            <table class="widefat">
                <thead>
                <tr>
                    <th scope="col" class="manage-column column-name" style="">Time</th>
                    <th scope="col" class="manage-column column-name" style="">IP</th>
                    <th scope="col" class="manage-column column-name" style="">url</th>
                    <th scope="col" class="manage-column column-name" style="">Cookie</th>
                </tr>
                </thead>

                <tfoot>
                <tr>
                    <th scope="col" class="manage-column column-name" style="">Time</th>
                    <th scope="col" class="manage-column column-name" style="">IP</th>
                    <th scope="col" class="manage-column column-name" style="">url</th>
                    <th scope="col" class="manage-column column-name" style="">Cookie</th>
                </tr>
                </tfoot>

                <tbody>
                <?php if( $entries ) { ?>

                    <?php
                    $count = 1;
                    $class = '';
                    foreach( $entries as $entry ) {
                        $class = ( $count % 2 == 0 ) ? ' class="alternate"' : '';
                        ?>

                        <tr<?php echo $class; ?>>
                            <td><?php echo $entry->time; ?></td>
                            <td><?php echo $entry->ipaddress; ?></td>
                            <td><?php echo $entry->url; ?></td>
                            <td><?php echo $entry->status; ?></td>
                        </tr>

                        <?php
                        $count++;
                    }
                    ?>

                <?php } else { ?>
                    <tr>
                        <td colspan="2">No Logs yet</td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>

            <?php
            $total = $wpdb->get_var( "SELECT COUNT('id') FROM {$wpdb->prefix}logger_ginger" );
            $num_of_pages = ceil( $total / $limit );
            $page_links = paginate_links( array(
                'base' => add_query_arg( 'pagenum', '%#%' ),
                'format' => '',
                'prev_text' => __( '&laquo;', 'aag' ),
                'next_text' => __( '&raquo;', 'aag' ),
                'total' => $num_of_pages,
                'current' => $pagenum
            ) );

            if ( $page_links ) {
                echo '<div class="tablenav"><div class="tablenav-pages" style="margin: 1em 0">' . $page_links . '</div></div>';
            }

            echo '</div>';
            ?>
            <form method="post" action="admin.php?page=<?php echo $_GET["page"]; ?>"  >
              <?php wp_nonce_field('save_ginger_logger', 'ginger_options'); ?>
              <p><input type="submit" name="submit" value="<?php _e("Delete all logs", "ginger"); ?>" class="button button-primary delete-cookies"></p>
              <input type="hidden" name="action" value="deleteall">
            </form>
<script type="text/javascript">
        jQuery(document).ready(function(){
        jQuery(".delete-cookies").click(function() {
        if (!confirm("<?php _e("Are you sure? This process cannot be undone.", "ginger"); ?>")){
            return false;
        }
        });
        });
</script>
        </div>
    <?php else: //La licenza sembra non essere valida; ?>
        <?php $option = get_option('gingerlogger');
        $option['activated'] = 0; update_option('gingerlogger', $option); ?>
        <div class="wrap">
            <h2>Ginger - Logger Add On</h2>
            <p><?php _e("Licence key look inactive. Addon disabled", "ginger"); ?></p>
            <p><?php _e("If you think is an error contact us here:", "ginger"); ?> <a href="http://www.ginger-cookielaw.com/">www.ginger-cookielaw.com/</a></p>
        </div>
    <?php endif; ?>


<?php }

add_action("wp_head", "ginger_add_log_variable");
function ginger_add_log_variable(){
    ?>
    <script type="text/javascript">
        var ginger_logger = "Y";
        var ginger_logger_url = "<?php bloginfo("url"); ?>";
        var current_url = "<?php echo (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>";

        function gingerAjaxLogTime(status) {
            var xmlHttp = new XMLHttpRequest();
            var parameters = "ginger_action=time";
            var url= ginger_logger_url + "?" + parameters;
            xmlHttp.open("GET", url, true);

            //Black magic paragraph
            xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

            xmlHttp.onreadystatechange = function() {
                if(xmlHttp.readyState == 4 && xmlHttp.status == 200) {
                    var time = xmlHttp.responseText;
                    gingerAjaxLogger(time, status);
                }
            }

            xmlHttp.send(parameters);
        }

        function gingerAjaxLogger(ginger_logtime, status) {
            console.log(ginger_logtime);
            var xmlHttp = new XMLHttpRequest();
            var parameters = "ginger_action=log&time=" + ginger_logtime + "&url=" + current_url + "&status=" + status;
            var url= ginger_logger_url + "?" + parameters;
            console.log(url);
            xmlHttp.open("GET", url, true);

            //Black magic paragraph
            xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

            xmlHttp.send(parameters);
        }

    </script>
    <?php
}
