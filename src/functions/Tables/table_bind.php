<?php

/*
 * Written by Jeff Jones (jeff@socalbioinformatics.com)
 * Copyright (2016) SoCal Bioinformatics Inc.
 *
 * See LICENSE.txt for the license.
 */

/*
 *
 */
function table_bind($table1, $table2)
{
    if (is_false($table1))
        return $table2;
    
    if (is_false($table2))
        return $table1;
    
    $table_len_1 = table_length($table1);
    $table_len_2 = table_length($table2);
    
    if ($table_len_1 == 0)
        return $table2;
    
    if ($table_len_2 == 0)
        return $table1;
    
    $table_header = array_intersect(table_header($table1), table_header($table1));
    $table = array();
    foreach ($table_header as $header) {
        $table[$header] = array_merge($table1[$header], $table2[$header]);
    }
    return $table;
}
?>