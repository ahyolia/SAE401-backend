<link rel="stylesheet" href="/css/users/login.css">

<div class="connexion-hero">
    <div class="connexion-avatar">
        <img src="/images/user.png" alt="Avatar">
    </div>
    <div class="connexion-title">Connexion</div>
</div>

<div class="connexion-section">
    <?php if (!empty($msg)): ?>
        <div class="alert" id="alert-msg"><?= $msg ?></div>
        <script>
            setTimeout(function() {
                var alert = document.getElementById('alert-msg');
                if(alert) alert.style.display = 'none';
            }, 1500);
        </script>
    <?php endif; ?>

    <form method="POST" action="/users/login">
        <label for="login">Nom d'utilisateur ou adresse mail :</label>
        <input type="text" id="login" name="login" required>
        <label for="password">Mot de passe :</label>
        <div style="display: flex; flex-direction: column; align-items: center;">
            <input type="password" id="password" name="password" required style="width: 100%;">
            <button type="submit" style="width: 60%;">Se connecter</button>
        </div>  </form>
    <div class="connexion-links">
        <a href="/users/register">Créer un compte</a>
        &nbsp;|&nbsp;
        <a href="/users/forgot">Mot de passe oublié ?</a>
    </div>
</div>
