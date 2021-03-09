<?php

/*
 * Written by Jeff Jones (jeff@socalbioinformatics.com)
 * Copyright (2016) SoCal Bioinformatics Inc.
 *
 * See LICENSE.txt for the license.
 */
namespace ProxyIO\File\Delim;

use ProxyIO\File\Write;

class WriteDelim
{

    private $Write;

    private $append;

    public function __construct()
    {
        $this->append = FALSE;
        $this->Write = new Write();
    }

    public function writeCsvFile($file_name, $table_array, $set = 'w')
    {
        if ($set != 'w')
            $this->append = TRUE;

        $this->Write->writeFile($file_name, $this->tableArrayAsFlat($table_array), $set);
    }

    public function writeTsvFile($file_name, $table_array, $set = 'w')
    {
        if ($set != 'w')
            $this->append = TRUE;

        $this->Write->writeFile($file_name, $this->tableArrayAsFlat($table_array, "\t"), $set);
    }

    private function tableArrayAsFlat($table_array, $str_character = ",")
    {
        $content_head = table_header($table_array);

        $str_table = "";

        // HEADER
        $str_row = '';
        foreach ($content_head as $n => $name) {
            $str_row .= "\"$name\"" . $str_character;
        }
        if (is_false($this->append))
            $str_table .= rtrim($str_row, $str_character) . "\n";

        // CONTENTS
        $table_array_length = sizeof($table_array[$content_head[1]]);
        $row_names = array_keys($table_array[$content_head[1]]);
        foreach ($row_names as $i) {
            $str_row = '';

            foreach ($content_head as $n => $name) {

                $contents = "";
                if (key_exists($i, $table_array[$name]))
                    $contents = $table_array[$name][$i];

                $contents = str_replace($str_character, " ", $contents);

                $str_row .= "\"" . $contents . "\"" . $str_character;
            }

            $str_table .= rtrim($str_row, $str_character) . "\n";
        }
        return $str_table;
    }
}
?>