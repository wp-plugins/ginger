<?php

?>
    <table class="form-table striped">
        <thead>
        <tr>
            <td colspan="2">
                <h2><?php _e("Link", "ginger"); ?></h2>
            </td>
        </tr>
        <tr>
            <td>
                <div data-repeater-list="group-a">
                    <?php

                    if ($options['group-a']) {
                        foreach ($options['group-a'] as $option) {
                            ?>
                            <div data-repeater-item>

                                URL: <input type="text" name="ginger_url" value="<?php echo $option['ginger_url'];?>"/>

                                Enable:&nbsp;SI&nbsp;<input type="radio" name="ginger_url_enable" value="1" <?php if ($option['ginger_url_enable']==1){ echo 'checked';}?>/>
                                NO&nbsp;<input type="radio" name="ginger_url_enable" value="0" <?php if ($option['ginger_url_enable']==0){ echo 'checked';}?>/>


                                <input data-repeater-delete type="button" value="Delete" class="button button-primary"/>
                            </div>
                        <?php
                        }
                    }else{
                        ?>
                        <div data-repeater-item>

                            <?php _e("URL", "ginger"); ?>: <input type="text" name="ginger_url" value=""/>

                            <?php _e("Enable", "ginger"); ?>:&nbsp;<?php _e("YES", "ginger"); ?>&nbsp;<input type="radio" name="ginger_url_enable" value="1" />
                            <?php _e("NO", "ginger"); ?>&nbsp;<input type="radio" name="ginger_url_enable" value="0" />


                            <input data-repeater-delete type="button" value="Delete" class="button button-primary"/>
                        </div>
                    <?php

                    }
                    ?>


                </div>
                <p style="margin-top: 20px"><input data-repeater-create type="button" class="button button-primary" value="Add Url"/></p>

            </td>

        </tr>
</thead>
</table>





    <script src="../wp-content/plugins/ginger/admin/js/jquery.repeater-master/jquery.repeater.js"></script>
    <script>
        jQuery(document).ready(function () {
            'use strict';
            jQuery('.repeater').repeater({
                defaultValues: {
                    //'textarea-input': 'foo',
                    'ginger_url': '',
                    //'select-input': 'B',
                    //'checkbox-input': ['A', 'B'],
                    'ginger_url_enable': '1'
                },
                show: function () {
                    jQuery(this).slideDown();
                },
                hide: function (deleteElement) {
                    if(confirm('Are you sure you want to delete this element?')) {
                        jQuery(this).slideUp(deleteElement);

                    }

                }
            });
        });
    </script>
        <?php


?>






<?php


