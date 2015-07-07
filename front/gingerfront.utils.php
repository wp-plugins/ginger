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
    $option_ginger_bar = get_option('ginger_banner');
    if(isset($_COOKIE['ginger-cookie']) && $_COOKIE['ginger-cookie'] == 'N' || $option_ginger_bar['ginger_banner_type'] == 'dialog'):
        wp_register_style( 'ginger-style-dialog', plugin_dir_url( __FILE__ ) . 'css/cookies-enabler-dialog.css' );
        wp_enqueue_style( 'ginger-style-dialog' );
    else:
        wp_register_style( 'ginger-style', plugin_dir_url( __FILE__ ) . 'css/cookies-enabler.css' );
        wp_enqueue_style( 'ginger-style' );
    endif;
}
add_action('wp_head', 'gigner_custom_style' );
function gigner_custom_style(){
    $option_ginger_general = get_option('ginger_general');
    $option_ginger_bar = get_option('ginger_banner');
    if($option_ginger_general['enable_ginger'] != 1) return;
    //Recupero style custom
    if($option_ginger_bar['background_color'] || $option_ginger_bar['text_color'] || $option_ginger_bar['link_color'] || $option_ginger_bar['ginger_css'] || $option_ginger_bar['button_color'] || $option_ginger_bar['button_text_color']): ?>
        <style>
            .ginger_container.<?php echo $option_ginger_bar['theme_ginger']; ?>{
            <?php if($option_ginger_bar['background_color']): ?> background-color: <?php echo $option_ginger_bar['background_color']; ?>;<?php endif; ?>
            <?php if($option_ginger_bar['text_color']): ?> color: <?php echo $option_ginger_bar['text_color']; ?>;<?php endif; ?>
            }
            <?php if($option_ginger_bar['button_color']): ?>
            a.ginger_btn.ginger-accept, a.ginger_btn.ginger-disable, .ginger_btn{
                background: <?php echo $option_ginger_bar['button_color']; ?> !important;
            }
            a.ginger_btn.ginger-accept:hover, a.ginger_btn.ginger-disable:hover, .ginger_btn{
                background: <?php echo $option_ginger_bar['button_color']; ?> !important;
            }
            <?php endif; ?>
            <?php if($option_ginger_bar['button_text_color']): ?>
            a.ginger_btn {
                color: <?php echo $option_ginger_bar['button_text_color']; ?> !important;
            }
            <?php endif; ?>
            <?php if($option_ginger_bar['link_color']): ?>
            .ginger_container.<?php echo $option_ginger_bar['theme_ginger']; ?> a{
            <?php if($option_ginger_bar['link_color']): ?> color: <?php echo $option_ginger_bar['link_color']; ?>;<?php endif; ?>
            }
            <?php endif;?>
            <?php if($option_ginger_bar['ginger_css']): ?>
            <?php echo $option_ginger_bar['ginger_css']; ?>
            <?php endif;?>
        </style>
    <?php endif;
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
        $ginger_text = str_replace('</', '<\/', $ginger_text);
        $ginger_text = str_replace( array("\n", "\r"), "<br \/>", $ginger_text );
        //Recupero privacy policy se presente
        if(strpos($ginger_text, '{{privacy_page}}') !== false):
            $privacy_policy = get_option('ginger_policy', true);
            $privacy_policy = get_post($privacy_policy);
            $privacy_policy = ' <a href="' . get_permalink($privacy_policy->ID) . '">' . $privacy_policy->post_title . '<\/a>';
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
    if($option_ginger_bar['theme_ginger'] == 'dark'):
        $banner_class .= ' dark';
    else:
        $banner_class .= ' light';
    endif;
    //Recupero Testo Iframe
    if($option_ginger_bar['ginger_Iframe_text']):
        $ginger_iframe_text = $option_ginger_bar['ginger_Iframe_text'];
        $ginger_iframe_text = str_replace('</', '<\/', $ginger_iframe_text);
        $ginger_iframe_text = str_replace( array("\n", "\r"), "<br \/>", $ginger_iframe_text );
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
    endif; ?>

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
            bannerClass: 'ginger_banner-wrapper',
            bannerHTML:
                document.getElementById('ginger-banner-html') !== null ?
                    document.getElementById('ginger-banner-html').innerHTML :
                    '<div class="ginger_banner <?php echo $banner_class; ?> ginger_container ginger_container--open">'
                    <?php if($option_ginger_bar['ginger_banner_type'] == 'dialog'): ?>
                        +'<p class="ginger_message">'
                        +'<?php echo $ginger_text; ?>'
                        +'</p>'
                        +'<a href="#" class="ginger_btn ginger-accept ginger_btn_accept_all">'
                        + '<?php echo $label_accept_cookie; ?>'
                        +'<\/a>'
                        <?php if($option_ginger_bar['disable_cookie_button_status'] != 0 && $option_ginger_general['ginger_opt'] != 'out'): ?>
                        + '<a href="#" class="ginger_btn ginger-disable ginger_btn_accept_all">'
                        + '<?php echo $label_disable_cookie; ?>'
                        + '<\/a>'
                        <?php endif; ?>
                    <?php else: ?>
                        <?php if($option_ginger_bar['disable_cookie_button_status'] != 0 && $option_ginger_general['ginger_opt'] != 'out'): ?>
                        + '<a href="#" class="ginger_btn ginger-disable ginger_btn_accept_all">'
                        + '<?php echo $label_disable_cookie; ?>'
                        + '<\/a>'
                        <?php endif; ?>
                        +'<a href="#" class="ginger_btn ginger-accept ginger_btn_accept_all">'
                        + '<?php echo $label_accept_cookie; ?>'
                        +'<\/a>'
                        +'<p class="ginger_message">'
                        +'<?php echo $ginger_text; ?>'
                        +'</p>'
                    <?php endif; ?>
                    +'<\/div>',
            <?php if($option_ginger_bar['disable_cookie_button_status'] != 0 && $option_ginger_general['ginger_opt'] != 'out' && $option_ginger_general['ginger_keep_banner'] == 1): ?>
            forceEnable: true,
            forceBannerClass: 'ginger-banner bottom dialog force <?php echo $option_ginger_bar['theme_ginger']; ?> ginger_container',
            forceEnableText:
                '<p class="ginger_message">'
                +'<?php echo $ginger_text; ?>'
                +'</p>'
                +'<a href="#" class="ginger_btn ginger-accept ginger_btn_accept_all">'
                + '<?php echo $label_accept_cookie; ?>'
                +'<\/a>',
            <?php endif; ?>
            <?php if($option_ginger_general['ginger_cookie_duration']): ?>
            cookieDuration: <?php echo $option_ginger_general['ginger_cookie_duration']; ?>,
            <?php endif; ?>
            eventScroll: <?php echo $type_scroll; ?>,
            scrollOffset: 20,
            clickOutside: <?php echo $click_outside; ?>,
            cookieName: 'ginger-cookie',
            forceReload: <?php echo $ginger_force_reload; ?>,
            iframesPlaceholder: true,
            iframesPlaceholderClass: 'ginger-iframe-placeholder',
            iframesPlaceholderHTML:
                document.getElementById('ginger-iframePlaceholder-html') !== null ?
                    document.getElementById('ginger-iframePlaceholder-html').innerHTML :
                '<p><?php echo $ginger_iframe_text;  ?>'
                +'<a href="#" class="ginger_btn ginger-accept"><?php echo $label_accept_cookie; ?></a>'
                +'<\/p>'
        });
    </script>
    <!-- End Ginger Script -->

<?php }

add_action('wp_footer', 'ginger_scirpt');

//Ginger Start
function ginger_run(){
    if(is_feed()) return;
    $option_ginger_general = get_option('ginger_general');
    if($option_ginger_general['enable_ginger'] != 1) return;
    if(isset($_COOKIE['ginger-cookie']) && $_COOKIE['ginger-cookie'] == 'Y'):
        if($option_ginger_general['ginger_cache'] == 'no') return;
    endif;
    if($option_ginger_general['ginger_opt'] == 'in'):
        ob_start();
        add_action('shutdown', '__shutdown', 0);
        add_filter('final_output', 'ginger_parse_dom');
    endif;
}
add_action('wp', 'ginger_run');



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
        'new google.maps.',
        '_getTracker',
        'disqus.com',
    );

    $ginger_script_async_tags = array(
        'addthis.com'
    );

    $ginger_iframe_tags = array(
        'youtube.com',
        'platform.twitter.com',
        'www.facebook.com/plugins/like.php',
        'apis.google.com',
        'www.google.com/maps/embed/',
        'player.vimeo.com',
        'disqus.com'
    );
    do_action('ginger_add_iframe');
    if(strpos($output, '<html') === false):
        return $output;
    elseif(strpos($output, '<html') > 200 ):
        return $output;
    endif;
    libxml_use_internal_errors(true);
    $doc = new DOMDocument();
    $doc->encoding = 'utf-8';
    $doc->loadHTML(mb_convert_encoding($output, 'HTML-ENTITIES', 'UTF-8'));
    // get all the script tags
    $script_tags = $doc->getElementsByTagName('script');
    $async_array = array();
    $domElemsToRemove = array();
    foreach($script_tags as $script):
        $src_script =  $script->getAttribute('src');
        if($src_script):
            if(strpos_arr($src_script, $ginger_script_tags) !== false ):
                $script->setAttribute("class", "ginger-script");
                $script->setAttribute("type", "text/plain");
                continue;
            endif;
            if(strpos_arr($src_script, $ginger_script_async_tags) !== false ):
                $async_array[] = $src_script;
                $domElemsToRemove[] = $script;
                continue;
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
                if($ginger_script_tags[$key] == 'disqus.com/embed.js' || $ginger_script_tags[$key] == 'disqus.com'):
                    $script->setAttribute("class", "ginger-script");
                    $script->setAttribute("type", "text/plain");
                endif;
            endif;
        endif;
    endforeach;
    foreach( $domElemsToRemove as $domElement ){
        $domElement->parentNode->removeChild($domElement);
    }
    // get all the iframe tags
    $iframe_tags = $doc->getElementsByTagName('iframe');
    foreach($iframe_tags as $iframe):
        $src_iframe =  $iframe->getAttribute('src');
        if($src_iframe):
            if(strpos_arr($src_iframe, $ginger_iframe_tags) !== false ):
                $iframe->removeAttribute('src');
                $iframe->setAttribute("data-ce-src", $src_iframe);
                if($iframe->hasAttribute('class')):
                    $addclass = $iframe->getAttribute('class');
                else:
                    $addclass = '';
                endif;
                $iframe->setAttribute("class", "ginger-iframe " . $addclass);
            endif;
        endif;
    endforeach;
    if(!empty($async_array)):
        $text = json_encode($async_array);
        $text = 'var async_ginger_script = ' . $text . ';';
        $head = $doc->getElementsByTagName('head')->item(0);
        $element = $doc->createElement('script', $text);
        $head->appendChild($element);
    endif;

    // get the HTML string back
    $output = $doc->saveHTML();
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
