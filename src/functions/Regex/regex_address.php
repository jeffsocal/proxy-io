<?php

/*
 * Written by Jeff Jones (jeff@socalbioinformatics.com)
 * Copyright (2016) SoCal Bioinformatics Inc.
 *
 * See LICENSE.txt for the license.
 */
function regex_address($str)
{
    $zipcode    = '\b\d{5}(?:-\d{4})?\b';
    $city       = '(?:[A-Z][a-z.-]+[ ]?)+';
    $state      = '[A-Z]{1,2}[\w\s]+';
    $street     = '\d+[ ](?:[A-Za-z0-9.-]+[ ]?)+(?:Avenue|Lane|Road|Boulevard|Drive|Street|Ave|Dr|Rd|Blvd|Ln|St)\.?';
    
    $formats = array(
        '{'.$city.'},[ ](?:{'.$state.'})[ ]{'.$zipcode.'}[\n\r]*{'.$street.'}',
    );
    
    $addresses = array();
    
    foreach ($formats as $format) {
        preg_match_all('/' . $format . '/', $str, $matches);
        if (! is_array($matches) or ! key_exists(0, $matches))
            continue;
        
        $addresses = array_merge($addresses, $matches[0]);
    }
    
    return array_values(array_unique($addresses));
}

?>
