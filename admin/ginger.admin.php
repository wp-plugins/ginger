<?php
$key= $_GET["tab"];
if($key == "") $key = "general";
$key ="ginger_".$key;

if(isset($_POST["submit"]) && !wp_verify_nonce($_POST['ginger_options'], 'save_ginger_options')){
  return;
}

if(isset($_POST["submit"])){
    $params = $_POST;
    unset($params["submit"]);
    unset($params["ginger_options"]);
    unset($params["_wp_http_referer"]);

if ($key=='ginger_banner'){
    if ($params["disable_cookie_button_status"]!='1'){
        $params["disable_cookie_button_status"]='0';

    }
    if ($params["read_more_button_status"]!='1'){
        $params["read_more_button_status"]='0';
    }


}


        if ($key=='ginger_policy'){
            if ($_POST["choice"]=="new_page"){

                    // controllo se il nome della privacy page è già esistente.
                if (get_page_by_title( $_POST["privacy_page_title"], $output, 'page' )){

                    $control_page=get_page_by_title( $_POST["privacy_page_title"], $output, 'page' );
                    if ($control_page->post_status=='publish') {
                        $control_page_id = $control_page->ID;
                        $privacy_page_id = $control_page_id;
                        echo '<div class="updated"><p>'.__( 'The page with the specified title already exists and is your current privacy policy page!', 'ginger' ).'</p></div>';

                    }else{

                        $id_privacy_new_page=save_privacy_page($_POST["privacy_page_title"],$_POST["privacy_page_content"]);
                        $privacy_page_id=$id_privacy_new_page;
                    }


                }else{
                $id_privacy_new_page=save_privacy_page($_POST["privacy_page_title"],$_POST["privacy_page_content"]);
                $privacy_page_id=$id_privacy_new_page;
                }

            }else{
                $privacy_page_id=$_POST["ginger_privacy_page"];
            }
            update_option($key, $privacy_page_id);
        }else{
            update_option($key, $params);
        }
    echo '<div class="updated"><p>'.__( 'Updated!', 'ginger' ).'</p></div>';
}

$options = get_option($key);
?>

<div class="wrap">
   <h2>Ginger - EU Cookie Law</h2>
<hr>
   <h2 class="nav-tab-wrapper">
   <a href="admin.php?page=ginger-setup" class="nav-tab <?php echo (($_GET["page"] == 'ginger-setup') && ($_GET["tab"] == "" )) ? 'nav-tab-active' : ''; ?>"><?php _e("General Configuration", "ginger"); ?></a>
   <a href="admin.php?page=ginger-setup&tab=banner" class="nav-tab <?php echo (($_GET["page"] == 'ginger-setup') && ($_GET["tab"] == "banner" )) ? 'nav-tab-active' : ''; ?>"><?php _e("Banner Setup", "ginger"); ?></a>
   <a href="admin.php?page=ginger-setup&tab=policy" class="nav-tab <?php echo (($_GET["page"] == 'ginger-setup') && ($_GET["tab"] == "policy" )) ? 'nav-tab-active' : ''; ?>"><?php _e("Privacy Policy", "ginger"); ?></a>
       <?php  do_action("ginger_add_tab_menu"); ?>
   </h2>
    <form method="post" action="admin.php?page=<?php echo $_GET["page"]; ?>&tab=<?php echo $_GET["tab"]; ?>" <?php if ($_GET["tab"]=='url'){echo 'class="repeater"';}?>>
        <?php wp_nonce_field('save_ginger_options', 'ginger_options'); ?>
        <?php
            switch($_GET["tab"]){
                case "":
                    include('partial/general.php');
                break;
                case "banner":
                    include('partial/banner.php');
                    break;
                case "policy":
                include('partial/policy.php');
                break;
            }?>
        <p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="<?php _e("Save Changes", "ginger"); ?>"></p>
    </form>
</div>
