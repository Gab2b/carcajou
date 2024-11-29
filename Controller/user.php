<?php

require "Model/user.php";

if (isset($_POST['edit-button'])) {

    $user = getUser($pdo, $_GET['id']);

    $username = validation($_POST['username']);
    $password = validation($_POST['pass']);
    $confirmation = validation($_POST['confirmation']);
    $email = validation($_POST['email']);
    $enabled = !empty($_POST['enabled']) ? true : false;

    $id = $_GET['id'];

    if (!is_numeric($id)) {
        header('Location: ?component=users');
        $errors[] = 'ID au mauvais format';
    }

    if (!empty($username) && !empty($email)){
        $username = cleanString($username);
        $email = cleanString($email);

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'E-mail invalide';
        }

        if (!isUsernameTaken) {
            $errors[] = 'Le username est déjà utilisé';
        }

        if (empty($errors)){
            try{
                $state = $pdo->prepare("UPDATE `users` SET `username` = :username, `email` = :email,  `enabled` = :enabled WHERE id = :id");
                $state->bindParam(':id', $id, PDO::PARAM_INT);
                $state->bindParam(':username', $username);
                $state->bindParam(':email', $email);
                $state->bindParam(':enabled', $enabled, PDO::PARAM_BOOL);
                $state->execute();
            }
            catch (Exception $e) {
                $errors[] = "Erreur de requête {$e->getMessage()}";
            }
        }

        if (
            !empty($password) &&
            !empty($confirmation)
        ){
            $password = cleanString($password);
            $confirmation = cleanString($confirmation);

            if ($confirmation !== $password) {
                $errors[] = 'Le mot de passe et sa confirmation sont différents';
            } else {
                $confirmation = null;
                $password = password_hash($password, PASSWORD_DEFAULT);
                try {
                    $state = $pdo->prepare("UPDATE `users` SET `password` = :password WHERE id = :id");
                    $state->bindParam(':id', $id, PDO::PARAM_INT);
                    $state->bindParam(':password', $password);
                    $state->execute();
                } catch (Exception $e) {
                    $errors[] = "Erreur de requête {$e->getMessage()}";
                }
            }
        }
    }
    
    header('Location: ?component=users');
}


if (isset($_POST['valid_button'])) {
     
    $username = validation($_POST['username']);
    $password = validation($_POST['pass']);
    $confirmation = validation($_POST['confirmation']);
    $email = validation($_POST['email']);
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
                $errors[] = 'E-mail invalide';
            }

            if (empty($errors)) {

                try {
                    $state = $pdo->prepare("SELECT COUNT(*) AS user_number FROM users WHERE username = :username");
                    $state->bindParam(':username', $username, PDO::PARAM_STR);
                    $state->execute();
                    $res = $state->fetch();
                } catch (Exception $e) {
                    $errors[] = "Erreur de verification du username {$e->getMessage()}";
                }

                if ($res['user_number'] !== 0) {
                    $errors[] = 'Le username est déjà utilisé';
                }

                try {
                    $state = $pdo->prepare('INSERT INTO `users` (`username`, `email`, `password`, `enabled`) VALUES (:username, :email, :password, :enabled)');
                    $state->bindParam(':username', $username);
                    $state->bindParam(':email', $email);
                    $state->bindParam(':password', $password);
                    $state->bindParam(':enabled', $enabled, PDO::PARAM_BOOL);
                    $state->execute();
                } catch (Exception $e) {
                    $errors[] = "Erreur à la création du user {$e->getMessage()}";
                }
            }
    } else {
        $errors[] = 'Tous les champs sont obligatoires';
    }

    header('Location: ?component=users');


}


require "View/user.php";