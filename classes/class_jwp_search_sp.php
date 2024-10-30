<?php

namespace search_app_key\app_key;

class sp_app_key{

    public function array_search_app_id($search_value, $array, $id_path) { 
      
        if(is_array($array) && count($array) > 0) { 
              
            foreach($array as $key => $value) { 
      
                $temp_path = $id_path; 
                  
                // Adding current key to search path 
                array_push($temp_path, $key); 
      
                // Check if this value is an array 
                // with atleast one element 
                if(is_array($value) && count($value) > 0) { 
                    $res_path = self::array_search_app_id( 
                            $search_value, $value, $temp_path); 
      
                    if ($res_path != null) { 
                        return $res_path; 
                    } 
                } 
                else if($value == $search_value) { 
                   // return join(" --> ", $temp_path);  // For debuging
                    return $temp_path; // array of all array keys
                
                } 
            } 
        } 
          
        return null; 
    } 

    public function get_wordpress_url(){

        // We detect f network site
        if (is_multisite()){
        
        switch_to_blog(1);
        $site_url = network_site_url( '/' );
        restore_current_blog();
        
         } else{ //if not a network site
            $site_url = get_bloginfo( 'url' );
         }
        
         return $site_url;
        }
        
        public function get_host($Address) { 
            $parseUrl = parse_url(trim($Address)); 
            return trim($parseUrl['host'] ? $parseUrl['host'] : array_shift(explode('/', $parseUrl['path'], 2))); 
         } 
        

    }
