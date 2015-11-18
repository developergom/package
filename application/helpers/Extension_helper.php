<?php

if (!function_exists('singular_plural')) {

    function singular_plural($int = 0, $text = NULL) {

        if ((int) $int > 1) {
            return (int) $int . nbs() . plural($text);
        }
        
        return (int) $int . nbs() . $text;
    }

}

if(!function_exists('datagrid_url')) {
    
    function datagrid_url($page = NULL, $key = NULL, $value = NULL) {
        
        //$current_url = current_url();
        $current_url = http_build_query([$key => $value]);
        debug($current_url);
        
    }
    
}