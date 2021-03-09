<?php

/*
 * Written by Jeff Jones (jeff@socalbioinformatics.com)
 * Copyright (2016) SoCal Bioinformatics Inc.
 *
 * See LICENSE.txt for the license.
 */
namespace ProxyIO;

class Args
{

    protected $array_vars;

    public $Help;

    public function __construct()
    {
        $this->Help = new Help();
        $this->array_vars = array();

        if (key_exists('argv', $_SERVER))
            $this->loadVariables();
    }

    public function resetVariable($variable, $value = NULL)
    {
        if (! is_null($value) & ! is_array($value)) {
            if (! is_bool($value)) {
                $value = trim($value);
            }
        }
        $this->array_vars[$variable] = $value;

        return $this->getVariable($variable);
    }

    public function getVariable($variable, $value = NULL)
    {
        if (! key_exists($variable, $this->array_vars)) {
            # pre load the variable vars
            $this->array_vars[$variable] = $value;
            return $value;
        }

        $value_ui = $this->array_vars[$variable];

        /*
         * return the string or string array from UI selection
         */
        if (is_null($value_ui))
            return null;

        if (is_array($value_ui))
            return $value_ui;

        return trim($value_ui);
    }

    public function getVar($variable, $value = NULL, $desc = NULL)
    {
        if (is_null($value) or $value == '' or $value == FALSE)
            $desc .= " [optional]";
        else
            $desc .= " [default: " . $value . "]";

        $this->Help->setVariable($variable, $desc);

        return $this->getVariable($variable, $value);
    }

    public function listVariables()
    {
        return $this->array_vars;
    }

    private function loadVariables()
    {
        $array_args = $_SERVER['argv'];
        $i = sizeof($array_args);
        for ($n = 1; $n < $i; $n ++) {

            $variable = $array_args[$n];

            if (preg_match("/^\-.+/", $variable)) {
                $variable = preg_replace("/^\-/", "", $variable);
                $n ++;
            }

            $value = TRUE;
            if (key_exists($n, $array_args) && ! preg_match("/^\-/", $array_args[$n]))
                $value = $array_args[$n];
            else
                $n --;

            $this->array_vars[$variable] = $value;
        }
    }
}
?>