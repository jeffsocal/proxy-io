<?php

/*
 * Written by Jeff Jones (jeff@socalbioinformatics.com)
 * Copyright (2016) SoCal Bioinformatics Inc.
 *
 * See LICENSE.txt for the license.
 */
function regex_date($str)
{
    $dY = '[1-2][0-9]{3}';
    $dy = '[0-9]{2}';
    $dm = '[0-1]{0,1}[0-9]';
    $dd = '[0-3]{0,1}[0-9]';
    // $d = '\d+';
    $s = '[\-\/\s\.\,]+';
    $ml = '(JANUARY|FEBRUARY|MARCH|APRIL|MAY|JUNE|JULY|AUGUST|SEPTEMBER|OCTOBER|NOVEMBER|DECEMBER)';
    $ms = '(JAN|FEB|MAR|APR|MAY|JUN|JULY|AUG|SEPT|OCT|NOV|DEC)';
    $formats = array(
        $dY . $s . $dm . $s . $dd,
        $dd . $s . $dm . $s . $dY,
        $dm . $s . $dd . $s . $dY,
        $dd . $s . $dm . $s . $dy,
        $dm . $s . $dd . $s . $dy,
        $ml . $s . $dd . $s . $dY,
        $ml . $s . $dd . $s . $dy,
        $dd . $s . $ml . $s . $dY,
        $dd . $s . $ml . $s . $dy,
        $ms . $s . $dd . $s . $dY,
        $ms . $s . $dd . $s . $dy,
        $dd . $s . $ms . $s . $dY,
        $dd . $s . $ms . $s . $dy
    );
    
    $dates = array();
    
    foreach ($formats as $format) {
        preg_match_all('/(?<![\d\w])' . $format . '(?![\d\w])/i', $str, $matches);
        if (! is_array($matches) or ! key_exists(0, $matches))
            continue;
        
        $dates = array_merge($dates, $matches[0]);
    }
    
    if (sizeof($dates) == 0)
        return false;
    
    $dates = array_values(array_unique($dates));
    
    foreach ($dates as $n => $date) {
        $dates[$n] = date("Y-m-d", strtotime(preg_replace("/\-+/", "/", $date)));
    }
        
    rsort($dates);
    
    return $dates;
}

?>
