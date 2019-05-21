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
function print_table($table_array, $n = 10)
{
    echo table_astext($table_array, $n) . PHP_EOL;
}

function table_astext($table_array, $n = 10)
{
    /*
     * constants
     */
    $line_indent = 2;
    $line_space = "";
    $table = array();
    $tableAsText = "";
    for ($in = 0; $in < $line_indent; $in ++) {
        $line_space .= " ";
    }
    
    $table_array_ctr = table_coltorow(table_head($table_array, $n));
    
    //
    foreach ($table_array_ctr as $col) {
        foreach ($col as $field => $value) {
            if (is_array($value))
                $value = sizeof($value);
                if (key_exists($field, $table)) {
                    if (strlen(trim($value)) + $line_indent > $table[$field])
                        $table[$field] = strlen(trim($value)) + $line_indent;
                } else {
                    $table[$field] = strlen(trim($value)) + $line_indent;
                }
        }
    }
    
    foreach ($table as $field => $value) {
        if (is_array($value))
            $value = sizeof($value);
            $titleSize = strlen($field) + $line_indent;
            if ($titleSize > trim($value)) {
                $table[$field] = $titleSize;
            } else {
                $titleSize = trim($value);
            }
            $tableAsText .= str_pad($field, $titleSize, " ");
    }
    
    $tableAsText = rtrim($tableAsText, ",");
    $tableAsText = rtrim($tableAsText, "\t");
    $tableAsText .= PHP_EOL;
    
    //
    foreach ($table as $field => $value) {
        $tableAsText .= str_pad("", $table[$field] - $line_indent, "-") . str_pad("", $line_indent, " ");
    }
    $tableAsText .= PHP_EOL;
    
    //
    foreach ($table_array_ctr as $alt => $col) {
        foreach ($col as $field => $value) {
            if (is_array($value))
                $value = sizeof($value);
                if (preg_match("/^e|E$/", trim($value))) {
                    $tableAsText .= str_pad(trim($value), $table[$field], " ", STR_PAD_RIGHT);
                } elseif (preg_match("/[a-dA-D]|[f-zF-Z]|@|&|#/", trim($value))) {
                    $tableAsText .= str_pad(trim($value), $table[$field], " ", STR_PAD_RIGHT);
                } else {
                    $tableAsText .= str_pad(trim($value) . $line_space, $table[$field], " ", STR_PAD_LEFT);
                }
                $value = trim($value);
        }
        $tableAsText = preg_replace("/[\,|\t]$/", "", $tableAsText) . PHP_EOL;
    }
    
    return $tableAsText;
}
?>