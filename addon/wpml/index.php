<?php
//WPML
$option_wpml = get_option('gingerwpml');
if($option_wpml && $option_wpml['activated'] == 1):
require_once('ginger.wpml.php');
endif;

add_action("ginger_addon_activation_page", "ginger_wpml_activation_page");

function ginger_wpml_activation_page()
{
    $appname = "wpml";
    $app_data = ginger_app_data($appname);
    $option_ginger_wpml = get_option('gingerwpml');
    ?>
    <div class="ginger-addon">
    <table class="form-table striped">
        <thead>
        <tr>
            <td colspan="2">
                <img class="ginger-thumb" src="<?php echo $app_data["thumb"]; ?>" />

                <h3><?php _e("WPML", "ginger"); ?>
                    <?php
                    ginger_app_price($appname, $app_data);
                    ?></h3>
                <small><?php _e("WPML add-on will adapt Ginger for WPML multilanguage websites .", "ginger"); ?></small>
                <br style="clear: both" />
                <p>
                    <a href="http://www.ginger-cookielaw.com/prodotto/<?php echo $appname; ?>/" target="_BLANK" class="button button-primary" <?php if ($option_ginger_wpml && $option_ginger_wpml['activated'] == 1){ echo "disabled='disabled' "; } ?>><?php _e("Get Activation Code", "ginger"); ?></a>
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

    </div>
<?php

}