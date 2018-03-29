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

function uniqueId()
{
    $str_id = date('is');
    for ($x = 0; $x <= 2; $x ++) {
        $str_id .= numberToAlpha(rand(0, 25));
    }
    return $str_id;
}

function uniqueAlphaNumId($n = 5)
{
    $array_n[] = date('d');
    $array_n[] = date('H');
    $array_n[] = date('i');
    $array_n[] = date('s');
    $array_n[] = rand(0, 25);
    
    $str_id = "";
    for ($x = 0; $x < 5; $x ++) {
        $str_id .= numberToAlpha($array_n[$x]);
    }
    for ($x = 5; $x < $n; $x ++) {
        $coin = rand(0, 1);
        if ($coin == 1) {
            $str_id .= numberToAlpha(rand(0, 25));
        } else {
            $str_id .= rand(0, 9);
        }
    }
    
    return $str_id;
}

function is_cli()
{
    if (empty($_SERVER['REMOTE_ADDR']) and ! isset($_SERVER['HTTP_USER_AGENT']) and count($_SERVER['argv']) > 0) {
        return true;
    }
    return false;
}

function localhostProcess($str = false)
{
    
    // linux method to get process information
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