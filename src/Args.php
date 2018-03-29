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

    public function __construct()
    {
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
            
            if (is_array($value))
                return array();
            
            return null;
        }
        
        $value_ui = $this->array_vars[$variable];
        
        if (is_array($value)) {
            $value_ui = array_intersect_key($value, array_flip($value_ui));
        }
        /*
         * return the string or string array from UI selection
         */
        if (is_null($value_ui))
            return null;
        
        return str_replace('*', '', $value_ui);
    }

    public function getVar($variable, $value = NULL)
    {
        return $this->getVariable($variable, $value);
    }

    public function listVariables()
    {
        return array_keys($this->array_vars);
    }

    private function loadVariables()
    {
        $array_args = $_SERVER['argv'];
        $i = sizeof($array_args);
        for ($n = 1; $n < $i; $n ++) {
            if ($n + 1 >= $i)
                continue;
            
            $variable = $array_args[$n];
            $value = $array_args[$n + 1];
            
            if (preg_match("/^\-.+/", $variable) & ! preg_match("/^\-/", $value)) {
                $variable = preg_replace("/^\-/", "", $variable);
                $this->array_vars[$variable] = $value;
                $n ++;
            }
        }
    }
}
?>