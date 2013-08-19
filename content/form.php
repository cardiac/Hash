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