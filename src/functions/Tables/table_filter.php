<?php
use ProxyTime\ProgressTimer;

/*
 * Written by Jeff Jones (jeff@socalbioinformatics.com)
 * Copyright (2016) SoCal Bioinformatics Inc.
 *
 * See LICENSE.txt for the license.
 */

/*
 *
 */
function table_filter(array $table1, string $bycol, string $value = NULL)
{
    $table_len_1 = table_length($table1);

    if ($table_len_1 == 0)
        return $table1;

    $drop_rows = [];
    foreach ($table1[$bycol] as $n => $var) {
        if ($var != $value)
            $drop_rows[] = $n;
    }
    
    return table_droprows($table1, $drop_rows);
}
?>