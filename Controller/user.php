<?php

require "Model/user.php";

$user = getUser($pdo, $_GET['id']);

if (isset($_POST['edit-button'])) {
    $username = validation($_POST['username']);
    $password = validation($_POST['username']);
    $confirmation = validation($_POST['username']);
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

require "View/user.php";