(function( $ ) {

    // Add Color Picker to all inputs that have 'color-field' class
    $(function() {
        $('.color-field').wpColorPicker();
    });

})( jQuery );

function select_privacy_page(){

    document.getElementById('privacy_page_select').disabled=false;
    document.getElementById('new_page_privacy').style.display='none';
    document.getElementById('new_page_privacy').style.display='none';
}

function new_privacy_page(){

    document.getElementById('privacy_page_select').disabled=true;
    document.getElementById('new_page_privacy').style.display='inline';
    document.getElementById('new_page_privacy').style.display='inline';
}
function disable_text_banner_button(id){

    document.getElementById(id).disabled=true;
    document.getElementById('new_page_privacy').style.display='inline';
    document.getElementById('new_page_privacy').style.display='inline';
}
function enable_text_banner_button(id){

    document.getElementById(id).disabled=false;
    document.getElementById('new_page_privacy').style.display='inline';
    document.getElementById('new_page_privacy').style.display='inline';
}