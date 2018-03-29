<?php

/*
 * Written by Jeff Jones (jeff@socalbioinformatics.com)
 * Copyright (2016) SoCal Bioinformatics Inc.
 *
 * See LICENSE.txt for the license.
 */
function is_false($object)
{
    return (is_bool($object) && $object == false);
}

//
function is_true($object)
{
    return (is_bool($object) && $object == true);
}
?>