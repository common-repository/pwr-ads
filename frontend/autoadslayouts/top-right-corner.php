<?php

$template_name = 'top-right-corner';

$url = ' https://portal-pwr-ads.com/getautoad/top_right_corner ';

$request = wp_remote_retrieve_body(wp_remote_get($url));

//print_r(json_decode( $request));

if (is_wp_error($request)) {

    return false; // Bail early
}

$data = json_decode($request);

if ($data != null) {

    if (isset($data->source)) {
        $encryption = $data->script;
        // Store the cipher method
        $ciphering = "AES-128-CTR";
        // Use OpenSSl Encryption method
        $iv_length = openssl_cipher_iv_length($ciphering);
        $options = 0;
        // Non-NULL Initialization Vector for decryption
        $decryption_iv = '1234567891011121';
        // Store the decryption key
        $decryption_key = "PwrAdsScript";
        // Use openssl_decrypt() function to decrypt the data
        $decryption = openssl_decrypt($encryption, $ciphering, $decryption_key, $options, $decryption_iv);
        if ($data !== null && $data->source == "google_adsense") {
?>
            <!--   *****SCRIPT TO SHOW ADS INSIDE THE BODY TAG*****   -->
            <div class="top_roght_corner_css">
                <script type="text/javascript">
                    var ads_top_right_corner = '<?php echo esc_js($decryption); ?>';
                    ads_top_right_corner = ads_top_right_corner.replaceAll('&gt;', '>').replaceAll('&quot;', '"').replaceAll('&lt;', '<').replaceAll(/\s\s+/g, ' ').replaceAll("</' + '", "</");
                    var div = document.createElement('div');
                    div.id = 'top-corner';
                    div.innerHTML = ''
                    // console.log(document.body.lastChild)
                    if (document.body.firstChild) {
                        document.body.insertBefore(div, document.body.firstChild);
                        // document.body.lastElementChild(div, document.body.lastElementChild);
                    } else if (document.body.lastChild) {
                        document.body.lastElementChild(div, document.body.lastChild);
                    } else {
                        document.body.appendChild(div);
                        // document.body.appendChild(container);
                    }

                    function removeCornerImage(e) {
                        document.getElementById("top-corner").remove();
                    }
                    document.write(ads_top_right_corner);
                </script>
            </div>
        <?php } elseif ($data !== null && $data->source == "adkernel") {  ?>
            <div class="top_roght_corner_css">
                <script type="text/javascript">
                    var ads_top_right_corner = '<?php echo esc_js($decryption); ?>';
                    ads_top_right_corner = ads_top_right_corner.replaceAll('&gt;', '>').replaceAll('&quot;', '"').replaceAll('&lt;', '<').replaceAll(/\s\s+/g, ' ').replaceAll("</' + '", "</");
                    var div = document.createElement('div');
                    div.id = 'top-corner';
                    div.innerHTML = ''
                    // console.log(document.body.lastChild)
                    if (document.body.firstChild) {
                        document.body.insertBefore(div, document.body.firstChild);
                        // document.body.lastElementChild(div, document.body.lastElementChild);
                    } else if (document.body.lastChild) {
                        document.body.lastElementChild(div, document.body.lastChild);
                    } else {
                        document.body.appendChild(div);
                        // document.body.appendChild(container);
                    }

                    function removeCornerImage(e) {
                        document.getElementById("top-corner").remove();
                    }
                    document.write(ads_top_right_corner);
                </script>
            </div>
            <!--  -->
        <?php }
    } else {
        ?>
        <script type="text/javascript">
            var div = document.createElement('div');
            div.id = 'top-corner';
            div.innerHTML = '<span onclick = "removeCornerImage()" class = "ad_banner_logo"><div class = "ads-text"></div><a href = "https://portal-pwr-ads.com/getautoadurl/<?php echo esc_attr($data->unique_token . "/pwrsrc=" . $_SERVER["SERVER_NAME"] . "/id=" . $data->id . "/adtype=autoad"); ?>"  target="_blank" class = "img_ad2"><img id = "theImg" src = <?php echo esc_url($data->imgurl); ?> ></a><a href = "https://pwr-ads.com/ads-by-pwr-ads/" target = "_blank" class = "img_ad"><img src = "<?php echo plugin_dir_url(dirname(__FILE__)) . 'asst/img/banner-logo.png'; ?>"></a><div class = "ads-text close-icon"><span>X</span></div></span>'
            // console.log(document.body.lastChild)
            if (document.body.firstChild) {
                document.body.insertBefore(div, document.body.firstChild);
                // document.body.lastElementChild(div, document.body.lastElementChild);
            } else if (document.body.lastChild) {
                document.body.lastElementChild(div, document.body.lastChild);
            } else {
                document.body.appendChild(div);
                // document.body.appendChild(container);
            }

            function removeCornerImage(e) {
                document.getElementById("top-corner").remove();
            }
        </script>
<?php }
}

?>