<?php
function ShowError($errors, $name)
{
    if ($errors->has($name)) {
        return '<div class="alert alert-danger mt-2 text-muted">
                    <strong>' . $errors->first($name) . '</strong>
                </div>';
    }
    return '';
}
?>
