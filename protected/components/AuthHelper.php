<?php
class AuthHelper
{
    public static function can($permission)
    {
        $perms = Yii::app()->session['permissions'] ?? [];

        // normalize permissions
        if (is_string($perms)) {
            $perms = explode(',', $perms);
        }

        return in_array($permission, $perms);
    }
}
