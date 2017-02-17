<?php
/**
 * Created by PhpStorm.
 * User: kirill_ch
 * Date: 17.02.17
 * Time: 13:24
 */

namespace App;


class Pixel
{

    public static function makeBody(DataClient $client)
    {
        return

"<script>
    (function (d, w) {
        var ts = d.createElement(\"script\"); ts.type = \"text/javascript\"; ts.async = true;
        ts.src = (d.location.protocol == \"https:\" ? \"https:\" : \"http:\") + \"//".env("PIXEL_URI")."/".$client->token."\";
        var f = function () {var s = d.getElementsByTagName(\"script\")[0]; s.parentNode.insertBefore(ts, s);};
        if (w.opera == \"[object Opera]\") { d.addEventListener(\"DOMContentLoaded\", f, false); } else { f(); }
    })(document, window);
</script>";

    }

    public static function makeZeroPixel(DataClient $client)
    {
        return

"<script>
    var cdp = new Image();
    cdp.src=(document.location.protocol==\"https:\"?\"https:\":\"http:\")+\"//".env("PIXEL_URI")."/".$client->token."\";
</script>    
";
    }

    public static function makeURL(DataClient $client)
    {
        return "http://".env("PIXEL_URI")."/".$client->token;
    }

    public static function makeSecureURL(DataClient $client)
    {
        return "https://".env("PIXEL_URI")."/".$client->token;
    }

}