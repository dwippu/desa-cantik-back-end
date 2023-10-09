<?php 

function old_password_is_correct(string $password, ?string &$error = null): bool
{
    $result = auth()->check([
        'email'    => auth()->user()->email,
        'password' => $password,
    ]);

    if( !$result->isOK() ) {
        // Send back the error message
        $error = lang('Auth.errorOldPassword');

        return false;
    }

    return true;
} 