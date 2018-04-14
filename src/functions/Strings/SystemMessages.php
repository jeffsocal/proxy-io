<?php

/*
 * Written by Jeff Jones (jeff@socalbioinformatics.com)
 * Copyright (2016) SoCal Bioinformatics Inc.
 *
 * See LICENSE.txt for the license.
 */
use ProxyIO\File\Log;

function systemError($message)
{
    $sys_display_message = "";
    
    if (isset($GLOBALS['activeLogging']) and $GLOBALS['activeLogging'] == true) {
        $log = new Log();
        $log->addToLog("[error] " . preg_replace("/\n/", ", ", $message));
    }
    
    //
    
    $info = @pathinfo($_SERVER['PATH_TRANSLATED']);
    
    //
    if ($info['filename'] == '')
        $info = @pathinfo($_SERVER['PHP_SELF']);
    
    $message .= "\n-> " . $info['dirname'] . "/" . $info['basename'];
    
    // passthru ( "clear", $out );
    $lineSize = 0;
    $message = explode("\n", $message);
    
    foreach ($message as $line) {
        if ($lineSize < strlen($line))
            $lineSize = strlen($line);
    }
    $sys_display_message .= PHP_EOL . PHP_EOL;
    $sys_display_message .= str_pad("----  ERROR  -", $lineSize + 5, "-") . PHP_EOL;
    $sys_display_message .= "|  " . str_pad(" ", $lineSize, " ") . " |" . PHP_EOL;
    
    foreach ($message as $line) {
        $sys_display_message .= "|  " . str_pad($line, $lineSize, " ") . " |" . PHP_EOL;
    }
    $sys_display_message .= "|  " . str_pad(" ", $lineSize, " ") . " |" . PHP_EOL;
    $sys_display_message .= str_pad("-", $lineSize + 5, "-") . PHP_EOL . PHP_EOL;
    
    if (is_false(is_cli()))
        $sys_display_message = "<PRE>" . $sys_display_message . "</PRE>";
    
    echo $sys_display_message;
    exit();
}

//
function systemMessage($message)
{
    if (isset($GLOBALS['activeLogging']) and $GLOBALS['activeLogging'] == true) {
        $log = new Log();
        $log->addToLog("[warn] " . preg_replace("/\n/", ", ", $message));
    }
    
    if (is_false(is_cli()))
        echo "<PRE>";
    
    //
    $info = @pathinfo($_SERVER['PATH_TRANSLATED']);
    if ($info['filename'] == '')
        $info = @pathinfo($_SERVER['PHP_SELF']);
    echo "\n" . str_pad($info['basename'] . " ", 50, "..") . " $message\n";
    
    //
    if (is_false(is_cli()))
        echo "</PRE>";
}

?>
