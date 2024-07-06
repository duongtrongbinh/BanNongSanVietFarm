<?php
function ShowError($errors, $name)
{
    if ($errors->has($name)) {
        return '<div>
                        <span style="color: red;">' . $errors->first($name) . '</span>
                </div>';
    }
    return '';
}
?>
