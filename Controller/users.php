<?php
require "Model/users.php";

/*
* @var PDO $pdo
*/

if (isset($_GET['action']) && $_GET['action'] === 'toggle_enabled' && isset($_GET['id']) && is_numeric($_GET['id']))
{
    $id = cleanString($_GET['id']);
    toggleEnabled($pdo, $id);
    header('Location: ?component=users');
}
$users = getAll($pdo);

require "View/users.php";