<?php

/*
 * Written by Jeff Jones (jeff@socalbioinformatics.com)
 * Copyright (2016) SoCal Bioinformatics Inc.
 *
 * See LICENSE.txt for the license.
 */
function uniqueId()
{
    $str_id = date('is');
    for ($x = 0; $x <= 2; $x ++) {
        $str_id .= numberToAlpha(rand(0, 25));
    }
    return $str_id;
}

?>