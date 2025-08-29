<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="/css/backoffice.css">


<div class="container">
<?php if (!empty($bo['msg'])): ?>
    <div class="alert"><?= htmlspecialchars($bo['msg']) ?></div>
    <script>
        setTimeout(function() {
            var alert = document.querySelector('.alert');
            if(alert) alert.style.display = 'none';
        }, 1500);
    </script>
<?php endif; ?>

<body class="bo-login-page">
    <h2>Connexion</h2>
    <p>Connectez-vous pour accéder à l'administration du blog</p>
    <form method="post" action="<?= $_SERVER['REQUEST_URI']?>">
        <label for="login">Login : </label>
        <input type="text" name="log" id="login" required autofocus tabindex="1"/>
        <label for="password">Mot de passe : </label>
        <input type="password" name="pass" id="password" required tabindex="2"/>
        <input type="submit" value="Se connecter" name="valide">
    </form>
    <a href="/" class="btn-accueil">Retour à l'accueil</a>
</div>
</body>