<?php

/*
 * Written by Jeff Jones (jeff@socalbioinformatics.com)
 * Copyright (2016) SoCal Bioinformatics Inc.
 *
 * See LICENSE.txt for the license.
 */
namespace ProxyIO;

class Cli extends Args
{

    protected $msg_pad_len;

    protected $msg_pad_str;

    protected $msg_scp_len;

    protected $msg_scp_str;

    protected $msg_line_n;

    private $msg_line_flushed;

    function __construct(int $width = 100, string $sep = " ")
    {
        parent::__construct();
        $_ENV['PID'] = uniqueId();

        $this->setMessagePad(floor($width * .3), $sep);
        $this->setMessageScope($width);
        $this->msg_line_n = 0;
        $this->msg_line_flushed = false;
    }

    function getScopeLength()
    {
        return $this->msg_scp_len;
    }

    function getMessageLength()
    {
        return $this->msg_pad_len;
    }

    function setMessageScope(int $length = 100, string $str = "-")
    {
        $this->msg_scp_len = $length;
        $this->msg_scp_str = $str;
    }

    function setMessagePad(int $length = 30, string $str = " ")
    {
        $this->msg_pad_len = $length;
        $this->msg_pad_str = $str;
    }

    function getVariableStrLength()
    {
        return $this->msg_pad_len;
    }

    function getValueStrLength()
    {
        return $this->msg_scp_len - $this->msg_pad_len;
    }

    private function getString(string $var, string $str = "")
    {
        $str_left = substr(' ' . $var, 0, $this->msg_pad_len);
        $str_left = str_pad($str_left, $this->msg_pad_len, $this->msg_pad_str, STR_PAD_RIGHT);

        $str_rght = substr(' ' . $str, 0, $this->msg_scp_len - $this->msg_pad_len);
        $str_rght = str_pad($str_rght, $this->msg_scp_len - $this->msg_pad_len, ' ', STR_PAD_RIGHT);
        return $str_left . $str_rght;
    }

    function message(string $var, string $str = "", bool $exit = FALSE)
    {
        $this->msg_line_n ++;
        // $n = str_pad($this->msg_line_n, 3, '0', STR_PAD_LEFT);
        // echo $this->getString($n . ' ' . $var, $str) . PHP_EOL;
        echo $this->getString($var, $str) . PHP_EOL;

        $this->forceLineCount();
        if (is_true($exit))
            exit();
    }

    function header(string $str, bool $exit = FALSE)
    {
        // $str_left = "--- " . $str . str_repeat($this->msg_scp_str, $this->msg_pad_len);
        $str_left = $str . str_repeat($this->msg_scp_str, $this->msg_pad_len);
        $str_rght = str_repeat($this->msg_scp_str, $this->msg_scp_len);
        echo $this->getString($str_left, $str_rght) . PHP_EOL;

        $this->forceLineCount();
        if (is_true($exit))
            exit();
    }

    function flush(string $var, string $str = "", bool $exit = FALSE)
    {
        if (is_false($this->msg_line_flushed))
            $this->msg_line_n ++;

        // $n = str_pad($this->msg_line_n, 3, '0', STR_PAD_LEFT);
        echo "\r" . $this->getString($var, $str);

        flush();
        $this->msg_line_flushed = TRUE;

        if (is_true($exit)) {
            echo PHP_EOL;
            exit();
        }
    }

    function flusheol(string $var, string $str = "", bool $exit = FALSE)
    {
        $this->flush($var, $str, $exit);
        echo PHP_EOL;
        $this->msg_line_n ++;
    }

    function forceLineCount()
    {
        $this->msg_line_flushed = FALSE;
    }

    private function displayHelp()
    {
        if (! preg_grep("/^-{1,2}h/", $_SERVER['argv']))
            return null;

        $incf = get_included_files();

        $con = file_get_contents($incf[0]);

        if (preg_match("/\sNAME[\s\*\r\n\w\-\.\>\<\'\"\:\,\+\(\)\=\|\/]+(?=\*\/)/", $con, $man) != FALSE) {
            $man[0] = preg_replace("/(?<=\n)\s+\*/", "     ", $man[0]);
            $man[0] = preg_replace("/(?<=\n)\s+(?=[A-Z]{4})/", "\n ", $man[0]);
            $man[0] = preg_replace("/\-{2}/", "\t", $man[0]);
            echo PHP_EOL . $man[0] . PHP_EOL . PHP_EOL;
        }

        exit();
    }
}
?>