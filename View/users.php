<h1>Liste des utilisateurs</h1>
<br>
<div class="mb-3">
    <a class="btn btn-primary" href="index.php?component=user&action=create">+ Nouvel utilisateur</a>
</div>
<br>
<table class="table">
  <thead>
    <tr>
      <th scope="col"><a style="text-decoration: none; color:black" href="index.php?component=users&sortby=id&sens=asc">ID</a></th>
      <th scope="col"><a style="text-decoration: none; color:black" href="index.php?component=users&sortby=username&sens=asc">Username</a></th>
      <th scope="col"><a style="text-decoration: none; color:black" href="index.php?component=users&sortby=email&sens=asc">E-mail</a></th>
      <th scope="col">Actif</th>
      <th scope="col">Actions</th>
    </tr>
    
  </thead>
  <tbody>
    
    <?php  foreach ($users as $user): ?>
        <tr>
            <td><?php echo $user['id']; ?></td>
            <td><?php echo $user['username']; ?></td>
            <td><?php echo $user['email']; ?></td>
            <td>
                <?php if ($user['id'] !== $_SESSION['user_id']):  ?>
                <a href="index.php?component=users&action=toggle_enabled&id=<?php echo $user['id']; ?>">
                    <i
                        class="<?php echo $user['enabled'] ? 'fa-solid fa-circle-check' : 'fa-regular fa-circle-check'; ?> fa-xl"
                        style="<?php echo $user['enabled'] ? 'color: #19b888;' : 'color: #dd2222;' ?>"
                    ></i>
                </a>
                <?php else: ?>
                    <i
                        class="<?php echo $user['enabled'] ? 'fa-solid fa-circle-check' : 'fa-regular fa-circle-check'; ?> fa-xl"
                        style="<?php echo $user['enabled'] ? 'color: #19b888;' : 'color: #dd2222;' ?>">
                    <title>Vous ne pouvez pas supprimer votre compte de cette manière</title></i>
                    
                <?php endif;?>
                
            </td>
            <td>
            <?php if ($user['id'] !== $_SESSION['user_id']) : ?>
                <a href="index.php?component=users&action=delete_user&id=<?php echo $user['id']; ?>" style="text-decoration: none" onclick="return confirm('Voulez vous vraiment suprrimer cet utilisateur ?')">
                    <i class="fa-solid fa-trash-can" style="color : #ef2813;"></i>
                </a>
            <?php endif;?>
            <a href="index.php?component=user&action=edit&id=<?php echo $user['id']; ?>">
                <i class="fa-solid fa-pen-to-square ms-3"></i>
            </a>
            </td>
        </tr>
        
        
    <?php endforeach; ?>

  </tbody>
</table>