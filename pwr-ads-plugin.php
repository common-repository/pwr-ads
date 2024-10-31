<?php
/**
 Plugin Name: Pwr-ads
 Plugin URI: https://pwr-ads.com/
 description: Pwr ads allow you to run google ads in your website and manage easily.
 Version: 1.0.0
 Author: Victor
 Author URI: https://pwr-ads.com/about
 */
// IF THIS FILE IS CALLED DIRECTLY, ABORT.
defined('ABSPATH') || die('You are not allowed to access this page');
define('PWR_ADS_PATH', plugin_dir_path(__FILE__)); //LOAD BASIC PATH TO THE PLUGIN.
define('PWR_ADS_URL', plugin_dir_url(__FILE__)); // GET PLUGIN DIR
define('PWRADS_PLUGIN_FILE', __FILE__); // LOAD PLUGIN FILES
define('PWR_ADS_SLUG', 'pwr-ads'); //GEN & GLOBAL SLUG,to STORE OPTIONS IN WP.
define('PWRADS_WEB_URL', 'https://pwr-ads.com/');
define('PWR_ADS_VERSION', '1.0.0');
// REQUIRED FILES INCLUDED
require_once PWR_ADS_PATH . "admin/inc/menu.php"; // ADMIN MENUS
//require_once PWR_ADS_PATH."admin/inc/metaboxes.php"; // METABOXES PAGE/POST
require_once PWR_ADS_PATH . "admin/inc/db.php"; // ACTIVATION/DEACTIVATION HOOK
require_once PWR_ADS_PATH . "admin/assests/js/ajax.php"; //STOP PAGE LOAD ON FORM SUB
//require_once PWR_ADS_PATH."admin/inc/location-find.php"; // GEO LOCATION
require_once PWR_ADS_PATH . "frontend/function.php";
//include PLUGIN_PATH."inc/cus_post_types.php";
// ADMIN CSS and JS INCLUDED
add_action('admin_enqueue_scripts', 'pwrds_admin_enqueue_scripts');
function pwrds_admin_enqueue_scripts() {
    wp_enqueue_style('pwrads_dev_plugin', PWR_ADS_URL . "admin/assests/css/styles.css");
}
// FRONTED CSS and JS INCLUDED
add_action('wp_enqueue_scripts', 'pwrds_wp_enqueue_scripts');
function pwrds_wp_enqueue_scripts() {
    wp_enqueue_style('pwrads_dev_plugin', PWR_ADS_URL . "frontend/asst/css/my_fronted.css");
    wp_enqueue_style('pwrads_dev_plugin_ads', PWR_ADS_URL . "frontend/asst/css/script_styles.css");
    wp_enqueue_script('pwrads_dev_script', PWR_ADS_URL . "frontend/asst/js/my_fronted.js", array(), '1.0.0', false);
    wp_enqueue_script('pwrads_dev_script', PWR_ADS_URL . "frontend/asst/js/firebase-messaging-sw.js", array(), false);
    wp_enqueue_script('pwrads_dev_script_jquery_min', PWR_ADS_URL . "frontend/asst/js/jquery.min.js", array(), false);
    wp_enqueue_script('pwrads_dev_script_cookies', PWR_ADS_URL . "frontend/asst/js/cookies.js", array(), false);
    wp_enqueue_script('jquery');
}
add_action('wp_footer', 'adtype_function');
global $sidebar;
function adtype_function() {
    function is_site_admin() {
        return in_array('administrator', wp_get_current_user()->roles);
    }
    global $wpdb;
    $results = $wpdb->get_results("SELECT * FROM wp_pwrads_ads");
    $unique_user_id = "";
    foreach ($results as $row) {
        $unique_user_id = $row->unique_user_id;
    }
    if ($unique_user_id !== '') {
        $url = 'https://portal-pwr-ads.com/adtype/' . $unique_user_id;
        $request = wp_remote_retrieve_body(wp_remote_get($url));
        if (is_wp_error($request)) {
            return false; // Bail early
            
        }
        $data = json_decode($request);
        foreach ($data as $value) {
            if ($value->position == 'header' && $value->status == 1) {
                if ($value->ad_type == 1) {
                    include ('frontend/autoadslayouts/header_temp.php');
                } elseif ($value->ad_type == 2) {
                    include ('frontend/layouts/header_temp.php');
                } elseif ($value->ad_type == 3) {
                    include ('frontend/script_layouts/header_temp.php');
                }
            }
            if ($value->position == 'footer' && $value->status == 1) {
                if ($value->ad_type == 1) {
                    include ('frontend/autoadslayouts/footer_temp.php');
                } elseif ($value->ad_type == 2) {
                    include ('frontend/layouts/footer_temp.php');
                } elseif ($value->ad_type == 3) {
                    include ('frontend/script_layouts/footer_temp.php');
                }
            }
            if ($value->position == 'pop_up' && $value->status == 1) {
                if ($value->ad_type == 1) {
                    include ('frontend/autoadslayouts/pop_up_temp.php');
                } elseif ($value->ad_type == 2) {
                    include ('frontend/layouts/pop_up_temp.php');
                } elseif ($value->ad_type == 3) {
                    include ('frontend/script_layouts/pop_up_temp.php');
                }
            }
            if ($value->position == 'top_right_corner' && $value->status == 1) {
                if ($value->ad_type == 1) {
                    include ('frontend/autoadslayouts/top-right-corner.php');
                } elseif ($value->ad_type == 2) {
                    include ('frontend/layouts/top-right-corner.php');
                } elseif ($value->ad_type == 3) {
                    include ('frontend/script_layouts/top-right-corner.php');
                }
            }
            if ($value->position == 'full_screen_popup' && $value->status == 1) {
                if ($value->ad_type == 1) {
                    include ('frontend/autoadslayouts/screen_pop_up.php');
                } elseif ($value->ad_type == 2) {
                    include ('frontend/layouts/screen_pop_up.php');
                } elseif ($value->ad_type == 3) {
                    include ('frontend/script_layouts/screen_pop_up.php');
                }
            }
            if ($value->position == 'top_right_fixed_position' && $value->status == 1) {
                if ($value->ad_type == 1) {
                    include ('frontend/autoadslayouts/float-top-right-temp.php');
                } elseif ($value->ad_type == 2) {
                    include ('frontend/layouts/float-top-right-temp.php');
                } elseif ($value->ad_type == 3) {
                    include ('frontend/script_layouts/float-top-right-temp.php');
                }
            }
            if ($value->position == 'top_left_fixed_position' && $value->status == 1) {
                if ($value->ad_type == 1) {
                    include ('frontend/autoadslayouts/float-top-left-temp.php');
                } elseif ($value->ad_type == 2) {
                    include ('frontend/layouts/float-top-left-temp.php');
                } elseif ($value->ad_type == 3) {
                    include ('frontend/script_layouts/float-top-left-temp.php');
                }
            }
            if ($value->position == 'bottom_right_fixed_position' && $value->status == 1) {
                if ($value->ad_type == 1) {
                    include ('frontend/autoadslayouts/float-botton-right-temp.php');
                } elseif ($value->ad_type == 2) {
                    include ('frontend/layouts/float-botton-right-temp.php');
                } elseif ($value->ad_type == 3) {
                    include ('frontend/script_layouts/float-botton-right-temp.php');
                }
            }
            if ($value->position == 'bottom_left_fixed_position' && $value->status == 1) {
                if ($value->ad_type == 1) {
                    include ('frontend/autoadslayouts/float_left_temp.php');
                } elseif ($value->ad_type == 2) {
                    include ('frontend/layouts/float_left_temp.php');
                } elseif ($value->ad_type == 3) {
                    include ('frontend/script_layouts/float_left_temp.php');
                }
            }
        }
    } else {
        $autoads = array();
        global $wpdb;
        $default_position = "header,footer,pop_up,top_right_corner,full_screen_popup,top_right_fixed_position,top_left_fixed_position,bottom_right_fixed_position,bottom_left_fixed_position";
        $autoads = explode(',', $default_position);
        foreach ($autoads as $position) {
            if ($position == 'header') {
                include ('frontend/autoadslayouts/header_temp.php');
            } elseif ($position == 'footer') {
                include ('frontend/autoadslayouts/footer_temp.php');
            } elseif ($position == 'pop_up') {
                include ('frontend/autoadslayouts/pop_up_temp.php');
            } elseif ($position == 'top_right_corner') {
                include ('frontend/autoadslayouts/top-right-corner.php');
            } elseif ($position == 'top_right_fixed_position') {
                include ('frontend/autoadslayouts/float-top-right-temp.php');
            } elseif ($position == 'top_left_fixed_position') {
                include ('frontend/autoadslayouts/float-top-left-temp.php');
            } elseif ($position == 'bottom_left_fixed_position') {
                include ('frontend/autoadslayouts/float_left_temp.php');
            } elseif ($position == 'bottom_right_fixed_position') {
                include ('frontend/autoadslayouts/float-botton-right-temp.php');
            }
        }
    }
}
// PWR ADS WIDGET (21-6-2021)
global $wpdb;
$results = $wpdb->get_results("SELECT * FROM wp_pwrads_ads");
$unique_user_id = "";
foreach ($results as $row) {
    $unique_user_id = $row->unique_user_id;
}
if ($unique_user_id !== '') {
    $url = 'https://portal-pwr-ads.com/adtype/' . $unique_user_id;
    $request = wp_remote_retrieve_body(wp_remote_get($url));
    if (is_wp_error($request)) {
        return false; // Bail early
        
    }
    $data = json_decode($request);
    foreach ($data as $value) {
        if ($value->position == 'side_bar' && $value->status == 1) {
            if ($value->ad_type == 1) {
                class Pwrads_Sidebar_Widget extends WP_Widget {
                    public function __construct() {
                        // DEFINE THE CONSRUCTER
                        $options = array('classname' => 'pwrads_sidebar_widget', 'description' => 'Add sidebar ads help of PWR ADS plugin.',);
                        parent::__construct('pwrads_sidebar_widget', 'PWR ADS - Sidebar', $options);
                    }
                    // WIDGET FROM ( FOR THE BACKEND )
                    public function form($instance) {
                        // echo '<p>PWR-ADS sidebar widget ad will display on fronted automatically</p>';
                        esc_html('<p>PWR-ADS sidebar widget ad will display on fronted automatically</p>');
                    }
                    // DISPLAY THE WIDGET
                    public function widget($args, $instance) {
                        $args['before_widget'];
                        $array = array();
                        $urlparts = parse_url(home_url());
                        $website = $urlparts['host'];
                        $api_url = "https://portal-pwr-ads.com/getautoad/side_bar";
                        $request = wp_remote_retrieve_body(wp_remote_get($api_url));
                        $array = array();
                        $position_header = "";
                        $chars = "side_bar,right_sidebar";
                        $array = explode(',', $chars);
                        foreach ($array as $position) {
                            if ($position == 'side_bar' || $position == 'right_sidebar') {
                                $position_header = true;
                            }
                        }
                        if (is_wp_error($request)) {
                            return false; //BAIL EARLY
                            
                        }
                        $data = json_decode($request);
                        if ($position_header == true) {
?>











<?php if ($data !== null) {
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

<div class="side_bar_css">

<script type="text/javascript">

    var ads_side_bar = '<?php echo $decryption; ?>';

    //var div = document.createElement( 'div' );

    var script = document.createElement( 'div' );

    //div.id = 'overlay';

    script.id = 'overlay_header';

    script.innerHTML = ads_side_bar;

    document.write(ads_side_bar);

</script>

</div>

  <?php
                                    } elseif ($data !== null && $data->source == "adkernel") {
                                        //echo $decryption;
                                        //echo esc_attr($decryption);
                                        
?>





<div class="side_bar_css">

<script type="text/javascript">

    var ads_side_bar = '<?php echo $decryption; ?>';

    //var div = document.createElement( 'div' );

    var script = document.createElement( 'div' );

    //div.id = 'overlay';

    script.id = 'overlay_header';

    script.innerHTML = ads_side_bar;

    document.write(ads_side_bar);

</script>

</div>

<div id="sideBar"></div>















<?php
                                    }
                                } else { ?>











  <div id="side_image" class="pwr_ads_responsive">







    <span onclick="removeSiderImage()" class="ad_banner_logo"><div class="ads-text">Ads by:</div> <a href="https://pwr-ads.com/ads-by-pwr-ads/" target="_blank" class="img_ad"><img src="<?php echo home_url('/wp-content/plugins/pwr-ads-plugin/admin/assests/img/banner-logo.png'); ?>"></a> <a href="https://portal-pwr-ads.com/getautoadurl/<?php echo esc_attr($data->unique_token . "/pwrsrc=" . $website . "/id=" . $data->id . "/adtype=autoad"); ?>" target="_blank" class="img_ad2"><img id="sideImg" src= '<?php echo esc_url($data->imgurl); ?>' ></a><div class="ads-text close-icon"><span>X</span></div></span>







  </div>







  <?php
                                }
                            }
                        }
                        //echo $args['before_title'] . apply_filters( 'widget_title', 'SIDE BAR PWR-ADS' ) . $args['after_title'];
                        // echo $args['after_widget'];
                        esc_attr($args['after_widget']);
                    }
                }
                // REGISTER CUSTOM WIDGET
                function pwr_ads_widget() {
                    register_widget('Pwrads_Sidebar_Widget');
                }
                add_action('widgets_init', 'pwr_ads_widget');
            } elseif ($value->ad_type == 2) {
                class Pwrads_Sidebar_Widget extends WP_Widget {
                    public function __construct() {
                        // DEFINE THE CONSRUCTER
                        $options = array('classname' => 'pwrads_sidebar_widget', 'description' => 'Add sidebar ads help of PWR ADS plugin.',);
                        parent::__construct('pwrads_sidebar_widget', 'PWR ADS - Sidebar', $options);
                    }
                    // WIDGET FROM ( FOR THE BACKEND )
                    public function form($instance) {
                        // echo '<p>PWR-ADS sidebar widget ad will display on fronted automatically</p>';
                        esc_html('<p>PWR-ADS sidebar widget ad will display on fronted automatically</p>');
                    }
                    // DISPLAY THE WIDGET
                    public function widget($args, $instance) {
                        $args['before_widget'];
                        $array = array();
                        $urlparts = parse_url(home_url());
                        $website = $urlparts['host'];
                        $api_url = "https://portal-pwr-ads.com/getad/side_bar";
                        $request = wp_remote_retrieve_body(wp_remote_get($api_url));
                        $array = array();
                        $position_header = "";
                        $chars = "side_bar,right_sidebar";
                        $array = explode(',', $chars);
                        foreach ($array as $position) {
                            if ($position == 'side_bar' || $position == 'right_sidebar') {
                                $position_header = true;
                            }
                        }
                        if (is_wp_error($request)) {
                            return false; //BAIL EARLY
                            
                        }
                        $data = json_decode($request);
                        if ($position_header == true) {
?>







<?php if ($data !== null) { ?>















  <div id="side_image" class="pwr_ads_responsive">







    <span onclick="removeSiderImage()" class="ad_banner_logo"><div class="ads-text">Ads by:</div> <a href="https://pwr-ads.com/ads-by-pwr-ads/" target="_blank" class="img_ad"><img src="<?php echo home_url('/wp-content/plugins/pwr-ads-plugin/admin/assests/img/banner-logo.png'); ?>"></a> <a href="https://portal-pwr-ads.com/getadurl/<?php echo esc_attr($data->unique_token . "/pwrsrc=" . $website . "/id=" . $data->id . "/adtype=customad"); ?>" target="_blank" class="img_ad2"><img id="sideImg" src= '<?php echo esc_url($data->imgurl); ?>' ></a><div class="ads-text close-icon"><span>X</span></div></span>







  </div>







  <?php
                            }
                        }
                        //echo $args['before_title'] . apply_filters( 'widget_title', 'SIDE BAR PWR-ADS' ) . $args['after_title'];
                        // echo $args['after_widget'];
                        esc_attr($args['after_widget']);
                    }
                }
                // REGISTER CUSTOM WIDGET
                function pwr_ads_widget() {
                    register_widget('Pwrads_Sidebar_Widget');
                }
                add_action('widgets_init', 'pwr_ads_widget');
            } elseif ($value->ad_type == 3) {
                class Pwrads_Sidebar_Widget extends WP_Widget {
                    public function __construct() {
                        // DEFINE THE CONSRUCTER
                        $options = array('classname' => 'pwrads_sidebar_widget', 'description' => 'Add sidebar ads help of PWR ADS plugin.',);
                        parent::__construct('pwrads_sidebar_widget', 'PWR ADS - Sidebar', $options);
                    }
                    // WIDGET FROM ( FOR THE BACKEND )
                    public function form($instance) {
                        // echo '<p>PWR-ADS sidebar widget ad will display on fronted automatically</p>';
                        esc_html('<p>PWR-ADS sidebar widget ad will display on fronted automatically</p>');
                    }
                    // DISPLAY THE WIDGET
                    public function widget($args, $instance) {
                        $args['before_widget'];
                        $array = array();
                        $urlparts = parse_url(home_url());
                        $website = $urlparts['host'];
                        $url_script = 'https://portal-pwr-ads.com/getadsensescript/side_bar';
                        $request_script = wp_remote_retrieve_body(wp_remote_get($url_script));
                        $array = array();
                        $position_script_side_bar = "";
                        $chars = "side_bar,right_sidebar";
                        $array = explode(',', $chars);
                        foreach ($array as $position_script_side_bar) {
                            if ($position_script_side_bar == 'side_bar' || $position_script_side_bar == 'right_sidebar') {
                                $position_script_side_bar = true;
                            }
                        }
                        if (is_wp_error($request_script)) {
                            return false; // Bail early
                            
                        }
                        $data_script = json_decode($request_script);
                        if ($position_script_side_bar == true) {
                            if ($data_script !== null && $data_script->source == "google_adsense") {
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
                                $decryption = openssl_decrypt($encryption, $ciphering, $decryption_key, $options, $decryption_iv);
?>



<script type="text/javascript">

    var ads_side_bar = '<?php echo $decryption; ?>';

    ads_side_bar = ads_side_bar.replace('ins class="adsbygoogle"', 'ins class="adsbygoogle side_bar_css"');

    //var div = document.createElement( 'div' );

    var script = document.createElement( 'div' );

    //div.id = 'overlay';

    script.id = 'overlay_header';

    script.innerHTML = ads_side_bar;

    document.write(ads_side_bar);

</script>



  <?php
                            } elseif ($data_script !== null && $data_script->source == "adkernel") {
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
                                $decryption = openssl_decrypt($encryption, $ciphering, $decryption_key, $options, $decryption_iv);
                                // echo $decryption;
                                
?>

    <script type="text/javascript">

    var ads_side_bar = '<?php echo $decryption; ?>';

    ads_side_bar = ads_side_bar.replace('ins class="adsbygoogle"', 'ins class="adsbygoogle side_bar_css"');

    //var div = document.createElement( 'div' );

    var script = document.createElement( 'div' );

    //div.id = 'overlay';

    script.id = 'overlay_header';

    script.innerHTML = ads_side_bar;

    document.write(ads_side_bar);

</script>



    <div id="sideBar"></div>



<?php
                            }
                        }
                        //echo $args['before_title'] . apply_filters( 'widget_title', 'SIDE BAR PWR-ADS' ) . $args['after_title'];
                        // echo $args['after_widget'];
                        esc_attr($args['after_widget']);
                    }
                }
                // REGISTER CUSTOM WIDGET
                function pwr_ads_widget() {
                    register_widget('Pwrads_Sidebar_Widget');
                }
                add_action('widgets_init', 'pwr_ads_widget');
            }
        }
    }
} else {
    class Pwrads_Sidebar_Widget extends WP_Widget {
        public function __construct() {
            // DEFINE THE CONSRUCTER
            $options = array('classname' => 'pwrads_sidebar_widget', 'description' => 'Add sidebar ads help of PWR ADS plugin.',);
            parent::__construct('pwrads_sidebar_widget', 'PWR ADS - Sidebar', $options);
        }
        // WIDGET FROM ( FOR THE BACKEND )
        public function form($instance) {
            // echo '<p>PWR-ADS sidebar widget ad will display on fronted automatically</p>';
            esc_html('<p>PWR-ADS sidebar widget ad will display on fronted automatically</p>');
        }
        // DISPLAY THE WIDGET
        public function widget($args, $instance) {
            $args['before_widget'];
            $array = array();
            $urlparts = parse_url(home_url());
            $website = $urlparts['host'];
            $api_url = "https://portal-pwr-ads.com/getautoad/side_bar";
            $request = wp_remote_retrieve_body(wp_remote_get($api_url));
            $array = array();
            $position_header = "";
            $chars = "side_bar,right_sidebar";
            $array = explode(',', $chars);
            foreach ($array as $position) {
                if ($position == 'side_bar' || $position == 'right_sidebar') {
                    $position_header = true;
                }
            }
            if (is_wp_error($request)) {
                return false; //BAIL EARLY
                
            }
            $data = json_decode($request);
            if ($position_header == true) {
?>







<?php if ($data !== null) {
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

<div class="side_bar_css">

<script type="text/javascript">

    var ads_side_bar = '<?php echo $decryption; ?>';

    //var div = document.createElement( 'div' );

    var script = document.createElement( 'div' );

    //div.id = 'overlay';

    script.id = 'overlay_header';

    script.innerHTML = ads_side_bar;

    document.write(ads_side_bar);

</script>

</div>

<div id="sideBar"></div>

  <?php
                        } elseif ($data !== null && $data->source == "adkernel") {
                            //echo $decryption;
                            //echo esc_attr($decryption);
                            
?>



<div class="side_bar_css">

<script type="text/javascript">

    var ads_side_bar = '<?php echo $decryption; ?>';

    //var div = document.createElement( 'div' );

    var script = document.createElement( 'div' );

    //div.id = 'overlay';

    script.id = 'overlay_header';

    script.innerHTML = ads_side_bar;

    document.write(ads_side_bar);

</script>

</div>

<div id="sideBar"></div>

<?php
                        }
                    } else {
?>



  <div id="side_image" class="pwr_ads_responsive">

    <span onclick="removeSiderImage()" class="ad_banner_logo"><div class="ads-text">Ads by:</div> <a href="https://pwr-ads.com/ads-by-pwr-ads/" target="_blank" class="img_ad"><img src="<?php echo home_url('/wp-content/plugins/pwr-ads-plugin/admin/assests/img/banner-logo.png'); ?>"></a> <a href="https://portal-pwr-ads.com/getautoadurl/<?php echo esc_attr($data->unique_token . "/pwrsrc=" . $website . "/id=" . $data->id . "/adtype=autoad"); ?>" target="_blank" class="img_ad2"><img id="sideImg" src= '<?php echo esc_url($data->imgurl); ?>' ></a><div class="ads-text close-icon"><span>X</span></div></span>

  </div>

  <?php
                    }
                }
            }
            //echo $args['before_title'] . apply_filters( 'widget_title', 'SIDE BAR PWR-ADS' ) . $args['after_title'];
            // echo $args['after_widget'];
            esc_attr($args['after_widget']);
        }
    }
    // REGISTER CUSTOM WIDGET
    function pwr_ads_widget() {
        register_widget('Pwrads_Sidebar_Widget');
    }
    add_action('widgets_init', 'pwr_ads_widget');
}
// Start Title //
// DISPALY ADD UNDER THE POST TITLE
function pwr_ads_title_ad($content) {
    $url = "https://portal-pwr-ads.com/getad/post_title";
    $request = wp_remote_retrieve_body(wp_remote_get($url));
    $array = array();
    $position_header = "";
    global $wpdb;
    $results = $wpdb->get_results("SELECT * FROM wp_pwrads_ads");
    foreach ($results as $row) {
        $chars = $row->position;
        $array = explode(',', $chars);
    }
    foreach ($array as $position) {
        if ($position == 'post_title') {
            $position_header_post_title = true;
        }
    }
    if (is_wp_error($request)) {
        return false; //BAIL EARLY
        
    }
    if ($position_header_post_title == true) {
        $data = json_decode($request);
        if (is_single() && 'post' == get_post_type()) {
            $custom_content = '<div id=title_ad_image><span onclick=removeTitleImage() class=ad_banner_logo><div class=ads-text>Ads by:</div> <a href=https://pwr-ads.com/ads-by-pwr-ads/ target=_blank class=img_ad><img src=""></a> <a href= https://portal-pwr-ads.com/getadurl/' . $data->unique_token . '/pwrsrc=' . $website . '/id=' . $data->id . '/adtype=customad target=_blank class=pwr_ads_img_title><img id=sideImg src=<?php if( $data == null ) { echo "https://1000logos.net/wp-content/uploads/2021/04/Facebook-logo.png";} else { echo $data->imgurl; } ?> ></a><div class=ads-text close-icon><span>X</span></div></span></div>';
            $custom_content.= $content;
            return $custom_content;
        } else {
            return $content;
        }
    }
} ?>