<?php

/*
 * Written by Jeff Jones (jeff@socalbioinformatics.com)
 * Copyright (2016) SoCal Bioinformatics Inc.
 *
 * See LICENSE.txt for the license.
 */
function localhostName()
{
    return php_uname('n');
}

function localhostType()
{
    return php_uname('m');
}

function localhostOS()
{
    return php_uname('s');
}

function localhostProcess($str = false)
{
    
    // linux method to get process informatio
    $command = 'ps aux';
    exec($command, $op);
    $table_new = array();
    
    $header = preg_split("/\s+/", $op[0]);
    $length_header = sizeof($header);
    
    for ($p = 1; $p < sizeof($op); $p ++) {
        $row = $rows = preg_split("/\s+/", $op[$p]);
        array_splice($rows, 0, $length_header - 1);
        $row[$length_header - 1] = substr(trim(preg_replace("/\"\,\s\"/", " ", array_tostring($rows)), '"'), 0, 100);
        array_splice($row, $length_header, sizeof($row));
        for ($i = 0; $i < $length_header; $i ++) {
            $table_new[$header[$i]][] = $row[$i];
        }
    }
    
    if (! is_false($str)) {
        $table_len = table_length($table_new);
        for ($i = 0; $i < $table_len; $i ++) {
            if (! preg_match("/$str/", $table_new['COMMAND'][$i])) {
                $table_new = table_droprow($table_new, $i);
            }
        }
        $table_new = table_reindex($table_new);
    }
    
    return $table_new;
}

?>