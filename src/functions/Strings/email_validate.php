<?php

/*
 * Written by Jeff Jones (jeff@socalbioinformatics.com)
 * Copyright (2016) SoCal Bioinformatics Inc.
 *
 * See LICENSE.txt for the license.
 */
function email_validate(string $email)
{
    if (! filter_var($email, FILTER_VALIDATE_EMAIL))
        return false;
    /*
     * clean email input
     */
    $email = filter_var(strtolower($email), FILTER_SANITIZE_EMAIL);
    preg_match("/.+\@/", $email, $email_id);
    $email_sb = str_replace(".", "", $email_id[0]);
    $email = preg_replace("/" . $email_id[0] . "/", $email_sb, $email);
    
    return $email;
}

?>
