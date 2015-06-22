<?php
/**
 * Created by PhpStorm.
 * User: matteobarale
 * Date: 11/06/15
 * Time: 15:48
 */


// Register style sheet.
add_action( 'wp_enqueue_scripts', 'ginger_style_script' );

/**
 * Register style sheet.
 */
function ginger_style_script() {
    wp_register_style( 'ginger-style', plugin_dir_url( __FILE__ ) . 'css/cookies-enabler.css' );
    wp_enqueue_style( 'ginger-style' );
}

function ginger_scirpt(){ ?>
    <?php
    //Recupero le informazioni necessarie per stampare il banner
    $option_ginger_general = get_option('ginger_general');
    $option_ginger_bar = get_option('ginger_banner');
    if($option_ginger_general['enable_ginger'] != 1) return;
    //Verifoco la tipologia di accettazione dei cookie
    if($option_ginger_general['ginger_scroll'] ==  1):
        $type_scroll = 'true';
    else:
        $type_scroll = 'false';
    endif;
    //Verifico se è abilitato il click sulla pagina
    if($option_ginger_general['ginger_click_out'] == 1):
        $click_outside = 'true';
    else:
        $click_outside = 'false';
    endif;
    //Verifico se è abilitato il forceReload
    if($option_ginger_general['ginger_force_reload'] == 1):
        $ginger_force_reload = 'true';
    else:
        $ginger_force_reload = 'false';
    endif;
    //Recupero le impostazioni per il banner
    //Testo Banner
    if($option_ginger_bar['ginger_banner_text']):
        $ginger_text = $option_ginger_bar['ginger_banner_text'];
        //Recupero privacy policy se presente
        if(strpos($ginger_text, '{{privacy_page}}') !== false):
            $privacy_policy = get_option('ginger_policy', true);
            $privacy_policy = get_post($privacy_policy);
            $privacy_policy = ' <a href="' . get_permalink($privacy_policy->ID) . '">' . $privacy_policy->post_title . '</a>';
            $ginger_text = str_replace('{{privacy_page}}', $privacy_policy, $ginger_text);
        endif;

    else:
        $ginger_text = 'This website uses cookies.';
    endif;
    //Definisco se è bar modal top o bottom
    if($option_ginger_bar['ginger_banner_position'] == 'top'):
        $banner_class = 'top';
    else:
        $banner_class = 'bottom';
    endif;
    if($option_ginger_bar['ginger_banner_type'] == 'dialog'):
        $banner_class .= ' dialog';
    endif;
    if($option_ginger_bar['ginger_banner_type'] == 'dialog'):
        $banner_class .= ' dialog';
    endif;
    if($option_ginger_bar['theme_ginger'] == 'dark'):
        $banner_class .= ' dark';
    endif;
    //Recupero Testo Iframe
    if($option_ginger_bar['ginger_Iframe_text']):
        $ginger_iframe_text = $option_ginger_bar['ginger_Iframe_text'];
    else:
        $ginger_iframe_text = 'This website uses cookies.';
    endif;
    //Recupero Label
    if($option_ginger_bar['accept_cookie_button_text']):
        $label_accept_cookie =  $option_ginger_bar['accept_cookie_button_text'];
    else:
        $label_accept_cookie = __('Enable Cookies', 'ginger');
    endif;
    //Recupero Label
    if($option_ginger_bar['disable_cookie_button_text']):
        $label_disable_cookie =  $option_ginger_bar['disable_cookie_button_text'];
    else:
        $label_disable_cookie = __('Disable Cookies', 'ginger');
    endif;
    //Recupero style custom
    if($option_ginger_bar['background_color'] || $option_ginger_bar['text_color'] ||$option_ginger_bar['link_color'] ): ?>
    <style>
        .ginger-banner{
            <?php if($option_ginger_bar['background_color']): ?> background-color: <?php echo $option_ginger_bar['background_color']; ?>;<?php endif; ?>
            <?php if($option_ginger_bar['text_color']): ?> color: <?php echo $option_ginger_bar['text_color']; ?>;<?php endif; ?>
        }
        <?php if($option_ginger_bar['link_color']): ?>
        .ginger-banner a{
            <?php if($option_ginger_bar['link_color']): ?> color: <?php echo $option_ginger_bar['link_color']; ?>;<?php endif; ?>
        }
        <?php endif;?>
    </style>
    <?php endif;?>
    <!-- Ginger Script -->
    <script src="<?php echo plugin_dir_url( __FILE__ ); ?>js/cookies-enabler.min.js"></script>
    <!-- Init the script -->
    <script>
        COOKIES_ENABLER.init({
            scriptClass: 'ginger-script',
            iframeClass: 'ginger-iframe',
            acceptClass: 'ginger-accept',
            disableClass: 'ginger-disable',
            dismissClass: 'ginger-dismiss',
            bannerClass: 'ginger-banner <?php echo $banner_class; ?>',
            bannerHTML:
                document.getElementById('ginger-banner-html') !== null ?
                    document.getElementById('ginger-banner-html').innerHTML :
                '<p>'
                + '<?php echo $ginger_text; ?>'
                + '<\/p>'
                + '<div class="ginger-button-wrapper">'
                + '<div class="ginger-button">'
                + '<a href="#" class="ginger-accept">'
                + '<?php echo $label_accept_cookie; ?>'
                + '<\/a>'
                <?php if($option_ginger_bar['disable_cookie_button_status'] != 0 && $option_ginger_general['ginger_opt'] != 'out'): ?>
                + '<a href="#" class="ginger-disable">'
                + '<?php echo $label_disable_cookie; ?>'
                + '<\/a>'
                <?php endif; ?>
                + '<\/div>'
                + '<\/div>',
            <?php if($option_ginger_bar['disable_cookie_button_status'] != 0 && $option_ginger_general['ginger_opt'] != 'out' && $option_ginger_general['ginger_keep_banner'] == 1): ?>
            forceEnable: true,
            forceBannerClass: 'ginger-banner bottom dialog force <?php echo $option_ginger_bar['theme_ginger']; ?>',
            forceEnableText:
                '<p>'
                + '<?php echo $ginger_text; ?>'
                + '<\/p>'
                + '<div class="ginger-button-wrapper">'
                + '<div class="ginger-button">'
                + '<a href="#" class="ginger-accept">'
                + '<?php echo $label_accept_cookie; ?>'
                + '<\/a>'
                + '<\/div>'
                + '<\/div>',
            <?php endif; ?>
            eventScroll: <?php echo $type_scroll; ?>,
            scrollOffset: 20,
            clickOutside: <?php echo $click_outside; ?>,
            cookieName: 'ginger-cookie',
            cookieDuration: '365',
            forceReload: <?php echo $ginger_force_reload; ?>,
            iframesPlaceholder: true,
            iframesPlaceholderClass: 'ginger-iframe-placeholder',
            iframesPlaceholderHTML:
                document.getElementById('ginger-iframePlaceholder-html') !== null ?
                    document.getElementById('ginger-iframePlaceholder-html').innerHTML :
                '<p><?php echo $ginger_iframe_text;  ?>'
                +'<a href="#" class="ginger-accept"><?php echo $label_accept_cookie; ?></a>'
                +'<\/p>'
        });
    </script>
    <!-- End Ginger Script -->

<?php }

add_action('wp_footer', 'ginger_scirpt');

//Ginger Start
function ginger_run(){
    $option_ginger_general = get_option('ginger_general');
    if($option_ginger_general['enable_ginger'] != 1) return;
    if($_COOKIE['ginger-cookie'] && $_COOKIE['ginger-cookie'] == 'Y'):
        if($option_ginger_general['ginger_cache'] == 'no') return;
    endif;
    if($option_ginger_general['ginger_opt'] == 'in'):
        ob_start();
        add_action('shutdown', '__shutdown', 0);
        add_filter('final_output', 'ginger_parse_dom', $output);
    endif;
}
add_action('init', 'ginger_run');



function __shutdown(){
    $final = '';

    // We'll need to get the number of ob levels we're in, so that we can iterate over each, collecting
    // that buffer's output into the final output.
    $levels = count(ob_get_level());

    for ($i = 0; $i < $levels; $i++){
        $final .= ob_get_clean();
    }

    // Apply any filters to the final output
    echo apply_filters('final_output', $final);
}




function ginger_parse_dom($output){

    $ginger_script_tags = array(
        'platform.twitter.com/widgets.js',
        'apis.google.com/js/plusone.js',
        'apis.google.com/js/platform.js',
        'connect.facebook.net',
        'platform.linkedin.com',
        'assets.pinterest.com',
        'www.youtube.com/iframe_api',
        'www.google-analytics.com/analytics.js',
        'google-analytics.com/ga.js',
        'maps.googleapis.com'
    );
    do_action('ginger_add_scripts');

    $ginger_iframe_tags = array(
        'youtube.com',
        'platform.twitter.com',
        'www.facebook.com/plugins/like.php',
        'apis.google.com',
        'www.google.com/maps/embed/'
    );
    do_action('ginger_add_iframe');

    libxml_use_internal_errors(true);
    $doc = new DOMDocument();
    $doc->encoding = 'utf-8';
    $doc->loadHTML(mb_convert_encoding($output, 'HTML-ENTITIES', 'UTF-8'));
    // get all the script tags
    $script_tags = $doc->getElementsByTagName('script');

    foreach($script_tags as $script):
       $src_script =  $script->getAttribute('src');
        if($src_script):
            if(strpos_arr($src_script, $ginger_script_tags) !== false ):
                $script->setAttribute("class", "ginger-script");
                $script->setAttribute("type", "text/plain");
            endif;
        endif;
        if($script->nodeValue):
            $key = strpos_arr($script->nodeValue, $ginger_script_tags);
            if($key !== false ):
                if($ginger_script_tags[$key] == 'www.google-analytics.com/analytics.js' || $ginger_script_tags[$key] == 'google-analytics.com/ga.js')
                if(strpos($script->nodeValue, 'anonymizeIp') !== false ):
                    continue;
                endif;
                $script->setAttribute("class", "ginger-script");
                $script->setAttribute("type", "text/plain");
            endif;
        endif;
    endforeach;
    // get all the iframe tags
    $iframe_tags = $doc->getElementsByTagName('iframe');
    foreach($iframe_tags as $iframe):
        $src_iframe =  $iframe->getAttribute('src');
        if($src_iframe):
            if(strpos_arr($src_iframe, $ginger_iframe_tags) !== false ):
                $iframe->removeAttribute('src');
                $iframe->setAttribute("data-ce-src", $src_iframe);
                $iframe->setAttribute("class", "ginger-iframe");
            endif;
        endif;
    endforeach;
    // get the HTML string back
    $output = $doc->saveHTML($doc->documentElement);
    libxml_use_internal_errors(false);
 return $output;
}

function strpos_arr($haystack, $needle) {
    if(!is_array($needle)) $needle = array($needle);
    foreach($needle as $key => $what) {
        if(($pos = strpos($haystack, $what))!==false) return $key;
    }
    return false;
}