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
function table_unique($table_array, $col = false)
{
    if (is_false($col))
        return $table_array;
        
        $keys_all = array_keys($table_array[$col]);
        $keys_keep = array_keys(array_unique($table_array[$col]));
        
        $keys_drop = array_diff($keys_all, $keys_keep);
        foreach ($keys_drop as $key) {
            $table_array = table_droprow($table_array, $key);
        }
        return table_reindex($table_array);
}
?>