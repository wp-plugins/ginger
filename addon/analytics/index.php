<?php
//Analitycs
$option_analitycs = get_option('gingeranalytics');
if($option_analitycs && $option_analitycs['activated'] == 1):
    require_once('ginger.analytics.php');
endif;

add_action("ginger_addon_activation_page", "ginger_analytics_activation_page");

function ginger_analytics_activation_page()
{


    ?>
    <table class="form-table striped">
        <thead>
        <tr>
            <td colspan="2">
                <h3><?php _e("Google Analytics", "ginger"); ?></h3>
                <small><?php _e("Google Analytics Add-on will add analytics tracking code to your site, switching automatically between anonymized/not anonymized mode based on user cookies acceptance.", "ginger"); ?></small>
                <p>
                    <b style="color:#F99A30"><?php _e("Get activation code here:", "ginger"); ?> <a href="http://www.ginger-cookielaw.com/prodotto/google-analytics" target="_BLANK">http://www.ginger-cookielaw.com/prodotto/google-analytics/</a></b>
                </p>
            </td>
        </tr>
        </thead>
        <tbody>
        <tr>

            <td>
                <fieldset>
                    <legend class="screen-reader-text"><span><?php _e("Google Analytics", "ginger"); ?></span></legend>

                    <p>
                        <label>
                            <?php _e("Active add-on", "ginger");?>:&nbsp;
                        </label>
                        <?php $option_ginger_analitics = get_option('gingeranalytics');?>
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
                        <input type="hidden" name="product_id" value="gingeranalytics">
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
                            <input type="hidden" name="product_id" value="gingeranalytics">
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