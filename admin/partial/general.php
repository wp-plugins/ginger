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
        </tbody>
    </table>



