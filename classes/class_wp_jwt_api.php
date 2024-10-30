<?php

namespace junglewp_api\jwp_sync;

class jwp_api_keys{

public function jwp_api_sync($activate_0,$client_username_1, $client_password_2) {


if(!empty($activate_0)){
        $activate_0 = 'true';
    }else{
        $activate_0 = 'false';
    }

    if($activate_0 === 'true'){


$jwp_endpoint='https://clients.junglewp.com/wp-json/jwt-auth/v1/token';


$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => $jwp_endpoint,
  CURLOPT_FAILONERROR => true, // Comment if you need to debug
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_POST => 1,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  //CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  //CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS =>"username=".$client_username_1."&password=".$client_password_2,
));

$response = curl_exec($curl);

// curl_close($curl);
// echo $response;

if (curl_errno($curl)) {
    $error_msg = curl_error($curl);
}

curl_close($curl);

if (isset($error_msg)) {
    // Handles cURL error accordingly
    delete_option( 'junglewp_mu_option_api' );
    echo '<div class="notice notice-warning is-dismissible">
          <p><strong>JungleWP Connector:</strong>'.$error_msg.' <strong><a href="'. get_admin_url().'options-general.php?page=junglewp_mu"> Please check your username or password,</a></strong> <a href="https://junglewp.com/contact"> Or reach out to us.</a></p>
         </div>';

     
}else{

//echo $response;   // TODO  Storing the json feed.
$decode= json_decode($response, true); // We needed to decode the Json Object first

$api_call['api_call_0'] = $decode['junglewp_services_keys'];
$api_call['last_update'] = time();

update_option( 'junglewp_mu_option_api', $api_call );

} 


/* WP Ultimo: Adding automatically domain syncing to ServerPilot */
/* if(!defined('WU_SERVER_PILOT')) {
define('WU_SERVER_PILOT', $activate_0);

}else{
    echo '<div class="notice notice-warning is-dismissible">
          <p>You have already defined <a href="https://help.wpultimo.com/en/articles/2636790-getting-started-with-domain-mapping-in-wp-ultimo">domain Mapping</a> settings for WP Ultimo, please remove these settings if you want to use <a href="https://docs.junglewp.com/article/233-getting-started-with-domain-syncing-in-wp-ultimo">JungleWP domain syncing</a>.</p>
         </div>';
} */

// Tells WP Ultimo SP whould sync domains with JungleWP, leave true



/* if(!defined('WU_SERVER_PILOT_CLIENT_ID')) {
define('WU_SERVER_PILOT_CLIENT_ID', $serverpilot_client_id);
} else{
    echo '<div class="notice notice-warning is-dismissible">
          <p>You have already defined <a href="https://help.wpultimo.com/en/articles/2636790-getting-started-with-domain-mapping-in-wp-ultimo">domain Mapping</a> settings for WP Ultimo, please remove these settings if you want to use <a href="https://docs.junglewp.com/article/233-getting-started-with-domain-syncing-in-wp-ultimo">JungleWP domain syncing</a>.</p>
         </div>';
}  */
// Enter your Client ID, obtained in Step 1

/* if(!defined('WU_SERVER_PILOT_API_KEY')) {
define('WU_SERVER_PILOT_API_KEY', $api_key_2);
}else{
    echo '<div class="notice notice-warning is-dismissible">
          <p>You have already defined <a href="https://help.wpultimo.com/en/articles/2636790-getting-started-with-domain-mapping-in-wp-ultimo">domain Mapping</a> settings for WP Ultimo, please remove these settings if you want to use <a href="https://docs.junglewp.com/article/233-getting-started-with-domain-syncing-in-wp-ultimo">JungleWP domain syncing</a>.</p>
         </div>';
} */
// Enter your API Key, obtained in Step 1

/* if(!defined('WU_SERVER_PILOT_APP_ID')) {
define('WU_SERVER_PILOT_APP_ID', $website_id_3);
 }else{
    echo '<div class="notice notice-warning is-dismissible">
          <p>You have already defined <a href="https://help.wpultimo.com/en/articles/2636790-getting-started-with-domain-mapping-in-wp-ultimo">domain Mapping</a> settings for WP Ultimo, please remove these settings if you want to use <a href="https://docs.junglewp.com/article/233-getting-started-with-domain-syncing-in-wp-ultimo">JungleWP domain syncing</a>.</p>
         </div>';
} */
 // Enter the APP ID, obtained in Step 2
 
/* end WP Ultimo */

//}
    }
return;

    }

}
