<?php
/**
 * Plugin Name: JungleWP Ultimo
 * Plugin URI: https://junglewp.com/features/
 * Description: Enables automatic domain syncing with WP Ultimo and JungleWP.
 * Version: 1.4
 * Author: JungleWP Limited
 * Author URI: https://junglewp.com/about/
 *
 * Text Domain: junglewp-mu
 * Domain Path: /languages/
 *
 * @package JungleWP Connector
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
/** Defing global variables */
global $api_feed;
global $api_feed_1;
global $api_update_time;
global $activate_0;
global $client_username_1;
global $client_password_2;
global $api_call;
global $jwp_api;
global $sp_api;
global $sp_id_key;
global $sp_api_key;
global $sp_app_id;
global $aws_jwp_region;
global $aws_jwp_key;
global $aws_jwp_secret;
/**------------------------ */

class JUNGLEWPMU {
	private $junglewp_mu_options;

	public function __construct() {

		// Check if multisite
		if (is_multisite()){
		add_action( 'network_admin_menu', array( $this, 'junglewp_mu_network_add_plugin_page' ) );
		
	    }else{
		add_action( 'admin_menu', array( $this, 'junglewp_mu_add_plugin_page' ) );	
		
	}

		add_action( 'admin_init', array( $this, 'junglewp_mu_page_init' ) );
	}

	public function junglewp_mu_network_add_plugin_page() {

	
		add_submenu_page(
			'settings.php', // Parent element
			'JungleWP Connector', // page_title
			'JungleWP', // menu_title
			'manage_options', // capability
			'junglewp_mu', // menu_slug
               array( $this, 'junglewp_mu_create_admin_page' )
		);
	}

	public function junglewp_mu_add_plugin_page() {

		add_menu_page(
			'JungleWP Connector', // page_title
			'JungleWP', // menu_title
			'manage_options', // capability
			'junglewp_mu', // menu_slug
			array( $this, 'junglewp_mu_create_admin_page' ), // function
			plugins_url('junglewpultimo/assets/admin_icon.png'), // icon_url
			3 // position
		);
	}


	public function junglewp_mu_create_admin_page() {
		$this->junglewp_mu_options = get_option( 'junglewp_mu_option_name' );
		$this->junglewp_api_options = get_option( 'junglewp_mu_option_api' ); ?>

		<div class="wrap">
		<img height="45" src="<?php echo plugin_dir_url( __FILE__ )."assets/logo.png"; ?>">
			<h2>JungleWP Ultimo Create your own Premium Network now!</h2>
			<div class="card" style="background-color:rgba(255,255,255,.97);background-image:url('<?php echo plugin_dir_url( __FILE__ )."assets/wpultimo_bg.png"; ?>'); background-posistion:center; background-repeat:no-repeat; background-size:cover;">
			<p>Configuring automatic domain syncing with JungleWP.com</p>
			<?php settings_errors(); ?>

			<form  method="post" action="<?php echo site_url();?>/wp-admin/options.php">
				<?php
					settings_fields( 'junglewp_mu_option_group' );
					do_settings_sections( 'junglewp-connect-admin' );
					submit_button();
				?>
			</form>
			<?php if(!empty($this->junglewp_api_options['last_update'])){
			echo '<p>last update: '.date('Y-m-d H:i:s',$this->junglewp_api_options['last_update']).'</p>';
			}
			?>
			</div>
		</div>
	<?php }

	public function junglewp_mu_page_init() {
		register_setting(
			'junglewp_mu_option_group', // option_group
			'junglewp_mu_option_name', // option_name
			array( $this, 'junglewp_mu_sanitize' ) // sanitize_callback
		);

		add_settings_section(
			'junglewp_mu_setting_section', // id
			'Settings', // title
			array( $this, 'junglewp_mu_section_info' ), // callback
			'junglewp-connect-admin' // page
		);

		add_settings_field(
			'activate_0', // id
			'Activate', // title
			array( $this, 'activate_0_callback' ), // callback
			'junglewp-connect-admin', // page
			'junglewp_mu_setting_section' // section
		);

		add_settings_field(
			'client_username_1', // id
			'EMAIL ADDRESS', // title
			array( $this, 'client_username_1_callback' ), // callback
			'junglewp-connect-admin', // page
			'junglewp_mu_setting_section' // section
		);

		add_settings_field(
			'client_password_2', // id
			'PASSWORD', // title
			array( $this, 'client_password_2_callback' ), // callback
			'junglewp-connect-admin', // page
			'junglewp_mu_setting_section' // section
		);
	}

	public function junglewp_mu_sanitize($input) {
		$sanitary_values = array();
		if ( isset( $input['activate_0'] ) ) {
			$sanitary_values['activate_0'] = $input['activate_0'];
		}

		 if ( isset( $input['client_username_1'] ) ) {
			$sanitary_values['client_username_1'] = sanitize_text_field( $input['client_username_1'] );
		}

		if ( isset( $input['client_password_2'] ) ) {
			$sanitary_values['client_password_2'] = sanitize_text_field( $input['client_password_2'] );
		} 

		return $sanitary_values;
	}

	public function junglewp_mu_section_info() {
		
	}

	public function activate_0_callback() {
		printf(
			'<input type="checkbox" name="junglewp_mu_option_name[activate_0]" id="activate_0" value="activate_0" %s> <label for="activate_0">Synch domains with JungleWP</label>',
			( isset( $this->junglewp_mu_options['activate_0'] ) && $this->junglewp_mu_options['activate_0'] === 'activate_0' ) ? 'checked' : ''
		);
	}

	 public function client_username_1_callback() {
		printf(
			'<input class="regular-text" type="text" autocomplete="off" name="junglewp_mu_option_name[client_username_1]" id="client_username_1" value="%s">',
			isset( $this->junglewp_mu_options['client_username_1'] ) ? esc_attr( $this->junglewp_mu_options['client_username_1']) : ''
		);
	}

	public function client_password_2_callback() {
		printf(
			'<input class="regular-text" type="password" autocomplete="off" name="junglewp_mu_option_name[client_password_2]" id="client_password_2" value="%s">',
			isset( $this->junglewp_mu_options['client_password_2'] ) ? esc_attr( $this->junglewp_mu_options['client_password_2']) : ''
		);
	}


}
if ( is_admin() )
    $junglewp_mu = new JUNGLEWPMU();


/* 
 * Retrieve WordPress Options
 */

 $junglewp_mu_options = get_option( 'junglewp_mu_option_name'); // Array of All Field Options
 $api_call = get_option( 'junglewp_mu_option_api'); // Array of the API call
 $api_call_1 = get_option( 'junglewp_sp_option_api'); // Array of the SP API call
 // Fixes PHP 7.4 notices
 if(is_array(get_option( 'junglewp_mu_option_name')) && !empty($junglewp_mu_options['activate_0']) ){

 $activate_0 = $junglewp_mu_options['activate_0']; // Activate
 $client_username_1 = $junglewp_mu_options['client_username_1']; // Client username
 $client_password_2 = $junglewp_mu_options['client_password_2']; // Client Password

 if ( $api_call != '' ){
 $api_feed = $api_call['api_call_0'] ;
 $api_update_time = $api_call['last_update'];
 $api_feed_1 = $api_call_1['api_call_1'];
 }

}else{
$activate_0 = $client_username_1 = $client_password_2 = $api_feed = $api_feed_1 = $api_update_time = ""	;
}
 
 /**
 * We check if the user have added their credentials
 */

register_activation_hook( __FILE__, 'junglewp_mu_activation_hook' );

function junglewp_mu_activation_hook() {
    set_transient( 'junglewp-mu-notice-setup', true, 5 );
}

add_action( 'admin_notices', 'junglewp_mu_notice' );

function junglewp_mu_notice(){

	  /* Delete transient, only if the website ID is present. */
			delete_transient( 'junglewp-mu-notice-setup' );



	/* Check transient or Website ID, if available display notice */
	$jwp_options_notice = get_option( 'junglewp_mu_option_name' );

    if( get_transient( 'junglewp-mu-notice-setup' ) || empty($jwp_options_notice['client_username_1']) || empty($jwp_options_notice['client_password_2']) ){
        ?>
        <div class="notice notice-info is-dismissible">
            <p>Thank you for using JungleWP Connector! <strong><a href="<?php echo get_admin_url() ;?>options-general.php?page=junglewp_mu">Please setup your plugin to continue,</a></strong> <a href="https://junglewp.com/contact"> Or reach out to us.</a></p>
			
        </div>
        <?php
    }
}

 // End of the credentials check
 // Start authentication and start retrieving API Keys


 // Enque our scripts

 function junglewp_connect_frontend_scripts(){
	 wp_enqueue_script( 'jwp_update_api_js', plugins_url('junglewpultimo/scripts/js/jwp-update-api.js'), array('jquery'), '', true );
 }

 add_action( 'wp_enqueue_scripts', 'junglewp_connect_frontend_scripts' );
 

// We get API Keys from JungleWP
 require 'classes/class_wp_jwt_api.php';
 use junglewp_api\jwp_sync\jwp_api_keys;

	$jwp_api = new jwp_api_keys();
	if (!get_transient( 'junglewp-mu-notice-setup' )){

	//we store the key
	//$jwp_api->jwp_api_sync($activate_0,$client_username_1, $client_password_2);

	if($api_feed != false){ // TODO Replace by trascient.
		set_transient( 'jwp_api_feed', 'synced'); // Site Transient
	}else{$jwp_api->jwp_api_sync($activate_0,$client_username_1, $client_password_2);
		delete_transient( 'jwp_api_feed');} 
	 
}

// We get API Keys from SP_JungleWP
require 'classes/class_jwp_sp_api.php';
use sp_api\sp_sync\sp_app_id;

    $sp_api = new sp_app_id();
   if (get_transient( 'jwp_api_feed' )){
   if ($api_feed != ''){
	$sp_id_key = $api_feed['serverpilot_client_id'];
	$sp_api_key = $api_feed['serverpilot_api_key'];
	$aws_jwp_region = $api_feed['aws_region'];
	$aws_jwp_key = $api_feed['aws_key'];
	$aws_jwp_secret = $api_feed['aws_secret'];
	//TODO add more keys SES etc...
}
	

   //$sp_api->sp_api_sync($activate_0,$sp_id_key,$sp_api_key);

   if($api_feed_1 != false){ // TODO Replace by transcient.
	set_transient( 'jwp_sp_apifeed', 'synced');
	}else{$sp_api->sp_api_sync($activate_0,$sp_id_key,$sp_api_key);
		delete_transient( 'jwp_sp_apifeed');}
   }

// Search for apps ID

// We get API Keys from SP_JungleWP
require 'classes/class_jwp_search_sp.php';
use search_app_key\app_key\sp_app_key;

    $search_app_key = new sp_app_key();
   if (get_transient( 'jwp_sp_apifeed' )){

if(!empty($activate_0)){	
// TODO Add $site_domain instead of mypods.junglewp.com
$site_domain = $search_app_key->get_host($search_app_key->get_wordpress_url());
$search_path = $search_app_key->array_search_app_id('mypods.junglewp.com', $api_feed_1, array('$'));
$sp_app_id = $api_feed_1['data'][$search_path[2]]['id'];
}

//For debuging
//echo '<div class="notice notice-info is-dismissible"><pre>';
//echo "Array Domain is ".$api_feed_1['data'][$search_path[2]]['domains'][$search_path[4]];
//echo '</pre></div>';


function update_results($api_call,$jwp_api, $sp_api, $activate_0, $client_username_1, $client_password_2, $sp_id_key,$sp_api_key){

	$last_updated = (int)$api_call['last_update'];

	if(is_numeric($last_updated)){
	$current_time = time();
	$update_difference = $current_time - $last_updated;
	}

	if($update_difference > 86400){ // We update every 1 day.
	$jwp_api->jwp_api_sync($activate_0,$client_username_1, $client_password_2);
	$sp_api->sp_api_sync($activate_0,$sp_id_key,$sp_api_key);
	}
// For debugging only
	/* echo '<div class="notice notice-info is-dismissible"><pre>';
	echo '<p>last update: '.date('H:i:s',$update_difference).'</p>';
	echo '</div>'; */
return;
wp_die();
}

if ($api_feed != ''){

// update_results($api_call,$jwp_api, $sp_api, $activate_0, $client_username_1, $client_password_2, $sp_id_key,$sp_api_key);

// We update our API feeds trough AJAX on the Front End
add_action('wp_ajax_update_results', function() { global $api_call,$jwp_api, $sp_api, $activate_0, $client_username_1, $client_password_2, $sp_id_key,$sp_api_key; update_results($api_call,$jwp_api, $sp_api, $activate_0, $client_username_1, $client_password_2, $sp_id_key,$sp_api_key); }, 10);
do_action('wp_ajax_update_results',$api_call,$jwp_api, $sp_api, $activate_0, $client_username_1, $client_password_2, $sp_id_key,$sp_api_key);

function update_results_enable_frontend_ajax(){
	?>
	<script>
	var ajaxurl = '<?php echo admin_url( 'admin-ajax.php'); ?>';
	</script> 
	<?php
}

add_action('wp_head','update_results_enable_frontend_ajax' );

}

// For Debuging only
/* if(!empty($activate_0)){
echo '<div class="notice notice-info is-dismissible"><pre>';
echo "Array App key is ".$api_feed_1['data'][$search_path[2]]['id'];
echo '</pre></div>';

echo '<div class="notice notice-info is-dismissible"><pre>';
echo $site_domain;
echo '</pre></div>';
} */

}

// We get API Keys from SP_JungleWP
require 'classes/class_jwp_congig.php';
use jwp_config\wp_config\jwp_class_config;

    $jwp_config = new jwp_class_config();
   if (!get_transient( 'junglewp-mu-notice-setup' )){
  
	if ($api_feed != ''){

	$jwp_config->jwp_ultimo_network($activate_0, $sp_id_key,$sp_api_key, $sp_app_id);
	}
    // For debuging only
	/* if(!empty($activate_0)){
	echo '<div class="notice notice-info is-dismissible"><pre>';
	echo constant('WU_SERVER_PILOT_CLIENT_ID');
	echo '</pre></div>';
	} */
	
   }


