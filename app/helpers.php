<?php

    function setPermissionValue($val1,$val2) {

         return $val1 == $val2 ? $val1 : "$val1.$val2";
    }

    function getPermissionGroupName($value) {
        $array = explode('.',$value);
         return $array[0];
    }

?>
