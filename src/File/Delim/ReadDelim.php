<?php

/*
 * Written by Jeff Jones (jeff@socalbioinformatics.com)
 * Copyright (2016) SoCal Bioinformatics Inc.
 *
 * See LICENSE.txt for the license.
 */
namespace ProxyIO\File\Delim;

use ProxyIO\File\Read;

class ReadDelim
{

    private $table_header;

    private $table_header_n;

    private $table_array;

    private $type_delim;

    private $str_regex_line;

    private $str_regex_split;

    private $Read;

    //
    public function __construct($file_path, $skip_lines = 0, $read_n_lines = true)
    {
        $this->table_header = array();
        $this->table_header_n = 0;
        $this->table_array = array();
        $this->str_regex_split = '/.*\n+/';

        $this->Read = new Read($file_path);

        $this->setRegex($file_path);
        $this->contentsToDataTable($skip_lines, $read_n_lines);
    }

    //
    private function setRegex($file_path)
    {
        if (preg_match("/\.csv$/", $file_path)) {
            $this->str_regex_line = '/(?:^|,)(?=[^"]|(")?)"?((?(1)[^"]*|[^,"]*))"?(?=,|$)/';
        } elseif (preg_match("/\.tsv$/", $file_path)) {
            $this->str_regex_line = '/(?:^|\t)(?=[^"]|(")?)"?((?(1)[^"]*|[^\t"]*))"?(?=\t|$)/';
        } elseif (preg_match("/\.ssv$/", $file_path)) {
            $this->str_regex_line = '/(?:^|\s+)(?=[^"]|(")?)"?((?(1)[^"]*|[^\s+"]*))"?(?=\s+|$)/';
        } else {
            systemError("file type not recognized");
        }
    }

    //
    public function getTableArray()
    {
        return $this->table_array;
    }

    //
    private function contentsToDataTable($skip_lines = 0, $read_n_lines = true)
    {
        $c_header_non = 0;
        $file_contents = $this->Read->getContents();
        preg_match_all($this->str_regex_split, $file_contents, $file_data_lines);
        foreach ($file_data_lines[0] as $n => $data_line) {
            preg_match_all($this->str_regex_line, trim($data_line), $data_line_val);

            if (sizeof($data_line_val) == 0)
                continue;

            if ($n == $skip_lines) {
                $this->table_header_n = sizeof($data_line_val[2]);
                $this->table_header = $data_line_val[2];
                foreach ($this->table_header as $h_i => $h_v) {
                    if ($h_v == "") {
                        $c_header_non ++;
                        $this->table_header[$h_i] = "X_" . str_pad($c_header_non, 2, "0", STR_PAD_LEFT);
                    }
                    $dups = array_keys($this->table_header, $this->table_header[$h_i]);
                    if (sizeof($dups) > 1) {
                        for ($d_i = 1; $d_i < sizeof($dups); $d_i ++) {
                            $this->table_header[$dups[$d_i]] = $this->table_header[$dups[$d_i]] . "_" . str_pad($d_i + 1, 2, "0", STR_PAD_LEFT);
                        }
                    }
                }
            } elseif ($n >= $skip_lines) {
                if (sizeof($data_line_val[2]) < $this->table_header_n)
                    continue;
                if (! is_true($read_n_lines) & $n > $skip_lines + $read_n_lines)
                    break;
                for ($i = 0; $i < $this->table_header_n; $i ++) {
                    $this->table_array[$this->table_header[$i]][] = $data_line_val[2][$i];
                }
            }
        }
    }

    /*
     * 'r' Open for reading only; place the file pointer at the beginning of the file.
     * 'r+' Open for reading and writing; place the file pointer at the beginning of the file.
     * 'w' Open for writing only; place the file pointer at the beginning of the file and truncate the file to zero length. If the file does not exist, attempt to create it.
     * 'w+' Open for reading and writing; place the file pointer at the beginning of the file and truncate the file to zero length. If the file does not exist, attempt to create it.
     * 'a' Open for writing only; place the file pointer at the end of the file. If the file does not exist, attempt to create it.
     * 'a+' Open for reading and writing; place the file pointer at the end of the file. If the file does not exist, attempt to create it.
     * 'x' Create and open for writing only; place the file pointer at the beginning of the file. If the file already exists, the fopen() call will fail by returning FALSE and generating an error of level E_WARNING. If the file does not exist, attempt to create it. This is equivalent to specifying O_EXCL|O_CREAT flags for the underlying open(2) system call.
     * 'x+' Create and open for reading and writing; place the file pointer at the beginning of the file. If the file already exists, the fopen() call will fail by returning FALSE and generating an error of level E_WARNING. If the file does not exist, attempt to create it. This is equivalent to specifying O_EXCL|O_CREAT flags for the underlying open(2) system call.
     */
}

?>