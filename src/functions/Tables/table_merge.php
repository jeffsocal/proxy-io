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
function table_merge(array $table1, array $table2, string $bycol, string $method = 'full')
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

    $new_table_header = array_unique(array_merge(table_header($table1), table_header($table2)));

    $merge_vars = array_unique(array_merge($table1[$bycol], $table2[$bycol]));

    $array1 = table_invert($table1);
    $array2 = table_invert($table2);

    $new_table = [];
    foreach ($merge_vars as $merge_var) {

        $table1_keys = preg_grep("/$merge_var/", $table1[$bycol]);
        $table2_keys = preg_grep("/$merge_var/", $table2[$bycol]);

        $this_t1 = [];
        foreach ($table1_keys as $i => $ee) {
            $row = $array1[$i];
            unset($row[$bycol]);
            $this_t1[] = $row;
        }

        $this_t2 = [];
        foreach ($table2_keys as $i => $ee) {
            $row = $array2[$i];
            unset($row[$bycol]);
            $this_t2[] = $row;
        }

        foreach ($this_t1 as $row_t1) {
            foreach ($this_t2 as $row_t2) {
                $new_table[] = array_merge([
                    $bycol => $merge_var
                ], $row_t1, $row_t2);
            }
        }
    }
    return table_invert($new_table);
}
?>