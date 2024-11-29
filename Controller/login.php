<?php

require "Model/login.php";

if (isset($_POST['login_button']))
{
    $username = !empty($_POST['username']) ? cleanString($_POST['username']) : null;
    $passcode = !empty($_POST['passcode']) ? cleanString($_POST['passcode']) : null;

    if (!empty($username) && !empty($passcode))
    {
        $user = getUser($pdo, $username);

/*        if (is_array($user))
*        {
*            $isMatchPasscode = password_verify($passcode, $user['password']);
*        }
*/
        $isMatchPasscode = is_array($user) && password_verify($passcode, $user['password']);

        if ($isMatchPasscode && $user['enabled'])
        {
            $_SESSION['auth'] = true;
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_username'] = $user['username'];


            header('Location: ?component=users');
        }
        elseif(!$user['enabled'] && $isMatchPasscode)
        {
            $errors[] = 'Votre compte est désactivé';
        }
        else
        {
            $errors[] = 'L\'identification a échoué';
        }


    }
}
require "View/login.php";