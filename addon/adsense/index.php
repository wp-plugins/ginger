<?php
//Adsense
$option_adense = get_option('gingeradsense');
if($option_adense && $option_adense['activated'] == 1):
    require_once('ginger.adsense.php');
endif;

add_action("ginger_addon_activation_page", "ginger_adsense_activation_page");

function ginger_adsense_activation_page()
{


    ?>
    <table class="form-table striped">
        <thead>
        <tr>
            <td colspan="2">
                <h3><?php _e("Google AdSense", "ginger"); ?></h3>
                <small><?php _e("This add-on blocks cookies and ads created by Google AdSense, until user's acceptation.", "ginger"); ?></small>
                <p>

                    <b style="color:#F99A30"><?php _e("Get activation code here:", "ginger"); ?> <a href="http://www.ginger-cookielaw.com/prodotto/adsense/" target="_BLANK">http://www.ginger-cookielaw.com/prodotto/adsense/</a></b>
                </p>
            </td>
        </tr>
        </thead>
        <tbody>
        <tr>

            <td>
                <fieldset>
                    <legend class="screen-reader-text"><span><?php _e("Google AdSense", "ginger"); ?></span></legend>
                    <p>
                        <label>
                            <?php _e("Active add-on", "ginger");?>:&nbsp;
                        </label>
                        <?php $option_ginger_analitics = get_option('gingeradsense');?>
                        <?php if ($option_ginger_analitics && $option_ginger_analitics['activated'] == 1): ?>
                        <img id="img_google_analytics"
                             src="<?php echo plugins_url('/ginger/img/ok.png'); ?>"
                             style="max-width: 20px; max-height: 20px; vertical-align: middle">

                    <form method="get" action="<?php echo admin_url('admin.php?page=ginger-add-on'); ?>">
                        <input type="hidden" name="page" value="ginger-add-on">
                        <input id="activationcode" type="text" name="activationcode"
                               value="<?php echo $option_ginger_analitics['licence_key']; ?>" placeholder=""
                               size="30px">
                        <input id="activationmail" type="text" name="activationmail"
                               value="<?php echo $option_ginger_analitics['email']; ?>" placeholder="" size="30px">
                        <input type="hidden" name="product_id" value="gingeradsense">
                        <input type="hidden" name="request" value="deactivation">
                        <input type="submit" class="button" value="<?php _e('Deactivate', 'ginger') ?>">
                    </form>
                    <?php else: ?>
                        <img id="img_google_analytics"
                             src="<?php echo plugins_url('/ginger/img/xx.png'); ?>"
                             style="max-width: 20px; max-height: 20px; vertical-align: middle">
                        <form method="get" action="<?php echo admin_url('admin.php?page=ginger-add-on'); ?>">
                            <input type="hidden" name="page" value="ginger-add-on">
                            <input id="activationcode" type="text" name="activationcode" value=""
                                   placeholder="<?php _e('Insert here the add-on activation code.', 'ginger') ?>"
                                   size="30px">
                            <input id="activationmail" type="text" name="activationmail" value=""
                                   placeholder="<?php _e('Insert here your activation mail.', 'ginger') ?>" size="30px">
                            <input type="hidden" name="product_id" value="gingeradsense">
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