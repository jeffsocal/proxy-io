<?php

/*
 * Written by Jeff Jones (jeff@socalbioinformatics.com)
 * Copyright (2016) SoCal Bioinformatics Inc.
 *
 * See LICENSE.txt for the license.
 */

// calculates n!
function factorial($int)
{
    if ($int < 2)
        return 1;
    for ($f = 2; $int - 1 > 1; $f *= $int --);
    return $f;
}

// use in association with numerical_regex to put back
// the decimal in the original position after moving it
// to the right to accomidate significant fugrues
function replace_decimal($fstr, $str)
{
    if ($fstr == 0)
        return ($str);
    else {
        $rstr = '';
        $pstr = "/(\d|\[.+\]|.d)/";
        preg_match_all($pstr, $str, $mstr);
        for ($x = (sizeof($mstr[0]) - 1); $x >= 0; $x --) {
            $rstr = $mstr[0][$x] . $rstr;
            if (((sizeof($mstr[0])) - $x) == $fstr)
                $rstr = "\." . $rstr;
        }
        return ($rstr);
    }
}

// returns the numerical range, precise to the significant figures
// desired, for a regular expression search covering that range
function numerical_regex($num, $wdth)
{
    $decimal = 0;
    if (strstr($num, ".")) {
        preg_match("/\.+\d*/", $num, $decval);
        $decimal = strlen($decval[0]) - 1;
        if ($decimal != 0) {
            $num = ($num * pow(10, $decimal));
            $wdth = ($wdth * pow(10, $decimal));
        }
    }
    $numLow = $num - $wdth;
    $numHgh = $num + $wdth;
    $lowint = ARRAY();
    for ($l = 0; $l < (strlen($numHgh) - strlen($numLow)); $l ++) {
        $lowint[0][] = '';
    }
    preg_match_all("/\d/", $numLow, $arrlow);
    
    if ((strlen($numHgh) - strlen($numLow)) != 0)
        $arrlow[0] = array_merge($lowint[0], $arrlow[0]);
    
    preg_match_all("/\d/", $numHgh, $arrhgh);
    $number = array_merge($arrlow, $arrhgh);
    $retstrl = "";
    $retstrh = "";
    $numL = sizeof($arrhgh[0]) - 1;
    for ($x = $numL; $x > 0; $x --) {
        $strlnum = "";
        $strhnum = "";
        $remlow = "";
        $remhgh = "";
        for ($b = 0; $b < $x; $b ++) {
            $remlow .= $number[0][$b];
            $remhgh .= $number[1][$b];
        }
        if ($number[0][$x] == 9) {
            $strlnum .= $remlow . '9';
        } else {
            $strlnum .= $remlow . "[" . $number[0][$x] . "-9]";
        }
        
        if ($number[1][$x] == 0) {
            $strhnum .= $remhgh . '0';
        } else {
            $strhnum .= $remhgh . "[0-" . $number[1][$x] . "]";
        }
        
        for ($e = 0; $e < ($numL - $x); $e ++) {
            $strlnum .= "\d";
            $strhnum .= "\d";
        }
        if (($remhgh - $remlow) <= 0) {
            $x = 0;
        } else {
            $retstrl .= str_replace(" ", "", replace_decimal($decimal, $strlnum)) . "|";
            $retstrh = replace_decimal($decimal, $strhnum) . "|" . $retstrh;
        }
    }
    return ("(" . preg_replace("/\|$/", "", $retstrl . $retstrh) . ")");
}

//
function numberToAlpha($value)
{
    $value = preg_replace("/^0*/", "", $value) * 1;
    
    if ($value > 25) {
        $frac = ($value / 25) - floor($value / 25);
        $value = floor($frac * 25);
    }
    $alpha = range('A', 'Z');
    return ($alpha[$value]);
}

//
function alphaToNumber($string)
{
    $string = str_split($string, 1);
    $alpha = range('A', 'Z');
    $value = array_search($string[0], $alpha);
    return ($value);
}

//
function randomString($length = 10, $type = 'naAs')
{
    $chr_n = array();
    $chr_a = array();
    $chr_A = array();
    $chr_o = array();
    
    if (strstr($type, 'n'))
        $chr_n = range(0, 9);
    
    if (strstr($type, 'a'))
        $chr_a = range('a', 'z');
    
    if (strstr($type, 'A'))
        $chr_A = range('A', 'Z');
    
    if (strstr($type, 's'))
        $chr_o = str_split('!@#&');
    
    $chr = array_merge($chr_n, $chr_n, $chr_n, $chr_a, $chr_A, $chr_o, $chr_o, $chr_o);
    $chr = array_merge($chr, $chr);
    
    shuffle($chr);
    $r = array_rand($chr, $length);
    
    $str_rand = array_tostring(array_intersect_key($chr, array_flip($r)), "", "");
    
    return $str_rand;
}

//
function truncate($value, $n_decimals)
{
    $f = pow(10, $n_decimals);
    return floor($value * $f) / $f;
}

?>
