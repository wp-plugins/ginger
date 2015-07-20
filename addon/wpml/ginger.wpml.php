<?php
add_action("ginger_add_menu", "ginger_wpml_menu");

function ginger_wpml_menu(){

    add_submenu_page( 'ginger-setup', "WPML", __("WPML", "ginger"), 'manage_options', 'ginger-wpml', 'ginger_wpml_menu_page');


}

function ginger_wpml_menu_page(){
    global $sitepress;
    $current_lang = $sitepress->get_current_language(); //save current language

    $key = "ginger_wpml_options";
    if(isset($_POST["submit"]) && !wp_verify_nonce($_POST['ginger_options'], 'save_ginger_wpml_options')){
        return;
    }

    if(isset($_POST["submit"])){

        $params = $_POST;
        unset($params["submit"]);
        unset($params["ginger_options"]);
        unset($params["_wp_http_referer"]);


     //   print_r($params);
            update_option($key, $params);

        echo '<div class="updated"><p>'.__( 'Updated!', 'ginger' ).'</p></div>';
    }
    $options = get_option($key);

  //  print_r($options);
?>
    <div class="wrap">
        <h2>WPML - Ginger setup</h2>
        <hr>

        <?php
        if (!function_exists('icl_get_languages')) {
            echo "<h3>";
            _e("WPML is disabled!", "ginger");
            echo "</h3>";

            _e("Enable here:", "ginger");
            echo " <a href='".get_bloginfo("url")."/wp-admin/plugins.php'>"._("Plugins")."</a>";
        }else{
            ?>
            <form method="post" action="admin.php?page=<?php echo $_GET["page"]; ?>">

                <table class="form-table striped">
                    <thead>
                    <tr>
                        <td colspan="2">
                            <h2><?php _e("Banner Multilanguage Setup", "ginger"); ?></h2>
                            <?php _e("Overwrite default banner rules", "ginger"); ?>
                        </td>
                    </tr>
                    </thead>
                    <tbody>

                <?php wp_nonce_field('save_ginger_wpml_options', 'ginger_options'); ?>
                <?php
                $languages = icl_get_languages('skip_missing=0');
//print_r($languages);
                $c=0;
            foreach ($languages as $langcode=>$langval ) {
?>
                <tr style="background-color:#F99A30; ">
                    <th scope="row" style="padding-left:20px;"></th>
                    <td>
                        <h2><?php echo $langval["native_name"]; ?></h2>
                    </td>
                </tr>

                <tr>
                    <th scope="row" style="padding-left:20px;"><?php _e("Banner Text", "ginger"); ?> - <?php echo $langval["native_name"]; ?></th>
                    <td>
                        <fieldset>
                            <legend class="screen-reader-text"><span><?php _e("Banner Text", "ginger"); ?></span></legend>
                            <p><label><?php
                                    if (function_exists("wp_editor"))
                                        wp_editor(stripslashes($options["ginger_banner_text"][$langcode]), "ginger_bar_text_".$langcode."", array('textarea_name' => "ginger_banner_text[".$langcode."]", 'media_buttons' => false, 'textarea_rows' => 3, 'teeny' => true));
                                    else
                                        echo '<textarea name = "ginger_banner_text['.$langcode.']" >' . $options["ginger_banner_text"][$langcode] . '</textarea>';
                                    ?>
                                    <br>
                                    <small><?php _e('You can use syntax <code>{{privacy_page}}</code> to link Privacy Police Page defined in <a href="admin.php?page=ginger-setup&tab=policy">Privacy Policy Tab</a>', "ginger"); ?></small>
                                </label>
                            </p>
                        </fieldset>
                    </td>
                </tr>

                <tr>
                    <th scope="row" style="padding-left:20px;"><?php _e('Privacy Policy page', 'ginger'); ?> - <?php echo $langval["native_name"]; ?></th>
                    <td>
                        <fieldset>
                            <p><label>
                                    <?php
                                    $sitepress->switch_lang($langcode);
                                    $args = array(
                                        'sort_order' => 'asc',
                                        'sort_column' => 'post_title',
                                        'hierarchical' => 1,
                                        'number' => '',
                                        'offset' => 0,
                                        'post_type' => 'page',
                                        'post_status' => 'publish',
                                    );

                                    $p = new WP_Query( $args );
                                    ?>
                                    <select name="ginger_privacy_page[<?php echo $langcode; ?>]"  id="privacy_page_select_<?php echo $langcode; ?>" >
                                        <option value=""><?php _e('Select page', 'ginger'); ?></option>
                                        <?php
                                        while ( $p->have_posts() ) :
                                            $p->next_post();
                                            ?>
                                            <option value="<?php echo $p->post->ID; ?>" <?php if ($options["ginger_privacy_page"][$langcode] == $p->post->ID) echo ' selected="selected" '; ?>><?php echo $p->post->post_title; ?></option>
                                        <?php
                                        endwhile;
                                        ?>
                                    </select>
                                    <?php
                                    $sitepress->switch_lang($current_lang); //restore previous language
                                    ?>

                                </label></p>
                        </fieldset>
                    </td>
                </tr>



                <tr>
                    <th scope="row" style="padding-left:20px;"><?php _e("Iframe Text", "ginger"); ?> - <?php echo $langval["native_name"]; ?></th>
                    <td>
                        <fieldset>
                            <legend class="screen-reader-text"><span><?php _e("Iframe Text", "ginger"); ?></span></legend>
                            <p><label><?php
                                    if (function_exists("wp_editor"))
                                        wp_editor(stripslashes($options["ginger_Iframe_text"][$langcode]), "ginger_Iframe_text_".$langcode."", array('textarea_name' => "ginger_Iframe_text[".$langcode."]", 'media_buttons' => false, 'textarea_rows' => 3, 'teeny' => true));
                                    else
                                        echo '<textarea name = "ginger_Iframe_text['.$langcode.']" >' . $options["ginger_Iframe_text"][$langcode] . '</textarea>';

                                    ?></label></p>
                        </fieldset>
                    </td>
                </tr>

                <tr>
                    <th scope="row" style="padding-left:20px;"><?php _e("Customize your banner buttons", "ginger"); ?> - <?php echo $langval["native_name"]; ?></th>
                    <td>
                        <fieldset>
                            <legend class="screen-reader-text"><span><?php _e("Iframe Text", "ginger"); ?></span></legend>
                            <p>
                                <label><b><?php _e("Accept cookie Button", "ginger"); ?></b></label>
                            </p>

                            <p>
                                <label><?php _e("Text", "ginger"); ?></label>
                                <input name="accept_cookie_button_text[<?php echo $langcode; ?>]" id="accept_cookie_button_text_<?php echo $langcode; ?>" type="text"
                                       value="<?php if ($options['accept_cookie_button_text'][$langcode] != "") {
                                           echo $options['accept_cookie_button_text'][$langcode];
                                       } else {
                                           echo _e('Accept Cookie', 'ginger');
                                       } ?>">
                            </p>

                            <p>
                                <label><b><?php _e("Disable cookie Button", "ginger"); ?></b></label>
                            </p>

                            <p>
                                <label><?php _e("Text", "ginger"); ?></label>
                                <input name="disable_cookie_button_text[<?php echo $langcode; ?>]" id="disable_cookie_button_text_<?php echo $langcode; ?>" type="text"
                                       value="<?php if ($options['disable_cookie_button_text'][$langcode] != "") {
                                           echo $options['disable_cookie_button_text'][$langcode];
                                       } else {
                                           echo _e('Disable Cookie', 'ginger');
                                       } ?>" <?php if ($options['disable_cookie_button_status'][$langcode] != "1") {
                                    echo 'disabled=true';
                                } ?>>
                                <?php echo _e('Enable:', 'ginger') ?>&nbsp;
                                <input type="checkbox" id="disable_cookie_button_status_<?php echo $langcode; ?>" name="disable_cookie_button_status[<?php echo $langcode; ?>]"
                                       value="1" <?php if ($options['disable_cookie_button_status'][$langcode] == "1") {
                                    echo 'checked';
                                } ?>
                                       onclick="en_dis_able_text_banner_button('disable_cookie_button_status_<?php echo $langcode; ?>','disable_cookie_button_text_<?php echo $langcode; ?>','img_disable_cookie_button_status_<?php echo $langcode; ?>');">


                                <img id="img_disable_cookie_button_status_<?php echo $langcode; ?>"
                                     src="<?php if ($options['disable_cookie_button_status'][$langcode] == "1") {
                                         echo plugins_url("ginger/img/ok.png");
                                     } else {
                                         echo plugins_url("ginger/img/xx.png");
                                     } ?>" style="max-width: 20px; max-height: 20px; vertical-align: middle">


                            </p>
                        </fieldset>
                    </td>
                </tr>




                <?php

            }
?>
                    </tbody>
                </table>
                <p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="<?php _e("Save Changes", "ginger"); ?>"></p>
            </form>
                <?php

        }// check wpml active
        ?>



        </div>

<?php

}