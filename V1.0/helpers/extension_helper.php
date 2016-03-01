<?php

// ------------------------------------------------------------------------
if (!function_exists('app_name')) {

    function app_name() {
        $ci = & get_instance();
        return $ci->setting->app_name;
    }

}



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
        $etime = time() - $time;

        if ($etime < 1)
            return '0 seconds';

        $a = [365 * 24 * 60 * 60 => 'year',
            30 * 24 * 60 * 60 => 'month',
            24 * 60 * 60 => 'day',
            60 * 60 => 'hour',
            60 => 'minute',
            1 => 'second'
        ];

        $a_plural = ['year' => 'years',
            'month' => 'months',
            'day' => 'days',
            'hour' => 'hours',
            'minute' => 'minutes',
            'second' => 'seconds'
        ];

        foreach ($a as $secs => $str) {
            $d = $etime / $secs;
            if ($d >= 1) {
                $r = round($d);
                return $r . ' ' . ($r > 1 ? $a_plural[$str] : $str) . ' ago';
            }
        }
    }

}
// ------------------------------------------------------------------------
if (!function_exists('script_tag')) {

    function script_tag($src = NULL, $index_page = FALSE) {
        $CI = & get_instance();

        $v = '?v=' . random_string('alnum', 7);
        $script = '<script type="text/javascript" ';

        if ($src !== '') {
            if (strpos($src, '://') !== FALSE) {
                $script .= 'src="assets/scripts/' . $src . '.js' . $v . '" ';
            } elseif ($index_page === TRUE) {
                $script .= 'src="' . $CI->config->site_url(SCRIPT_PATH . $src . '.js' . $v) . '" ';
            } else {
                $script .= 'src="' . $CI->config->slash_item('base_url') . SCRIPT_PATH . $src . '.js' . $v . '" ';
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
// ------------------------------------------------------------------------

if (!function_exists('form_wysiwyg')) {

    function form_wysiwyg($data = '', $value = '', $extra = '') {
        $defaults = [
            'name' => is_array($data) ? NULL : $data,
            'cols' => '40',
            'rows' => '30'
        ];

        if (!is_array($data) OR ! isset($data['value'])) {
            $val = $value;
        } else {
            $val = $data['value'];
            unset($data['value']);
        }

        $extra .= 'id="summernote"';
        return '<textarea ' . _parse_form_attributes($data, $defaults) . _attributes_to_string($extra) . '>'
                . html_escape($val)
                . "</textarea>\n";
    }

}

if (!function_exists('form_icon')) {

    function form_icon($data = '', $value = '', $extra = '') {
        is_array($data) OR $data = array('name' => $data);
        $data['type'] = 'input';
        $extra .= 'data-icon="list-icon-modal"';
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

        $obj = new stdClass;
        foreach ($array as $k => $v) {
            if (strlen($k))
                $obj->{$k} = is_array($v) ? array_to_object($v) : $v;
        }
        return $obj;
    }

}

if (!function_exists('object_to_array')) {

    function object_to_array($d) {
        if (is_object($d))
            $d = get_object_vars($d);

        return is_array($d) ? array_map(__FUNCTION__, $d) : $d;
    }

}

if (!function_exists('json_encode_db')) {

    function json_encode_db($json = '') {
        if (empty($json))
            return;
        $json = json_encode($json);
        $json = addslashes($json);
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

if (!function_exists('find_array')) {

    function find_array($needle, Array $array) {
        $return = [];
        foreach ($array as $row) {
            if (count(array_filter($row, 'is_array')) > 0) {
                find_array($needle, $row);
            } else {
                foreach ($row as $v) {
                    if (stripos($v, $needle) !== FALSE)
                        $return[] = $row;
                }
            }
        }
        return $return;
    }

}

if (!function_exists('rectangle_image')) {

    function rectangle_image($img, $dimension) {

        list($width, $height) = getimagesize($img);

        if ($width < $height) {
            // portrait
            $x_axis = ($width / 2) - ($dimension / 2);
            $y_axis = ($height / 4) - ($dimension / 2);
        } else if ($width > $height) {
            // landscape
            $x_axis = ($width / 4) - ($dimension / 2);
            $y_axis = ($height / 2) - ($dimension / 2);
        } else if ($width == $height) {
            $x_axis = $width;
            $y_axis = $height;
        }

        return [
            //'master_dim' => 'auto',
            'width' => $dimension,
            'height' => $dimension,
            'x_axis' => $x_axis,
            'y_axis' => $y_axis
        ];
    }

}

if (!function_exists('distinct_array')) {

    function distinct_array($array = array()) {
        return (!empty($array) && is_array($array)) ? array_map('unserialize', array_unique(array_map('serialize', $array))) : $array;
    }

}
