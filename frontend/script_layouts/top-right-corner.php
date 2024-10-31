<?php

$template_name = 'top-right-corner';

$url_script = 'https://portal-pwr-ads.com/getadsensescript/top_right_corner';

$request_script = wp_remote_retrieve_body(wp_remote_get($url_script));

//print_r(json_decode($request_script));

if ($request_script == "") {
    return false; // Bail early

} else {
    $data_script = json_decode($request_script);

    $encryption = $data_script->script;

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

    $decryption = openssl_decrypt(
        $encryption,
        $ciphering,

        $decryption_key,
        $options,
        $decryption_iv
    );
}

if ($data_script == null && is_site_admin()) {

?>

    <!--   *****SCRIPT TO SHOW ADS INSIDE THE BODY TAG*****   -->

    <script type="text/javascript">
        if (document.body.firstChild) {

            document.body.insertBefore(script, document.body.firstChild);

            // document.body.lastElementChild(script, document.body.lastElementChild);

        } else if (document.body.lastChild) {

            document.body.lastElementChild(script, document.body.lastChild);

        } else {

            document.body.appendChild(script);

            // document.body.appendChild(container);

        }

        function removeCornerImage(e) {

            document.getElementById("top-corner").remove();

        }
    </script>

<?php } elseif ($data_script !== null && $data_script->source == "google_adsense") { ?>

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
<?php } elseif ($data_script !== null && $data_script->source == "adkernel") {
?>
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
<?php }
?>