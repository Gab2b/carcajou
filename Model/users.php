<?php

function getAll(PDO $pdo, string $search = null, string $sortby = null, string $sens = null): array
{
    $query = "SELECT * FROM users";

    if ($search !== null) {
        $query .= ' WHERE id LIKE :search OR username LIKE :search OR email LIKE :search';
    }

    if ($sortby !== null) {
        $query .= " ORDER BY $sortby $sens";
    }

    $res = $pdo->prepare($query);
    
    if ($search !== null) {
        $res->bindValue(':search', "%$search%");
    }

    $res->execute();
    return $res->fetchAll();
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