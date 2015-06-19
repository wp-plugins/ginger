<table class="form-table striped">
    <thead>
        <tr>
            <td colspan="2">
                <h2><?php _e("Banner Setup", "ginger"); ?></h2>
            </td>
        </tr>
    </thead>
    <tbody>
    <tr>
        <th scope="row" style="padding-left:20px;"><?php _e("Choose Banner Type", "ginger"); ?></th>
        <td>
            <fieldset>
                <legend class="screen-reader-text"><span><?php _e("Choose Banner Type", "ginger"); ?></span></legend>
                <p><label><input name="ginger_banner_type" type="radio" value="bar" class="tog" <?php if($options["ginger_banner_type"] == "bar") echo ' checked="checked" '; ?>><?php _e("Bar", "ginger"); ?></label></p>
                <p><label><input name="ginger_banner_type" type="radio" value="dialog" class="tog" <?php if($options["ginger_banner_type"] == "dialog") echo ' checked="checked" '; ?>><?php _e("Dialog", "ginger"); ?></label></p>
            </fieldset>
        </td>
    </tr>
    <tr>
        <th scope="row" style="padding-left:20px;"><?php _e("Banner Position", "ginger"); ?></th>
        <td>
            <fieldset>
                <legend class="screen-reader-text"><span><?php _e("Banner Position", "ginger"); ?></span></legend>
                <p><label><input name="ginger_banner_position" type="radio" value="top" class="tog" <?php if($options["ginger_banner_position"] == "top") echo ' checked="checked" '; ?>><?php _e("Top", "ginger"); ?></label></p>
                <p><label><input name="ginger_banner_position" type="radio" value="bottom" class="tog" <?php if($options["ginger_banner_position"] == "bottom") echo ' checked="checked" '; ?>><?php _e("Bottom", "ginger"); ?></label></p>
            </fieldset>
        </td>
    </tr>
    <tr>
        <th scope="row" style="padding-left:20px;"><?php _e("Banner Text", "ginger"); ?></th>
        <td>
            <fieldset>
                <legend class="screen-reader-text"><span><?php _e("Banner Text", "ginger"); ?></span></legend>
                <p><label><?php wp_editor( $options["ginger_banner_text"], "ginger_bar_text", array( 'textarea_name' => "ginger_banner_text" , 'media_buttons' => false, 'textarea_rows' => 3, 'teeny' => true ) );?>
                         <br><small><?php _e('You can use syntax <code>{{privacy_page}}</code> to link Privacy Police Page defined in <a href="admin.php?page=ginger-setup&tab=policy">Privacy Policy Tab</a>', "ginger"); ?></small>
                    </label>
                </p>
            </fieldset>
        </td>
    </tr>
    <tr>
        <th scope="row" style="padding-left:20px;"><?php _e("Iframe Text", "ginger"); ?></th>
        <td>
            <fieldset>
                <legend class="screen-reader-text"><span><?php _e("Iframe Text", "ginger"); ?></span></legend>
                <p><label><?php wp_editor( $options["ginger_Iframe_text"], "ginger_Iframe_text", array( 'textarea_name' => "ginger_Iframe_text" , 'media_buttons' => false, 'textarea_rows' => 3, 'teeny' => true ) );?></label></p>
            </fieldset>
        </td>
    </tr>
    <tr>
        <th scope="row" style="padding-left:20px;"><?php _e("Customize your banner buttons", "ginger"); ?></th>
        <td>
            <fieldset>
                <legend class="screen-reader-text"><span><?php _e("Iframe Text", "ginger"); ?></span></legend>
                <p><label><b><?php _e("Accept cookie Button", "ginger"); ?></b></label>
                </p>
                <p>
                    <label><?php _e("Text", "ginger"); ?></label>
                    <input name="accept_cookie_button_text" id="accept_cookie_button_text"  type="text" value="<?php if ($options['accept_cookie_button_text']!=""){ echo $options['accept_cookie_button_text'];}else{ echo _e('Accept Cookie', 'ginger');}?>">
                </p>
                <p>
                    <label><b><?php _e("Disable cookie Button", "ginger"); ?></b></label>
                </p>
                <p>
                    <label><?php _e("Text", "ginger"); ?></label>
                    <input name="disable_cookie_button_text" id="disable_cookie_button_text"  type="text" value="<?php if ($options['disable_cookie_button_text']!=""){ echo $options['disable_cookie_button_text'];}else{ echo _e('Disable Cookie', 'ginger');}?>">
                    <?php echo _e('Enable:','ginger')?>&nbsp;
                    <label><?php echo _e('Yes','ginger')?>&nbsp;</label>
                    <input type="radio" name="disable_cookie_button_status" value="1" <?php if ($options['disable_cookie_button_status']=="1" or $options['disable_cookie_button_status']==""){ echo 'checked';}?> onclick="enable_text_banner_button('disable_cookie_button_text');">
                    <label><?php echo _e('No','ginger')?>&nbsp;</label>
                    <input type="radio" name="disable_cookie_button_status" value="0" <?php if ($options['disable_cookie_button_status']=="0"){ echo 'checked';}?> onclick="disable_text_banner_button('disable_cookie_button_text');">
                </p>
                <p>
                    <label><b><?php _e("Read More Button", "ginger"); ?></b></label>
                </p>
                <p>
                    <label><?php _e("Text", "ginger"); ?></label>
                    <input name="read_more_button_text" id="read_more_button_text"  type="text" value="<?php if ($option['read_more_button_text']!=""){ echo $options['read_more_button_text'];}else{ echo _e('Read More', 'ginger');}?>">
                    <?php echo _e('Enable:','ginger')?>&nbsp;
                    <label><?php echo _e('Yes','ginger')?>&nbsp;</label>
                    <input type="radio" name="read_more_button_status" value="1" <?php if ($options['read_more_button_status']=="1" or $options['read_more_button_status']==""){ echo 'checked';}?>  onclick="enable_text_banner_button('read_more_button_text');">
                    <label><?php echo _e('No','ginger')?>&nbsp;</label>
                    <input type="radio" name="read_more_button_status" value="0" <?php if ($options['read_more_button_status']=="0"){ echo 'checked';}?>  onclick="disable_text_banner_button('read_more_button_text');">
                </p>
            </fieldset>
        </td>
    </tr>
    <tr>
        <th scope="row" style="padding-left:20px;"><?php _e("Choose Ginger Theme", "ginger"); ?></th>
        <td>
            <fieldset>
                <legend class="screen-reader-text"><span><?php _e("Choose Ginger Theme", "ginger"); ?></span></legend>
                <p><label><input name="theme_ginger" type="radio" value="light" class="tog" <?php if($options["theme_ginger"] == "light") echo ' checked="checked" '; ?>><?php _e("Light Theme", "ginger"); ?></label></p>
                <p><label><input name="theme_ginger" type="radio" value="dark" class="tog" <?php if($options["theme_ginger"] == "dark") echo ' checked="checked" '; ?>><?php _e("Dark Theme", "ginger"); ?></label></p>
            </fieldset>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <h2><?php _e("Customize your Ginger theme", "ginger"); ?></h2>
        </td>
    </tr>
    <tr>
        <th scope="row" style="padding-left:20px;"><?php _e("Background", "ginger"); ?></th>
        <td>
            <fieldset>
                <legend class="screen-reader-text"><span><?php _e("Background", "ginger"); ?></span></legend>
                <p><label><input type="text" name="background_color" value="<?php echo $options["background_color"]; ?>" class="color-field" ></label></p>
            </fieldset>
        </td>
    </tr>
    <tr>
        <th scope="row" style="padding-left:20px;"><?php _e("Text", "ginger"); ?></th>
        <td>
            <fieldset>
                <legend class="screen-reader-text"><span><?php _e("Text", "ginger"); ?></span></legend>
                <p><label><input type="text" name="text_color" value="<?php echo $options["text_color"]; ?>" class="color-field" ></label></p>
            </fieldset>
        </td>
    </tr>
    <tr>
        <th scope="row" style="padding-left:20px;"><?php _e("Button", "ginger"); ?></th>
        <td>
            <fieldset><legend class="screen-reader-text"><span><?php _e("Button", "ginger"); ?></span></legend>
                <p><label><input type="text" name="button_color" value="<?php echo $options["button_color"]; ?>" class="color-field" ></label></p>
            </fieldset>
        </td>
    </tr>
    <tr>
        <th scope="row" style="padding-left:20px;"><?php _e("Link", "ginger"); ?></th>
        <td>
            <fieldset><legend class="screen-reader-text"><span><?php _e("Link", "ginger"); ?></span></legend>
                <p><label><input type="text" name="link_color" value="<?php echo $options["link_color"]; ?>" class="color-field" ></label></p>
            </fieldset>
        </td>
    </tr>
    </tbody>
</table>
