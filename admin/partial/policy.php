<?php

?>
    <table class="form-table striped">
         <thead>
            <tr>
                <td colspan="2">
                    <h2><?php _e("Privacy Policy Setup", "ginger"); ?></h2>
                </td>
            </tr>
         </thead>
        <tbody>

            <tr>
                <th scope="row" style="padding-left:20px;"><label><input name="choice" type="radio" value="page" onclick="select_privacy_page()" <?php if($options != "") echo ' checked="checked" '; ?>> <?php _e("Select your privacy policy page", "ginger"); ?></label></th>
            </tr>
            <tr>
                <td colspan="2">
                    <fieldset>
                        <legend class="screen-reader-text">
                            <span><?php _e("DialogText", "ginger"); ?></span>
                        </legend>
                                <?php

                                    $args = array(
                                        'sort_order' => 'asc',
                                        'sort_column' => 'post_title',
                                        'hierarchical' => 1,
                                        'exclude' => '',
                                        'include' => '',
                                        'meta_key' => '',
                                        'meta_value' => '',
                                        'authors' => '',
                                        'child_of' => 0,
                                        'parent' => -1,
                                        'exclude_tree' => '',
                                        'number' => '',
                                        'offset' => 0,
                                        'post_type' => 'page',
                                        'post_status' => 'publish',
                                        'suppress_filters' => false
                                    );
                                    $pages = get_pages($args);




                                ?>
                        <p>
                            <label>
                                <?php _e('Privacy Policy page','ginger');?>
                            </label>
                            <select name="ginger_privacy_page" id="privacy_page_select" <?php if($options == "") echo ' disabled="true"'; ?>>
                                <option value="">Select page</option>
                                <?php
                                    foreach ($pages as $page){
                                ?>

                                <option value="<?php echo $page->ID;?>" <?php if($options == $page->ID) echo ' selected="selected" '; ?>><?php echo $page->post_title; ?></option>




                                <?php
                                    }
                                ?>
                            </select>
                        </p>
                    </fieldset>
                </td>
            </tr>
            <tr>
                <th scope="row" style="padding-left:20px;"><label><input name="choice" type="radio" value="new_page" onclick="new_privacy_page()"><?php _e("or create your privacy policy page", "ginger"); ?></label></th>
            </tr>
            <tr>
                <td colspan="2"><fieldset>
                    <div id="new_page_privacy" style="display: none">
                        <p>
                            <label>
                                <?php _e("Title", "ginger"); ?><input name="privacy_page_title" id="privacy_page_title"  type="text" value="Privacy Policy">
                            </label>
                        </p>
                        <p>
                            <label>
                                <fieldset>
                                    <legend class="screen-reader-text">
                                        <span><?php _e("DialogText", "ginger"); ?></span>
                                    </legend>
                                        <?php
                                            wp_editor( '', "ginger_dialog_text", array( 'textarea_name' => "privacy_page_content" , 'media_buttons' => false, 'textarea_rows' => 10, 'teeny' => true ) );
                                        ?>
                                </fieldset>
                            </label>
                        </p>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>