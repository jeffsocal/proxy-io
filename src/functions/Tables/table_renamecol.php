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
function table_renamecol(array $table_array, string $old_colname, string $new_colname)
{
    /*
     * quiet exit if COL is not present
     */
    $table_cols = table_header($table_array);

    if (! array_key_exists($old_colname, array_flip($table_cols)))
        return $table_array;

    $table_cols[array_search($old_colname, $table_cols)] = $new_colname;

    return array_combine($table_cols, $table_array);
}
?>