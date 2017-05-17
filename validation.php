<?php
/**
 * Created by PhpStorm.
 * User: Andreas
 * Date: 11-05-2017
 * Time: 18:31
 */

function val($input) {
    htmlspecialchars($input);
    trim($input);
    stripslashes($input);
    return $input;
}

?>