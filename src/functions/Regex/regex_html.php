<?php

/*
 * Written by Jeff Jones (jeff@socalbioinformatics.com)
 * Copyright (2016) SoCal Bioinformatics Inc.
 *
 * See LICENSE.txt for the license.
 */
function regex_html($str)
{
    $str = htmlspecialchars_decode($str);
    $str = preg_replace("/\&[a-z]*[\;\.]*/", "", $str);
    $str = preg_replace("/\@/", "_at_", $str);
    $str = preg_replace("/[\.\:\;\,]\s*/", ". ", $str);
    $str = preg_replace("/[\<\>]/", "", $str);
    $str = preg_replace("/\-+/", "-", $str);
    $str = preg_replace("/[\t\s]+/", " ", $str);
    $str = preg_replace("/(\.\s)+/", ". ", $str);
    $str = trim($str);
    
    return ($str);
}

?>
