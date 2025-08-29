<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Accueil Épise</title>
  <link rel="stylesheet" href="../../css/style.css">
  <link rel="stylesheet" href="../../css/layout.css">
  <script defer src="../../js/caroussel.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans&family=Poppins:wght@600&display=swap" rel="stylesheet">
</head>
<body>

<?php
$isBackoffice = strpos($_SERVER['REQUEST_URI'], '/backoffice') === 0 
            || strpos($_SERVER['REQUEST_URI'], '/backoffice/benevoles') === 0
            || strpos($_SERVER['REQUEST_URI'], '/backoffice/benevoles/edit') === 0
            || strpos($_SERVER['REQUEST_URI'], '/backoffice/benevoles/delete') === 0
            || strpos($_SERVER['REQUEST_URI'], '/backoffice/connexion') === 0
            || (strpos($_SERVER['REQUEST_URI'], '/benevoles/updateBenevole/') === 0 && preg_match('/^\/benevoles\/updateBenevole\/\d+$/', $_SERVER['REQUEST_URI']) === 1); // Corrigé pour correspondre à /benevoles/updateBenevole/{id}
?>

<?php if (!$isBackoffice): ?>
  <header>
    <div class="header-left" style="display:flex;align-items:center;gap:2em;">
      <a href="/" class="logo">
        <img src="/images/epise_logo.png" alt="Logo de l'ÉPISE" />
      </a>
      <?php if (!empty($_SESSION['user']['prenom'])): ?>
        <span class="nav-user" style="color:#55BDC6;font-weight:600;font-size:1.25em;">
          Bonjour <?= htmlspecialchars($_SESSION['user']['prenom']) ?> !
        </span>
      <?php endif; ?>
    </div>
    <button class="burger" id="burger-btn" aria-label="Menu">
      <i class="fas fa-bars"></i>
    </button>
    <nav id="main-nav" class="layout-nav">
      
      <ul>
        <li><a href="/">Accueil</a></li>
        <li><a href="/catalogue">Magasin</a></li>
        <li><a href="/apropos">À propos</a></li>
        <li><a href="/backoffice">Administrateur</a></li>
        <li>
          <a href="/panier"><i class="fas fa-shopping-cart"></i>
            <span id="cart-count" style="background:#e74c3c;color:#fff;border-radius:50%;padding:2px 7px;margin-left:4px;">0</span>
          </a>
        </li>
        <li>
          <?php if (!empty($_SESSION['user'])): ?>
            <button onclick="window.location.href='/users/account'">Mon compte</button>
          <?php else: ?>
            <button onclick="window.location.href='/users/login'">Connexion</button>
          <?php endif; ?>
        </li>
      </ul>
    </nav>
  </header>
<?php endif; ?>

<?= $content ?? '' ?>

<?php if (!$isBackoffice): ?>
<footer class="epise-footer">
  <div class="epise-footer-inner">
    <div class="epise-footer-wave">
      <svg viewBox="0 0 1440 80" width="100%" height="80" preserveAspectRatio="none">
        <path d="M0,40 Q90,0 180,40 T360,40 T540,40 T720,40 T900,40 T1080,40 T1260,40 T1440,40 V0 H0Z" fill="#61D6E1"/>
      </svg>
    </div>
    <div class="footer-infos">
      <div class="footer-info-col">
        <div class="footer-info-title">Une question&nbsp;?</div>
        <div class="footer-info-text">Nous sommes là pour y répondre</div>
      </div>
      <div class="footer-info-col">
        <div class="footer-info-title">Contactez-nous sur nos réseaux</div>
        <div class="footer-socials">
          <a href="https://www.facebook.com/episenc/?locale=fr_FR" target="_blank" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
          <a href="https://www.instagram.com/epicerie.solidaire.unc/" target="_blank" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
          <a href="https://www.tiktok.com/@tonprofil" target="_blank" aria-label="TikTok"><i class="fab fa-tiktok"></i></a>
        </div>
      </div>
      <div class="footer-info-col">
        <div class="footer-info-title">Ou par téléphone</div>
        <div class="footer-info-text">Du lundi au vendredi de 8h30 à 18h30</div>
        <span class="footer-phone"><i class="fas fa-phone"></i> 72 12 50</span>
      </div>
    </div>
    <div class="footer-links">
      <div class="footer-col">
    <h4>Découvrir</h4>
      <ul>
        <li><a href="/apropos">Notre organisation</a></li>
        <li><a href="/apropos">Notre histoire</a></li>
        <li><a href="/apropos">Nos actions</a></li>
      </ul>
    </div>
    <div class="footer-col">
      <h4>Participer et agir</h4>
      <ul>
        <li><a href="/benevoles/ajouter">Devenir bénévole</a></li>
        <li><a href="/dons/ajouter">Faire un don</a></li>
        <li><a href="/users/register">Devenir mécène</a></li>
      </ul>
    </div>
    <div class="footer-col">
      <h4>Informations</h4>
      <ul>
        <li><a href="/views/mentions_legales">Mentions légales</a></li>
        <li><a href="/views/rgpd">RGPD</a></li>
      </ul>
    </div>
  </div>
</footer>
<?php endif; ?>

<?php if (!empty($_SESSION['user']) && !empty($_SESSION['welcome'])): ?>
  <div class="alert" id="welcome-alert" style="margin:1em;">
    Bienvenue <?= htmlspecialchars($_SESSION['user']['prenom'] ?? '') ?> !
  </div>
  <script>
    setTimeout(function() {
      var alert = document.getElementById('welcome-alert');
      if(alert) alert.style.display = 'none';
    }, 1500);
  </script>
  <?php unset($_SESSION['welcome']); ?>
<?php endif; ?>
</body>