<?php

/*
 * Written by Jeff Jones (jeff@socalbioinformatics.com)
 * Copyright (2016) SoCal Bioinformatics Inc.
 *
 * See LICENSE.txt for the license.
 */

/*
 * Converts $title to Title Case, and returns the resultF
 */
function strtotitle($title)
{
    // Our array of 'small words' which shouldn't be capitalised if
    // they aren't the first word. Add your own words to taste.
    $smallwordsarray = array(
        'of',
        'a',
        'the',
        'and',
        'an',
        'or',
        'nor',
        'but',
        'is',
        'if',
        'then',
        'else',
        'when',
        'at',
        'from',
        'by',
        'on',
        'off',
        'for',
        'in',
        'out',
        'over',
        'to',
        'into',
        'with'
    );
    // Split the string into separate words
    $words = explode(' ', $title);
    
    foreach ($words as $key => $word) {
        // If this word is the first, or it's not one of our small words, capitalise it
        // with ucwords().
        if ($key == 0 or ! in_array($word, $smallwordsarray))
            $words[$key] = ucwords($word);
    }
    
    // Join the words back into a string
    $newtitle = implode(' ', $words);
    
    return $newtitle;
}
?>