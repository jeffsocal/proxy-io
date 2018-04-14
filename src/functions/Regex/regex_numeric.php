<?php

/*
 * Written by Jeff Jones (jeff@socalbioinformatics.com)
 * Copyright (2016) SoCal Bioinformatics Inc.
 *
 * See LICENSE.txt for the license.
 */

/*
 * returns the numerical range, precise to the significant figures
 * desired, for a regular expression search covering that range
 */
function regex_numeric($num, $wdth)
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

/*
 * use in association with numerical_regex to put back
 * the decimal in the original position after moving it
 * to the right to accomidate significant figrues
 */
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

?>
