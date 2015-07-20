<?php
//WPML
$option_wpml = get_option('gingerwpml');
if($option_wpml && $option_wpml['activated'] == 1):
require_once('ginger.wpml.php');
endif;

add_filter("ginger_text_iframe", "ginger_wpml_text_iframe");
function ginger_wpml_text_iframe($text){
    $key = "ginger_wpml_options";
    $options = get_option($key);
    if($options == "") return $text;
    if (!function_exists('icl_get_languages')) return $text;

    global $sitepress;
    $current_lang = $sitepress->get_current_language(); //save current language

    if(trim(strip_tags($options['ginger_Iframe_text'][$current_lang]))):
        $ginger_iframe_text = $options['ginger_Iframe_text'][$current_lang];
        $ginger_iframe_text = str_replace('</', '<\/', $ginger_iframe_text);
        $ginger_iframe_text = str_replace( array("\n", "\r"), "<br \/>", $ginger_iframe_text );
        return $ginger_iframe_text;
    endif;

    return $text;
}


add_filter("ginger_text_banner", "ginger_wpml_text_banner");
function ginger_wpml_text_banner($text)
{
    $key = "ginger_wpml_options";
    $options = get_option($key);
    if ($options == "") return $text;
    if (!function_exists('icl_get_languages')) return $text;

    global $sitepress;
    $current_lang = $sitepress->get_current_language(); //save current language

    if (trim(strip_tags($options['ginger_banner_text'][$current_lang])) != ""):
        $ginger_text = $options['ginger_banner_text'][$current_lang];
        $ginger_text = str_replace('</', '<\/', $ginger_text);
        $ginger_text = str_replace(array("\n", "\r"), "<br \/>", $ginger_text);

        //Recupero privacy policy se presente
        if (strpos($ginger_text, '{{privacy_page}}') !== false):
            $privacy_policy = $options['ginger_privacy_page'][$current_lang];
            if ($privacy_policy) {

            $privacy_policy = get_post($privacy_policy);
            $privacy_policy = ' <a href="' . get_permalink($privacy_policy->ID) . '">' . $privacy_policy->post_title . '<\/a>';
            $ginger_text = str_replace('{{privacy_page}}', $privacy_policy, $ginger_text);
            }
        endif;
        return $ginger_text;
      endif;

    return $text;
}

add_filter("ginger_label_accept_cookie", "ginger_wpml_label_accept_cookie");
function ginger_wpml_label_accept_cookie($text){
    $key = "ginger_wpml_options";
    $options = get_option($key);
    if($options == "") return $text;
    if (!function_exists('icl_get_languages')) return $text;

    global $sitepress;
    $current_lang = $sitepress->get_current_language();

    if(trim($options['accept_cookie_button_text'][$current_lang])):
        $label_accept_cookie =  $options['accept_cookie_button_text'][$current_lang];
        return $label_accept_cookie;
    endif;

    return $text;
}

add_filter("ginger_label_disable_cookie", "ginger_wpml_label_disable_cookie");
function ginger_wpml_label_disable_cookie($text){
    $key = "ginger_wpml_options";
    $options = get_option($key);
    if($options == "") return $text;
    if (!function_exists('icl_get_languages')) return $text;

    global $sitepress;
    $current_lang = $sitepress->get_current_language(); //save current language
    if($options['disable_cookie_button_status'][$current_lang]):
        if(trim($options['disable_cookie_button_text'][$current_lang])):
            $label_disable_cookie =  $options['disable_cookie_button_text'][$current_lang];
            return $label_disable_cookie;
        endif;
    endif;

    return $text;
}






add_action("ginger_addon_activation_page", "ginger_wpml_activation_page");

function ginger_wpml_activation_page()
{


    ?>
    <table class="form-table striped">
        <thead>
        <tr>
            <td colspan="2">
                <h3><?php _e("WPML", "ginger"); ?></h3>
                <small><?php _e("WPML add-on will adapt Ginger for WPML multilanguage websites .", "ginger"); ?></small>
                <p>
                    <b style="color:#F99A30"><?php _e("Get activation code here:", "ginger"); ?> <a href="http://www.ginger-cookielaw.com/prodotto/wpml/" target="_BLANK">http://www.ginger-cookielaw.com/prodotto/wpml/</a></b>
                </p>

            </td>
        </tr>
        </thead>
        <tbody>
        <tr>

            <td>
                <fieldset>
                    <legend class="screen-reader-text"><span><?php _e("WPML", "ginger"); ?></span></legend>
                    <p>
                        <label>
                            <?php _e("Active add-on", "ginger");?>:&nbsp;
                        </label>
                        <?php $option_ginger_wpml = get_option('gingerwpml');?>
                        <?php if ($option_ginger_wpml && $option_ginger_wpml['activated'] == 1): ?>
                        <img id="img_google_wpml"
                             src="<?php echo plugins_url('/ginger/img/ok.png'); ?>"
                             style="max-width: 20px; max-height: 20px; vertical-align: middle">

                    <form method="get" action="<?php echo admin_url('admin.php?page=ginger-add-on'); ?>">
                        <input type="hidden" name="page" value="ginger-add-on">
                        <input id="activationcode" type="text" name="activationcode"
                               value="<?php echo $option_ginger_wpml['licence_key']; ?>" placeholder=""
                               size="30px">
                        <input id="activationmail" type="text" name="activationmail"
                               value="<?php echo $option_ginger_wpml['email']; ?>" placeholder="" size="30px">
                        <input type="hidden" name="product_id" value="gingerwpml">
                        <input type="hidden" name="request" value="deactivation">
                        <input type="submit" class="button" value="<?php _e('Deactivate', 'ginger') ?>">
                    </form>
                    <?php else: ?>
                        <img id="img_google_wpml"
                             src="<?php echo plugins_url('/ginger/img/xx.png'); ?>"
                             style="max-width: 20px; max-height: 20px; vertical-align: middle">
                        <form method="get" action="<?php echo admin_url('admin.php?page=ginger-add-on'); ?>">
                            <input type="hidden" name="page" value="ginger-add-on">
                            <input id="activationcode" type="text" name="activationcode" value=""
                                   placeholder="<?php _e('Insert here the add-on activation code.', 'ginger') ?>"
                                   size="30px">
                            <input id="activationmail" type="text" name="activationmail" value=""
                                   placeholder="<?php _e('Insert here your activation mail.', 'ginger') ?>" size="30px">
                            <input type="hidden" name="product_id" value="gingerwpml">
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
<?php

}