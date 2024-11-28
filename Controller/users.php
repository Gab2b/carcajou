<?php
require "Model/users.php";

/*
* @var PDO $pdo
*/

if (isset($_GET['action']) && isset($_GET['id']) && is_numeric($_GET['id']))
{   
    $id = cleanString($_GET['id']);
    switch ($_GET['action'])
    {
        case 'toggle_enabled':
            toggleEnabled($pdo, $id);
            header('Location: ?component=users');
            break;
        
        case 'delete_user':
            $deleted = _delete($pdo, $id);
            if (!empty($deleted)){
                $errors[] = 'Vous ne pouvez pas supprimer votre propre compte';
            }
            else
            {
                header('Location: ?component=users');
            }
            break;
    }
}

$users = getAll($pdo);

require "View/users.php";