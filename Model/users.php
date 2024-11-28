<?php

function getAll(PDO $pdo): array
{
    $users = $pdo->prepare('SELECT * FROM users');
    $users->execute();
    return $users->fetchAll();
}

function toggleEnabled(PDO $pdo, int $id): void
{
    $res = $pdo->prepare('UPDATE `users` SET `enabled` = NOT `enabled` WHERE `id` = :id');
    $res->bindParam(':id', $id, PDO::PARAM_INT);    
    $res->execute();
}

function _delete(PDO $pdo, int $id)
{
    try{
        $res = $pdo->prepare('DELETE FROM `users` WHERE `id` = :id');
        $res->bindParam(':id', $id, PDO::PARAM_INT);    
        $res->execute();
        return "User supprimé";
    } catch (PDOException $e){
        return $e->getMessage();
    }
}