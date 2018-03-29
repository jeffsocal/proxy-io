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

    public function __construct()
    {
        $this->Write = new Write();
    }

    public function writeCsvFile($file_name, $table_array, $set = 'w')
    {
        $this->Write->setFileLocationName($file_name);
        $this->Write->setFileContents($this->tableArrayAsFlat($table_array));
        $this->Write->setWriteCommand($set);
        $this->Write->finalWriteFile();
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
        $str_table .= rtrim($str_row, $str_character) . "\n";
        
        // CONTENTS
        $table_array_length = sizeof($table_array[$content_head[1]]);
        $row_names = array_keys($table_array[$content_head[1]]);
        foreach ($row_names as $i) {
            $str_row = '';
            
            foreach ($content_head as $n => $name) {
                $str_row .= "\"" . $table_array[$name][$i] . "\"" . $str_character;
            }
            
            $str_table .= rtrim($str_row, $str_character) . "\n";
        }
        return $str_table;
    }
}
?>