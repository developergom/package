<?php

if (!function_exists('debug')) {

    function debug($data, $exit = true) {
        if (empty($data) && $exit)
            print_error('Data is empty');

        if (is_object($data)) {
            echo '<pre>';
            var_dump($data);
            echo '</pre>';
        } else if (is_array($data)) {
            echo '<pre>';
            print_r($data);
            echo '</pre>';
        } else {
            echo $data;
        }
        if ($exit)
            exit();
    }

}

if (!function_exists('print_error')) {

    function print_error($msg = NULL) {
        echo $msg;
        exit();
    }

}
