<?php

/*
 * Written by Jeff Jones (jeff@socalbioinformatics.com)
 * Copyright (2016) SoCal Bioinformatics Inc.
 *
 * See LICENSE.txt for the license.
 */

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

?>
