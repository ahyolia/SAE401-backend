<link rel="stylesheet" href="/css/users/edit.css">

<div class="inscription-hero">
    <div class="inscription-avatar">
        <img src="/images/user.png" alt="Avatar">
    </div>
    <div class="inscription-title">Modifier mon profil</div>
</div>

<div class="inscription-section">
    <?php if (!empty($msg)): ?>
        <div class="alert" id="alert-msg"><?= $msg ?></div>
        <script>
            setTimeout(function() {
                var alert = document.getElementById('alert-msg');
                if(alert) alert.style.display = 'none';
            }, 1500);
        </script>
    <?php endif; ?>

    <form method="POST" action="/users/update">
        <label for="prenom">Nom d'utilisateur :</label>
        <input type="text" id="prenom" name="prenom" value="<?= htmlspecialchars($user['prenom'] ?? '') ?>" required>

        <label for="email">Adresse mail :</label>
        <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>

        <label for="password">Nouveau mot de passe (laisser vide pour ne pas changer) :</label>
        <input type="password" id="password" name="password">
        <div style="display: flex; justify-content: center;">
            <button type="submit">Mettre à jour</button>
        </div>
    </form>

    <div class="inscription-links">
        <a href="/">
            <button type="button" class="btn-activation">Retour à l'accueil</button>
        </a>
        <form method="POST" action="/users/logout" style="display:inline;">
            <button type="submit" class="btn-logout">Déconnexion</button>
        </form>
    </div>
</div>
