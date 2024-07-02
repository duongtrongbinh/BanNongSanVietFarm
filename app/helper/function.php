<?php
function ShowError($errors, $name)
{
    if ($errors->has($name)) {
        return '<div>
                    <strong>
                        <span style="color: red;">' . $errors->first($name) . '</span>
                    </strong>
                </div>';
    }
    return '';
}
?>
