<br>
<h1>Liste des utilisateurs</h1>
<br>
<table class="table">
  <thead>
    <tr>
      <th scope="col">ID</th>
      <th scope="col">Username</th>
      <th scope="col">Actif</th>
      <th scope="col">Actions</th>
    </tr>
    
  </thead>
  <tbody>
    
    <?php  foreach ($users as $user): ?>
        <tr>
            <td><?php echo $user['id']; ?></td>
            <td><?php echo $user['username']; ?></td>
            <td>
                <a href="index.php?component=users&action=toggle_enabled&id=<?php echo $user['id']; ?>">
                    <i
                        class="<?php echo $user['enabled'] ? 'fa-solid fa-circle-check' : 'fa-regular fa-circle-check'; ?> fa-xl"
                        style="<?php echo $user['enabled'] ? 'color: #19b888;' : 'color: #dd2222;' ?>"
                    ></i>
                </a>
            </td>
            <td>
            <a href="index.php?component=users&action=delete_user&id=<?php echo $user['id']; ?>">
                <i class="fa-solid fa-trash-can" style="color : #ef2813;"></i>
            </a>
            <a href="index.php?component=user&action=edit&id=<?php echo $user['id']; ?>">
                <i class="fa-solid fa-pen-to-square"></i>
            </a>
            </td>
        </tr>
        
        
    <?php endforeach; ?>

  </tbody>
</table>