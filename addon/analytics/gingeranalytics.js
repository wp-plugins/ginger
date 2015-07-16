/**
 * Created by matteobarale on 09/07/15.
 */
window.onload = function() {
    if (typeof(ginger_analytics_code) !== 'undefined') {
        var code = ginger_analytics_code;
    }else{
        var code = 'UA-XXXX-Y';
    }
    console.log(getCookie('ginger-cookie'));

    if(getCookie('ginger-cookie') == 'Y'){
        var gacode = "ga('create', '" + code + "', 'auto'); ga('send', 'pageview');";
    }else{
        var gacode =  "ga('create', '" + code + "', 'auto'); ga('set', 'anonymizeIP', true); ga('send', 'pageview');";
    }

    var scriptanalytics = document.createElement('script');
    scriptanalytics.type = 'text/javascript';
    scriptanalytics.innerHTML = gacode;
    console.log(scriptanalytics);
    document.getElementsByTagName('head')[0].appendChild(scriptanalytics);
}

function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i=0; i<ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1);
        if (c.indexOf(name) == 0) return c.substring(name.length,c.length);
    }
    return "";
}