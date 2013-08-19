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
?>
<form name="input" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
    <table>
        <tr>
            <th>Input:</th>
            <td><input class="input" name="input" type="text" value="<?php echo $this->input; ?>" /></td>
        </tr>
        <tr>
            <th>Length:</th>
            <td><input class="length" name="length" type="text" value="<?php echo $this->length; ?>" /></td>
        </tr>
        <tr>
            <th></th>
            <td><input name="submit" type="submit" /></td>
        </tr>
    </table>
</form>