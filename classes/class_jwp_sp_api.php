<?php

namespace sp_api\sp_sync;

class sp_app_id{

public function sp_api_sync($activate_0,$sp_id_key,$sp_api_key) {


if(!empty($activate_0)){
        $activate_0 = 'true';
    }else{
        $activate_0 = 'false';
    }

    if($activate_0 === 'true'){


$sp_endpoint='https://api.serverpilot.io/v1/apps';
$headers = array(
    'Content-Type: application/json',
    'Authorization: Basic '. base64_encode("$sp_id_key:$sp_api_key")
);


$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,$sp_endpoint);
curl_setopt($ch, CURLOPT_TIMEOUT, 30); //timeout after 30 seconds
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
//Set the headers that we want our cURL client to use.
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
$result=curl_exec ($ch);
$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);   //get status code
curl_close ($ch);

//echo $status_code ;

if ($status_code != '200'){
    delete_option( 'junglewp_sp_option_api' );
    echo '<div class="notice notice-warning is-dismissible">
          <p><strong>JungleWP Connector: </strong>'.$status_code.' <strong><a href="'. get_admin_url().'options-general.php?page=junglewp_mu"> Please check your username or password,</a></strong> <a href="https://junglewp.com/contact"> Or reach out to us.</a></p>
         </div>';

}else{

$decode_sp = json_decode($result, true); // We needed to decode the Json Object first

$api_call_1['api_call_1'] = $decode_sp;
$api_call_1['last_update_sp'] = time();

update_option( 'junglewp_sp_option_api', $api_call_1 );
}

} 
return;

 }

    }
