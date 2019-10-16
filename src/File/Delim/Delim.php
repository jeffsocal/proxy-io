<?php

/*
 * Written by Jeff Jones (jeff@socalbioinformatics.com)
 * Copyright (2016) SoCal Bioinformatics Inc.
 *
 * See LICENSE.txt for the license.
 */
namespace ProxyIO\File\Delim;

use ProxyIO\File\Read;

class Delim extends WriteDelim
{

    public function __construct()
    {
        parent::__construct();
    }

    //
    public function read(string $file_path, int $skip_lines = 0, $read_n_lines = true)
    {
        $csv = new ReadDelim($file_path, $skip_lines, $read_n_lines);
        return $csv->getTableArray();
    }
}

?>