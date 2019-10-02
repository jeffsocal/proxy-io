<?php

/*
 * Written by Jeff Jones (jeff@socalbioinformatics.com)
 * Copyright (2016) SoCal Bioinformatics Inc.
 *
 * See LICENSE.txt for the license.
 */
namespace ProxyIO;

class Help
{

    private $array_vars;

    private $version;

    private $copyright;

    private $description;

    private $usage;

    private $example;

    private $indent;

    private $width;

    private $basename;

    public function __construct()
    {
        $this->indent = 10;
        $this->width = min(80, exec('tput cols'));
        $this->array_vars = [];
        $this->usage = [];
        $this->example = [];
        $incf = get_included_files();
        $this->basename = basename($incf[0], ".php");
    }

    public function setVariable($variable, $description)
    {
        $this->array_vars[] = [
            'v' => "-" . $variable,
            'd' => $description
        ];
    }

    public function setVersion($string)
    {
        $this->version = trim($string);
    }

    public function setCopyright($string)
    {
        $this->copyright = trim($string);
    }

    public function setDescription($string)
    {
        $this->description = explode("--", trim(preg_replace("/\n+/", " ", $string)));
    }

    public function setUsage($string)
    {
        $this->usage[] = $this->basename . ' ' . $string;
    }

    public function setExample($string)
    {
        $this->example[] = $this->basename . ' ' . $string;
    }

    private function prepText($string, $indent = 5)
    {
        return wordwrap($string, $this->width - $indent);
    }

    private function padText($string, $indent = 5)
    {
        return $this->ind($indent) . preg_replace("/\n+/", "\n" . $this->ind($indent), $string);
    }

    private function ind($n = 5)
    {
        return str_repeat(" ", $n);
    }

    public function displayHelp()
    {
        if (! preg_grep("/^-{1,2}h/", $_SERVER['argv']))
            return NULL;
        
        /*
         * version
         */
        echo PHP_EOL;
        $bnl = strlen($this->basename);
        $this->indent = max($this->indent, $bnl + 2);
        echo $this->basename . $this->padText($this->version, $this->indent - $bnl);
        echo PHP_EOL;
        
        /*
         * copyright
         */
        echo $this->padText($this->copyright, $this->indent) . PHP_EOL;
        echo PHP_EOL;
        
        /*
         * description
         */
        if (count($this->description) > 0) {
            echo 'DESCRIPTION' . PHP_EOL;
            foreach ($this->description as $txt) {
                $txt = $this->prepText(trim($txt), $this->indent);
                $txt = $this->padText($txt, $this->indent) . PHP_EOL;
                echo $txt . PHP_EOL;
            }
        }
        
        /*
         * usage
         */
        if (count($this->usage) > 0) {
            echo 'USAGE' . PHP_EOL;
            $txt = array_tostring($this->usage, PHP_EOL, '');
            $txt = $this->prepText($txt, $this->indent);
            echo $this->padText($txt, $this->indent) . PHP_EOL;
            echo PHP_EOL;
        }
        
        /*
         * variables
         */
        if (count($this->array_vars) > 0) {
            echo 'OPTIONS' . PHP_EOL;
            $table = explode(PHP_EOL, table_astext(array_rowtocol($this->array_vars)));
            $table = array_map('trim', $table);
            array_splice($table, 0, 2);
            $txt = array_tostring($table, PHP_EOL, '');
            // $txt = preg_replace("/(\n\s*)+/", "", $txt);
            $txt = $this->prepText($txt, $this->indent);
            $txt = $this->padText($txt, $this->indent) . PHP_EOL;
            $txt = preg_replace("/--/", $this->ind(), $txt);
            echo $txt;
            echo PHP_EOL;
        }
        
        /*
         * example
         */
        if (count($this->example) > 0) {
            echo 'EXAMPLE' . PHP_EOL;
            $txt = array_tostring($this->example, PHP_EOL, '');
            $txt = $this->prepText($txt, $this->indent);
            $txt = $this->padText($txt, $this->indent) . PHP_EOL;
            echo $txt;
            echo PHP_EOL;
        }
        exit();
    }
}
?>