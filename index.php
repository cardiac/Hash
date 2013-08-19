<?php
/*
 * Ryan's Hashing Algorithm
 * Written by Ryan Strug
 * Created on December 2nd, 2012
 * - Generates a variety of hashes based on input.
 * - Generate random alphanumeric, numeric, and symbolic strings.
 * - Can determine the type of hash.
 */

    include_once('hasher.php');
    $hasher = new Hasher();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Ryan's Hashing Algorithm</title>
        <link rel="stylesheet" href="css/default.css" type="text/css" />
    </head>
    <body>
        <div id="head">
            <h1>hash</h1>
        </div>
        <div id="content">
            <?php $hasher->load_form(); ?>
            <table>
                <?php $hasher->load_content(); ?>
            </table>
        </div>
    </body>
</html>