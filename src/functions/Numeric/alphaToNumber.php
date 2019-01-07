<?php

/*
 * Written by Jeff Jones (jeff@socalbioinformatics.com)
 * Copyright (2016) SoCal Bioinformatics Inc.
 *
 * See LICENSE.txt for the license.
 */
function alphaToNumber($string)
{
    $string = str_split($string, 1);
    $alpha = range('A', 'Z');
    $value = array_search($string[0], $alpha);
    return ($value);
}

function numberToAlpha($value)
{
    $alpha = range('A', 'Z');
    $value = max(0, preg_replace("/^0*/", "", $value)) % 26;
    return ($alpha[$value]);
}

function numberToAlphaHash($value)
{
    $alpha = array_merge(range('a', 'z'), range(0, 9, 1));
    
    preg_match_all("/\d{2}/", $value, $matches);
    
    $new = '';
    foreach ($matches[0] as $num) {
        $new .= $alpha[max(0, preg_replace("/^0*/", "", $num)) % 36];
    }
    
    // $value = max(0, preg_replace("/^0*/", "", $value)) % 26;
    return ($new);
}

function base26_encode($value)
{
    $b26 = "";
    $alpha = range('a', 'z');
    
    while ($value > 0) {
        $value -= 1;
        $b26 = $alpha[($value % 26)] . $b26;
        
        $value = floor($value / 26);
    }
    return $b26;
}

function base26_decode($hash)
{
    $h = str_split($hash);
    $alpha = range('a', 'z');
    $n = 0;
    for ($i = 0; $i < count($h); $i ++) {
        $w = array_keys($alpha, $h[$i]);
        $p = count($h) - $i - 1;
        $n = $n + ($w[0] + 1) * pow(26, $p);
    }
    return $n;
}

/*
 * simple test
 */

// > php Commandline.php ut/base26_encode -n 1234567
// number ....................... 1234567
// base26 ....................... brfgi
// TIMER ........................ 0s
// > php Commandline.php ut/base26_decode -h brfgi
// hash ......................... brfgi
// integer ...................... 1234567
// TIMER ........................ 0s
// > php Commandline.php ut/base26_encode -n 12345
// number ....................... 12345
// base26 ....................... rfu
// TIMER ........................ 0s
// > php Commandline.php ut/base26_decode -h rfu
// hash ......................... rfu
// integer ...................... 12345
// TIMER ........................ 0s

?>
