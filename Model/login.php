<?php

function getUser(PDO $pdo, string $username): array | bool
{
    $query = "SELECT * FROM users WHERE username = :username";
    
    $user = $pdo->prepare($query);
    $user->bindParam(':username', $username);
    $user->execute();

    return $user->fetch();

}