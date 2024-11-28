<br>
<div class="mb-3 d-flex justify-content-start">
    <a class="btn btn-secondary" href="index.php?component=users"><- Retour</a>
</div>
<div class="mb-3 d-flex justify-content-center">
    <h1>Modification de l'utilisateur à l'ID [<?php echo $user['id']?>]</h1>
</div>
<div class="container">
        <?php if(!empty($errors)): ?>
            <?php  foreach ($errors as $error): ?>
                <div class="alert alert-danger" role="alert">
                    <?php  echo $error; ?>
                </div>
            <?php endforeach; ?>
        <?php endif;?>
        <form method="post">
            <br>
            <div class="mb-3">
                <label for="username" class="form-label">Identifiant</label>
                <input type="text" name="username" id="username" class="form-control" value="<?php echo (isset($user['username'])) ? $user['username'] : ''; ?>" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label" >Email</label>
                <input type="email" name="email" id="email" class="form-control" value="<?php echo (isset($user['email'])) ? $user['email'] : ''; ?>" required>
            </div>
            <div class="mb-3">
                <label for="pass" class="form-label">Mot de passe</label>
                <input type="password" name="pass" id="pass" class="form-control" <?php echo isset($_GET['id']) ? null : 'required' ?>>
            </div>
            <div class="mb-3">
                <label for="confirmation" class="form-label">Confirmation du mot de passe</label>
                <input type="password" name="confirmation" id="confirmation" class="form-control" <?php echo isset($_GET['id']) ? null : 'required' ?>>
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="enabled" name="enabled" <?php echo (isset($user['enabled']) && $user['enabled']) ? 'checked' : null ?>>
                <label class="form-check-label" for="enabled">Actif</label>
            </div>
            <div class="mb-3 d-flex justify-content-end">
                <button type="submit" class="btn btn-primary" name="edit-button">Enregistrer</button>
            </div>
        </form>
    </div>