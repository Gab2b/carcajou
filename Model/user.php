<?php

function getUser(PDO $pdo, int $id): array | bool
{
    $query = "SELECT * FROM `users` WHERE `id` = :id";
    
    $user = $pdo->prepare($query);
    $user->bindParam(':id', $id);
    $user->execute();

    return $user->fetch();

}

function isUserTaken($pdo, $username, $id) {
    $state = $pdo->prepare("SELECT COUNT(*) AS user_number FROM users WHERE username = :username AND id <> :id");
    $state->bindParam(':username', $username, PDO::PARAM_STR);
    $state->bindParam(':id', $id, PDO::PARAM_INT);
    $state->execute();
    $res = $state->fetch();
    return $res['user_number'] === 0;
}

function validation($input){
    return !empty($input) ? cleanString($input) : null;
}