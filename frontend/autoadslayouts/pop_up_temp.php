<?php



$template_name = 'home-pop-up';

$url = 'https://portal-pwr-ads.com/getautoad/pop_up';

$request = wp_remote_retrieve_body( wp_remote_get ( $url ));



//print_r(json_decode( $request));

if ( is_wp_error( $request ) )

{

return false;

// bail early

}

$data = json_decode( $request );

if ( $data !== null)

{

if(isset($data->source))

        {

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



        					if($data !== null && $data->source == "google_adsense")

        						{


    ?>

<div class="pop_up_css" >

<script type="text/javascript">
var ads_pop_up = '<?php echo esc_js($decryption); ?>';

ads_pop_up = ads_pop_up.replaceAll('&gt;', '>').replaceAll('&quot;','"').replaceAll('&lt;','<').replaceAll(/\s\s+/g, ' ').replaceAll("</' + '","</");
document.write(ads_pop_up);
</script>

</div>

<?php

}

elseif( $data !== null && $data->source == "adkernel" )

{


?>

<script type="text/javascript">
var ads_pop_up = '<?php echo esc_js($decryption); ?>';

ads_pop_up = ads_pop_up.replaceAll('&gt;', '>').replaceAll('&quot;','"').replaceAll('&lt;','<').replaceAll(/\s\s+/g, ' ').replaceAll("</' + '","</");
document.write(ads_pop_up);
</script>
<div id="pop_up"></div>

<script type="text/javascript">

  function PopUp(hideOrshow) {



                    if (hideOrshow == 'hide') document.getElementById('pwrads_pop-wrapper').style.display = "none";

                    else document.getElementById('pwrads_pop-wrapper').removeAttribute('style');





                }



                window.onload = function () {

                    setTimeout(function () {

                        PopUp('show');



                    }, 1000);

                }



                function removepop_upImage(e){

                document.getElementById("pwrads_pop-wrapper").remove(); 

 }

</script>

<?php }

}

else

{ 

?>



<div id="pwrads_pop-wrapper" style='display:none' onclick="removepop_upImage()" ><div id="pwrads_popup"><div class="popup-header"><div class="ads-text-col"><span></span><a href="https://pwr-ads.com/ads-by-pwr-ads/" target="_blank" class="img_ad"><img src="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'asst/img/banner-logo.png'; ?>"></a><input type="submit" class="pwrads_close" name="Close" value="X" onclick="PopUp('hide')"></div></div><div class="content-section"><center><a href="https://portal-pwr-ads.com/getautoadurl/<?php echo esc_attr($data->unique_token."/pwrsrc=".$website."/id=".$data->id."/adtype=autoad");?>" target="_blank" ><img id="popImg" src="<?php echo $data->imgurl;?>" /></center></a></div></div></div>



<script type="text/javascript">function PopUp(hideOrshow) {if (hideOrshow == 'hide') document.getElementById('pwrads_pop-wrapper').style.display = "none";else document.getElementById('pwrads_pop-wrapper').removeAttribute('style');}window.onload = function () {setTimeout(function () {PopUp('show');}, 5000);}



function removepop_upImage(e){ 







document.getElementById("pwrads_pop-wrapper").remove(); 







}



</script>



<?php } 

}

 ?>