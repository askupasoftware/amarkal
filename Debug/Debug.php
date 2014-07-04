<?php

namespace Amarkal\Debug;

class Debug {
	static function print_array( array $arr = array() ) {
		echo '<pre>', print_r($arr, TRUE), '</pre>';
	}
}
