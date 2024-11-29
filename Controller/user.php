<?php
require "Model/user.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    if (!is_numeric($id)) {
        $errors[] = 'id au mauvais format';
    } else {
        $user = get($pdo, $id);
        if(!is_array($user)) {
            $errors[] = $user;
        }
    }
}

//le bouton de modification a été envoyé/cliqué
if (isset($_POST['edit_button'])) {
    $username = !empty($_POST['username']) ? $_POST['username'] : null;
    $password = !empty($_POST['pass']) ? $_POST['pass'] : null;
    $confirmation = !empty($_POST['confirmation']) ? $_POST['confirmation'] : null;
    $email = !empty($_POST['email']) ? $_POST['email'] : null;
    $enabled = !empty($_POST['enabled']) ? true : false;
    $id = $_GET['id'];
    if (!is_numeric($id)) {
        $errors[] = 'id au mauvais format';
    }

    if (
        !empty($username) &&
        !empty($email)
    ) {
        $username = cleanString($username);
        $email = cleanString($email);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'email invalide';
        }

        $res = _count($pdo, $username, $id);

        if ($res['user_number'] !== 0) {
            $errors[] = 'Le username est déjà utilisé';
        }

        if (empty($errors)) {
            $res = update($pdo, $id, $username, $email, $enabled);
            if(!empty($res)) {
                $errors[] = $res;
            }
        }

        if(
            !empty($password) &&
            !empty($confirmation) &&
            !empty($errors)
        ) {
            $password = cleanString($password);
            $confirmation = cleanString($confirmation);

            if ($confirmation !== $password) {
                $errors[] = 'Le mot de passe et sa confirmation sont différents';
            } else {
                $confirmation = null;
                $password = password_hash($password, PASSWORD_DEFAULT);
                $res  = updatePassword($pdo, $id, $password);
                if(!empty($res)) {
                    $errors[] = $res;
                }
            }

        }
    }
}

if (isset($_POST['valid_button'])) {
    $username = !empty($_POST['username']) ? $_POST['username'] : null;
    $password = !empty($_POST['pass']) ? $_POST['pass'] : null;
    $confirmation = !empty($_POST['confirmation']) ? $_POST['confirmation'] : null;
    $email = !empty($_POST['email']) ? $_POST['email'] : null;
    $enabled = !empty($_POST['enabled']) ? true : false;

    if (
        !empty($username) &&
        !empty($email) &&
        !empty($password) &&
        !empty($confirmation)
    ){
        $username = cleanString($username);
        $email = cleanString($email);
        $password = cleanString($password);
        $confirmation = cleanString($confirmation);

        if ($confirmation !== $password) {
            $errors[] = 'Le mot de passe et sa confirmation sont différents';
        } else {
            $confirmation = null;
            $password = password_hash($password, PASSWORD_DEFAULT);
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'email invalide';
        }



        if (empty($errors)) {

            $res = _count($pdo, $username);

            if ($res['user_number'] !== 0) {
                $errors[] = 'Le username est déjà utilisé';
            }

           if (empty($errors)) {
               create($pdo, $username, $email, $enabled, $password);
           }
        }
    } else {
        $errors[] = 'Tous les champs sont obligatoires';
    }


}

require "View/user.php";