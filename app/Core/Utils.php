<?php

class Utils {
    public static function ifset(&$value, &$ref, $placeholder){;
         if(isset($value)) {
            $ref = $value;
         } else {
            $ref = $placeholder;
        }
    }
}