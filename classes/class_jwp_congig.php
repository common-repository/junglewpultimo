<?php

namespace jwp_config\wp_config;

class jwp_class_config{

public function jwp_ultimo_network($activate_0, $sp_id_key, $sp_api_key, $sp_app_id) {


if(!empty($activate_0)){
        $activate_0 = 'true';
    }else{
        $activate_0 = 'false';
    }

    if($activate_0 === 'true'){





/* WP Ultimo: Adding automatically domain syncing to ServerPilot */
if(!defined('WU_SERVER_PILOT')) {
define('WU_SERVER_PILOT', $activate_0);

}else{
    echo '<div class="notice notice-warning is-dismissible">
          <p>You have already defined <a href="https://help.wpultimo.com/en/articles/2636790-getting-started-with-domain-mapping-in-wp-ultimo">domain Mapping</a> settings for WP Ultimo, please remove these settings if you want to use <a href="https://docs.junglewp.com/article/233-getting-started-with-domain-syncing-in-wp-ultimo">JungleWP domain syncing</a>.</p>
         </div>';
} 

// Tells WP Ultimo SP whould sync domains with JungleWP, leave true



if(!defined('WU_SERVER_PILOT_CLIENT_ID')) {
define('WU_SERVER_PILOT_CLIENT_ID', $sp_id_key);
} else{
    echo '<div class="notice notice-warning is-dismissible">
          <p>You have already defined <a href="https://help.wpultimo.com/en/articles/2636790-getting-started-with-domain-mapping-in-wp-ultimo">domain Mapping</a> settings for WP Ultimo, please remove these settings if you want to use <a href="https://docs.junglewp.com/article/233-getting-started-with-domain-syncing-in-wp-ultimo">JungleWP domain syncing</a>.</p>
         </div>';
}
// Enter your Client ID, obtained in Step 1

 if(!defined('WU_SERVER_PILOT_API_KEY')) {
define('WU_SERVER_PILOT_API_KEY', $sp_api_key);
}else{
    echo '<div class="notice notice-warning is-dismissible">
          <p>You have already defined <a href="https://help.wpultimo.com/en/articles/2636790-getting-started-with-domain-mapping-in-wp-ultimo">domain Mapping</a> settings for WP Ultimo, please remove these settings if you want to use <a href="https://docs.junglewp.com/article/233-getting-started-with-domain-syncing-in-wp-ultimo">JungleWP domain syncing</a>.</p>
         </div>';
} 
// Enter your API Key, obtained in Step 1

 if(!defined('WU_SERVER_PILOT_APP_ID')) {
define('WU_SERVER_PILOT_APP_ID', $sp_app_id);
 }else{
    echo '<div class="notice notice-warning is-dismissible">
          <p>You have already defined <a href="https://help.wpultimo.com/en/articles/2636790-getting-started-with-domain-mapping-in-wp-ultimo">domain Mapping</a> settings for WP Ultimo, please remove these settings if you want to use <a href="https://docs.junglewp.com/article/233-getting-started-with-domain-syncing-in-wp-ultimo">JungleWP domain syncing</a>.</p>
         </div>';
} 
 // Enter the APP ID, obtained in Step 2
 
/* end WP Ultimo */

    }
return;

    }

}
