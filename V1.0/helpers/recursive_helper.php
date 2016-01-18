<?php

if (!function_exists('data_recursive')) {

    function data_recursive($data = [], $parent_name = NULL, $sub_name = NULL, $parent = 0) {
        if (empty($data))
            return;

        $d = [];
        $dat = $data;
        if (!empty($dat)) {
            foreach ($dat as $key => $val) {
                $id = $val[$parent_name];
                $parent_id = $val[$sub_name];
                $parent_id = (empty($parent_id)) ? 0 : $parent_id;

                if ($parent == $parent_id) {
                    $d[$id]['data'] = $val;
                    unset($dat[$key]);
                    $d[$id]['sub'] = data_recursive($dat, $parent_name, $sub_name, $id);
                }
            }
        }
        return $d;
    }

}


if (!function_exists('option_recursive')) {

    function option_recursive($data = [], $value = NULL, $label = NULL, $default_option = NULL, $arr_option = [], $depth = 0) {
        $separator = NULL;
        for ($i = 0; $i < $depth; $i++)
            $separator .= nbs(4);

        if (!empty($default_option)) {
            if (is_array($default_option)) {
                foreach ($default_option as $key => $val)
                    $arr_option[$key] = $val;
            } else {
                $arr_option[0] = $default_option;
            }
        }
        if (!empty($data)) {
            foreach ($data as $val) {
                $d = $val['data'];
                $arr_option[$d[$value]] = $separator . $d[$label];
                if (!empty($val['sub'])) {
                    $newdepth = $depth + 1;
                    $arr_option = option_recursive($val['sub'], $value, $label, NULL, $arr_option, $newdepth);
                }
            }
        }

        return $arr_option;
    }

}

if (!function_exists('datagrid_recursive')) {

    function datagrid_recursive($data = [], $name = NULL, $divider = '___', $tmpdata = [], $depth = 0) {

        $separator = NULL;
        for ($i = 0; $i < $depth; $i++)
            $separator .= $divider;
        
        if (!empty($data)) {
            foreach ($data as $val) {
                $d = $val['data'];
                if (!empty($name))
                    $d[$name] = $separator . $d[$name];
                $d['_divider'] = $separator;
                $d['_depth'] = $depth;
                $tmpdata[] = $d;

                if (!empty($val['sub'])) {
                    $newdepth = $depth + 1;
                    $tmpdata = datagrid_recursive($val['sub'], $name, $divider, $tmpdata, $newdepth);
                }
            }
        }

        return $tmpdata;
    }

}

