<?php

// ------------------------------------------------------------------------
if (!function_exists('singular_plural')) {

    function singular_plural($int = 0, $text = NULL) {

        if ((int) $int > 1)
            return (int) $int . nbs() . plural($text);


        return (int) $int . nbs() . $text;
    }

}

// ------------------------------------------------------------------------
if (!function_exists('time_elapsed')) {

    function time_elapsed($time = NULL) {
        $time = strtotime($time);
        $time = time() - $time; // to get the time since that moment

        $tokens = [
            31536000 => 'years',
            2592000 => 'months',
            604800 => 'weeks',
            86400 => 'days',
            3600 => 'hours',
            60 => 'minutes',
            1 => 'seconds'
        ];

        foreach ($tokens as $unit => $text) {
            if ($time < $unit)
                continue;

            $numberOfUnits = floor($time / $unit);
            return $numberOfUnits . nbs() . $text . ' ago';
        }

        return '';
    }

}
// ------------------------------------------------------------------------
if (!function_exists('script_tag')) {

    function script_tag($src = NULL, $index_page = FALSE) {
        $CI =& get_instance();

        $v = '?v=' . random_string('alnum', 7);
        $script = '<script type="text/javascript" ';

        if ($src !== '') {
            if (strpos($src, '://') !== FALSE) {
                $script .= 'src="asset/js/' . $src . '.js' . $v . '" ';
            } elseif ($index_page === TRUE) {
                $script .= 'src="' . $CI->config->site_url('asset/js/' . $src . '.js' . $v) . '" ';
            } else {
                $script .= 'src="' . $CI->config->slash_item('base_url') . 'asset/js/' . $src . '.js' . $v . '" ';
            }
        }
        $script .= ' ></script>';

        return $script;
    }

}
// ------------------------------------------------------------------------
if (!function_exists('form_email')) {

    function form_email($data = '', $value = '', $extra = '') {
        is_array($data) OR $data = array('name' => $data);
        $data['type'] = 'email';
        return form_input($data, $value, $extra);
    }

}
// ------------------------------------------------------------------------
if (!function_exists('form_date')) {

    function form_date($data = '', $value = '', $extra = '') {
        is_array($data) OR $data = array('name' => $data);
        $data['type'] = 'input';
        $extra .= 'data-inputmask="\'alias\': \'yyyy-mm-dd\'" data-mask';
        return form_input($data, $value, $extra);
    }

}

if (!function_exists('clearfix')) {

    function clearfix($num = 1) {
        return str_repeat('<div class="clearfix">' . nbs() . '</div>', $num);
    }

}

if (!function_exists('array_to_object')) {

    function array_to_object($array, $recursive = TRUE) {
        if (!is_array($array))
            return $array;

        $object = new stdClass();
        if (is_array($array) && count($array) > 0) {
            foreach ($array as $name => $value) {
                $name = strtolower(trim($name));
                if (!empty($name))
                    $object->$name = (!$recursive) ? $value : array_to_object($value);
            }
            return $object;
        } else {
            return FALSE;
        }
    }

}

if (!function_exists('object_to_array')) {

    function object_to_array($d) {
        if (is_object($d)) {
            $d = get_object_vars($d);
        }

        if (is_array($d)) {
            return array_map(__FUNCTION__, $d);
        } else {
            return $d;
        }
    }

}

if (!function_exists('json_encode_db')) {

    function json_encode_db($json = '') {
        if (empty($json))
            return;
        $json = json_encode($json);
        $json = addslashes($json);
        //debug($json);
        return $json;
    }

}

if (!function_exists('json_decode_db')) {

    function json_decode_db($json = '') {
        if (empty($json))
            return;

        $json = stripslashes($json);
        $json = json_decode($json);
        $json = object_to_array($json);

        return $json;
    }

}