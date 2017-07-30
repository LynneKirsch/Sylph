<?php
function coalesce($val1, $val2) {
    if(isset($val1) && !empty($val1)) {
        return $val1;
    }
    return $val2;
}

