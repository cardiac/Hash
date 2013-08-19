<?php
/*
    Hash
    Copyright (C) 2013 Ryan Strug

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License along
    with this program; if not, write to the Free Software Foundation, Inc.,
    51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
 */

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