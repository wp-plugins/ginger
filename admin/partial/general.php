<?php

?>
    <table class="form-table striped">
        <thead>
            <tr>
                <td colspan="2">
                    <h2><?php _e("Ginger is currently", "ginger"); ?>: <b><?php if($options["enable_ginger"]) _e("enabled", "ginger"); else _e("disabled", "ginger");  ?></b> </h2>
                </td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th scope="row" style="padding-left:20px;"><?php _e("Enable Ginger", "ginger"); ?></th>
                <td>
                    <fieldset>
                        <legend class="screen-reader-text"><span><?php _e("Enable Ginger", "ginger"); ?></span></legend>
                        <p>
                            <label>
                                <input name="enable_ginger" type="radio" value="1" class="tog" <?php if($options["enable_ginger"] == "1") echo ' checked="checked" '; ?>><?php _e("Enabled", "ginger"); ?>
                            </label>
                        </p>
                        <p>
                            <label>
                                <input name="enable_ginger" type="radio" value="0" class="tog" <?php if($options["enable_ginger"] == "0") echo ' checked="checked" '; ?>><?php _e("Disabled", "ginger"); ?>
                            </label>
                        </p>
                    </fieldset>
                </td>
            </tr>
            <tr>
                <th scope="row" style="padding-left:20px;"><?php _e("Do you have a cache system?", "ginger"); ?></th>
                <td>
                    <fieldset>
                        <legend class="screen-reader-text"><span><?php _e("Do you have a cache system?", "ginger"); ?></span></legend>
                        <p>
                            <label>
                                <input name="ginger_cache" type="radio" value="yes" class="tog" <?php if($options["ginger_cache"] == "yes") echo ' checked="checked" '; ?>><?php _e("Yes", "ginger"); ?>
                            </label>
                        </p>
                        <p>
                            <label>
                                <input name="ginger_cache" type="radio" value="no" class="tog" <?php if($options["ginger_cache"] == "no") echo ' checked="checked" '; ?>><?php _e("No", "ginger"); ?>
                            </label>
                        </p>
                        <p>
                            <small style="padding-top: 20px">
                                <i>(<?php _e("If you have a caching system (W3TC, Varnish, WP Super Cash...) choose YES. Ginger will optimize websites performances", "ginger"); ?>)</i>
                            </small>
                        </p>
                    </fieldset>
                </td>
            </tr>
            <tr>
                <th scope="row" style="padding-left:20px;"><?php _e("Cookie Confirmation Type", "ginger"); ?></th>
                <td>
                    <fieldset>
                        <legend class="screen-reader-text"><span><?php _e("Cookie Confirmation Type", "ginger"); ?></span></legend>
                        <p>
                            <label>
                                <input name="ginger_opt" type="radio" value="in" class="tog" <?php if($options["ginger_opt"] == "in") echo ' checked="checked" '; ?>><?php _e("Opt-In", "ginger"); ?>
                            </label>
                            <small>
                                (<?php _e("Cookies are disabled until banner is accepted", "ginger"); ?>)
                            </small>
                        </p>
                        <p>
                            <label>
                                <input name="ginger_opt" type="radio" value="out" class="tog" <?php if($options["ginger_opt"] == "out") echo ' checked="checked" '; ?>><?php _e("Opt-Out", "ginger"); ?>
                            </label>
                            <small>
                                (<?php _e("Cookies are disabled only if explicitly requested", "ginger"); ?>)
                            </small>
                        </p>
                        <p>
                            <small style="padding-top: 20px">
                                <i>(<?php _e("Choose OPT-IN if you're in Italy", "ginger"); ?>)</i>
                            </small>
                        </p>
                    </fieldset>

                </td>
            </tr>
            <tr>
                <th scope="row" style="padding-left:20px;"><?php _e("Let scroll to confirm", "ginger"); ?></th>
                <td>
                    <fieldset>
                        <legend class="screen-reader-text">
                            <span><?php _e("Let scroll to confirm", "ginger"); ?></span>
                        </legend>
                        <p>
                            <label>
                                <input name="ginger_scroll" type="radio" value="1" class="tog" <?php if($options["ginger_scroll"] == "1") echo ' checked="checked" '; ?>><?php _e("Scroll to accept cookie", "ginger"); ?>
                            </label>
                        </p>
                        <p>
                            <label>
                                <input name="ginger_scroll" type="radio" value="0" class="tog" <?php if($options["ginger_scroll"] == "0") echo ' checked="checked" '; ?>><?php _e("Keep banner after scroll", "ginger"); ?>
                            </label>
                        </p>
                    </fieldset>
                </td>
            </tr>
            <tr>
                <th scope="row" style="padding-left:20px;"><?php _e("Click out of banner to accept cookie", "ginger"); ?></th>
                <td>
                    <fieldset>
                        <legend class="screen-reader-text">
                            <span><?php _e("Click out of banner to accept cookie", "ginger"); ?></span>
                        </legend>
                        <p>
                            <label>
                                <input name="ginger_click_out" type="radio" value="1" class="tog" <?php if($options["ginger_click_out"] == "1") echo ' checked="checked" '; ?>><?php _e("Yes", "ginger"); ?>
                            </label>
                        </p>
                        <p>
                            <label>
                                <input name="ginger_click_out" type="radio" value="0" class="tog" <?php if($options["ginger_click_out"] == "0") echo ' checked="checked" '; ?>><?php _e("No", "ginger"); ?>
                            </label>
                        </p>
                    </fieldset>
                </td>
            </tr>
            <tr>
                <th scope="row" style="padding-left:20px;"><?php _e("Force reload page", "ginger"); ?></th>
                <td>
                    <fieldset>
                        <legend class="screen-reader-text">
                            <span><?php _e("Force reload page", "ginger"); ?></span>
                        </legend>
                        <p>
                            <label>
                                <input name="ginger_force_reload" type="radio" value="1" class="tog" <?php if($options["ginger_force_reload"] == "1") echo ' checked="checked" '; ?>><?php _e("Yes", "ginger"); ?>
                            </label>
                        </p>
                        <p>
                            <label>
                                <input name="ginger_force_reload" type="radio" value="0" class="tog" <?php if($options["ginger_force_reload"] == "0") echo ' checked="checked" '; ?>><?php _e("No", "ginger"); ?>
                            </label>
                        </p>
                    </fieldset>
                </td>
            </tr>
            <tr>
                <th scope="row" style="padding-left:20px;"><?php _e("Stress Mode", "ginger"); ?></th>
                <td>
                    <fieldset>
                        <legend class="screen-reader-text">
                            <span><?php _e("Keep banner until acceptance", "ginger"); ?></span>
                        </legend>
                        <p>
                            <label>
                                <input name="ginger_keep_banner" type="radio" value="1" class="tog" <?php if($options["ginger_keep_banner"] == "1") echo ' checked="checked" '; ?>><?php _e("Yes", "ginger"); ?>
                            </label>
                        </p>
                        <p>
                            <label>
                                <input name="ginger_keep_banner" type="radio" value="0" class="tog" <?php if($options["ginger_keep_banner"] == "0") echo ' checked="checked" '; ?>><?php _e("No", "ginger"); ?>
                            </label>
                        </p>
                        <p>
                            <small style="padding-top: 20px">
                                <i>(<?php _e("If cookies are not accepted the banner will continues to be shown minimized", "ginger"); ?>)</i>
                            </small>
                        </p>
                    </fieldset>
                </td>
            </tr>
            <tr>
                <th scope="row" style="padding-left:20px;"><?php _e("Cookies Duration", "ginger"); ?></th>
                <td>
                    <fieldset>
                        <legend class="screen-reader-text">
                            <span><?php _e("Select cookies duration", "ginger"); ?></span>
                        </legend>
                        <p>
                            <label><?php _e("Select cookies duration", "ginger"); ?></label>
                            <select name="ginger_cookie_duration">
                                <option value=""><?php _e('Select', 'ginger')?></option>
                                <option value="1" <?php if ($options['ginger_cookie_duration']=='1'){echo 'selected';}?>><?php _e('1 Day', 'ginger')?></option>
                                <option value="30" <?php if ($options['ginger_cookie_duration']=='30'){echo 'selected';}?>><?php _e('1 Month', 'ginger')?></option>
                                <option value="365" <?php if ($options['ginger_cookie_duration']=='365'){echo 'selected';}?>><?php _e('1 Year', 'ginger')?></option>
                                <option value="365000" <?php if ($options['ginger_cookie_duration']=='365000'){echo 'selected';}?>><?php _e('For ever', 'ginger')?></option>
                            </select>
                        </p>

                    </fieldset>
                </td>
            </tr>

        </tbody>
    </table>



