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
function table_coltorow($table_array)
{
    foreach ($table_array as $colName => $dataInColumn) {
        $n = - 1;
        foreach ($dataInColumn as $i => $value) {
            $n ++;
            if (is_array($value))
                $tempTableArray[$n][$colName] = $value;
                else
                    $tempTableArray[$n][$colName] = trim($value);
        }
    }
    
    //
    return $tempTableArray;
}
?>