<?php

namespace Amarkal\Debug;

class Debug {
    static function print_array( array $arr = array() ) {
        echo '<pre dir="ltr">', print_r($arr, TRUE), '</pre>';
    }
}
