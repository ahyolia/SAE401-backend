<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Accueil Épise</title>
  <link rel="stylesheet" href="../../css/style.css">
  <script defer src="../../js/caroussel.js"></script>
  <!-- Slick CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css"/>
<!-- Slick JS -->
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
</head>
<body>

<section class="hero">
  <div class="hero-overlay"></div>
  <div class="hero-content">
    <h1>L’épicerie solidaire de L’UNC</h1>
    <p>L’épicerie solidaire (EPISE), située à l'université de Nouville, à côté des terrains de sport en descendant les escaliers, est une association qui a pour but d'aider les étudiants dans le besoin. Vous êtes étudiant(e) au campus et vous n'avez pas le temps d'aller en ville pour faire vos courses, inscrivez vous et bénéficiez des dons de l'EPISE !</p>
  </div>

  <div class="actions">
    <div class="action"><a href="#adherent">
      <i class="fas fa-users"></i>
      <p>Devenir adhérent</p>
    </a>
    </div>
    <div class="action"><a href="/dons/ajouter">
      <i class="fas fa-hand-holding-heart"></i>
      <p>Faire un don</p>
       </a>
    </div>
    <div class="action"><a href="/benevoles/ajouter">
      <i class="fas fa-user-plus"></i>
      <p>Devenir bénévole</p>
    </a>
    </div>
    <div class="action"><a href="/apropos">
      <i class="fas fa-map-marker-alt"></i>
      <p>Où nous trouver ?</p>
      </a>
    </div>
  </div>
</section>

<!-- SECTION qui peut adhérer -->
<section class="adherer" id="adherent">
  <h2>QUI PEUT ADHÉRER À L’ÉPISE ?</h2>
  <div class="adherer-cards">
    <div class="card card-unc">
      <p><strong>Les étudiants de l'UNC</strong> peuvent tous bénéficier de l’ÉPISE,<br> en particulier ceux <strong>qui ont un logement <br>au campus universitaire.</strong>.</p>
    </div>
    <div class="card card-prix">
      <p>L’adhésion <strong>sur toute l'année </strong>ne coûte <strong>que 200 F ! <br> Alors fonce t'inscrire <br>pour être bénéficiaire !</strong></p>
    </div>
  </div>
</section>

<!-- SECTION ÉTAPES -->
<section class="etapes">
  <div class="etapes-container">
    <div class="etapes-title">
      <h3>QUELS SONT<br>LES ÉTAPES ?</h3>
    </div>
    <div class="etapes-steps">
      <div class="step">
        <i class="fas fa-edit"></i>
        <p>S’inscrire</p>
      </div>
      <span class="chevron">&gt;</span>
      <div class="step">
        <i class="fas fa-credit-card"></i>
        <p>Payer l’adhésion<br>de 200 F</p>
      </div>
      <span class="chevron">&gt;</span>
      <div class="step">
        <i class="fas fa-shopping-basket"></i>
        <p>Faire ses courses</p>
      </div>
    </div>
  </div>
  <div class="cta-container">
    <a href="/users/register" class="cta-btn">S'inscrire</a>
  </div>
</section>

<!-- SECTION produits -->
<section class="produits-epise">
  <div class="produits-epise-header">
    <h2>Les produits de <span>l’EPISE</span></h2>
  </div>

  <div class="produits-epise-cards">

    <div class="produit-card">
      <div class="produit-icon">
        <i class="fas fa-carrot"></i>
      </div>
      <p>Fruits et légumes</p>
    </div>

    <div class="produit-card">
      <div class="produit-icon">
        <i class="fas fa-bread-slice"></i>
      </div>
      <p>Snacks et biscuits</p>
    </div>

    <div class="produit-card">
      <div class="produit-icon">
        <i class="fas fa-pump-soap"></i>
      </div>
      <p>Hygiène</p>
    </div>
  </div>

<div class="produits-epise-cards">

  <div class="produit-card">
      <div class="produit-icon">
        <i class="fas fa-snowflake"></i>
      </div>
      <p>Produits congelés</p>
    </div>
  

  <div class="produit-card">
      <div class="produit-icon">
        <i class="fas fa-glass-water"></i>
      </div>
      <p>Boissons</p>
    </div>
  

  <div class="produit-card">
      <div class="produit-icon">
        <i class="fas fa-tshirt"></i>
      </div>
      <p>Vêtements</p>
    </div>
  

  <div class="produit-card">
      <div class="produit-icon">
        <i class="fas fa-box"></i>
      </div>
      <p>Conserves et bocaux</p>
    </div>

</div>

</section>


<section class="engagement" id="participer">
  <h2>Je veux <span>m’engager !</span></h2>
  <p>Que vous soyez étudiant ou extérieur à l'UNC, vous pouvez nous aider en devenant bénévole ou en faisant un don : aliments, vêtements, livres, peu importe tant que ça peut aider les étudiants !</p>
  <div class="engagement-cards">
    <div class="engagement-card">
      <img src="../../images/benevole.jpg" alt="Devenir bénévole">
      <div class="card-content">
        <h3>Devenez bénévole</h3>
        <a href="/benevoles/ajouter"><button>Devenir bénévole</button></a>
      </div>
    </div>
    <div class="engagement-card">
      <img src="../../images/donateur.jpg" alt="Faire un don">
      <div class="card-content">
        <h3>Faites un don</h3>
        <a href="/dons/ajouter"><button>Je fais un don</button></a>
      </div>
    </div>
  </div>
</section>

<section class="actus-section">
  <h2>Actualités de l'EPISE</h2>
  <div class="actus-grid">
    
    <!-- Actu principale -->
    <?php if (!empty($mainArticle) && !empty($mainArticle['image'])): ?>
      <div class="main-actu">
        <img src="/images/<?= htmlspecialchars($mainArticle['image']) ?>" alt="Image actu principale">
        <div class="main-actu-text">
          <p class="date"><?= !empty($mainArticle['date_publication']) ? date('d/m/y', strtotime($mainArticle['date_publication'])) : '' ?></p>
          <h3>
            <a href="/articles/lire/<?= urlencode($mainArticle['slug']) ?>">
              <?= htmlspecialchars($mainArticle['titre'] ?? '') ?>
            </a>
          </h3>
          <p class="preview">
            <?= !empty($mainArticle['contenu']) ? htmlspecialchars(mb_substr($mainArticle['contenu'], 0, 100)) . '...' : '<em>Aucun aperçu disponible</em>' ?>
          </p>
        </div>
      </div>
    <?php endif; ?>

    <!-- Liste actus secondaires -->
    <div class="side-actus">
      <?php foreach ($sideArticles as $article): ?>
        <div class="side-actu">
          <img src="/images/<?= htmlspecialchars($article['image']) ?>" alt="Actu">
          <div>
            <h4>
              <a href="/articles/lire/<?= urlencode($article['slug']) ?>">
                <?= htmlspecialchars($article['titre']) ?>
              </a>
            </h4>
            <p class="date"><?= date('d/m/y', strtotime($article['date_publication'])) ?></p>
            <p class="preview">
              <?= htmlspecialchars(mb_substr($article['contenu'], 0, 100)) ?>...
            </p>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
    
  </div>
</section>

<section class="partenaires">
  <h2>Les partenaires</h2>
  <div class="carousel-partenaire">
    <?php foreach ($carrouselPartenaires as $p): ?>
      <div>
        <img src="/images/<?= htmlspecialchars($p['image']) ?>" alt="<?= htmlspecialchars($p['titre']) ?>" style="max-width:120px;max-height:80px;">
      </div>
    <?php endforeach; ?>
  </div>
</section>

<script>
$(document).ready(function(){

  $('.carousel-partenaire').slick({
    centerMode: true,
    centerPadding: '60px',
    slidesToShow: 3,
    autoplay : true,
    autoplaySpeed: 2000,
    dots : false,
    responsive: [
      {
        breakpoint: 768,
        settings: {
          arrows: false,
          centerMode: true,
          centerPadding: '40px',
          slidesToShow: 3
        }
      },
    {
      breakpoint: 480,
      settings: {
        arrows: false,
        centerMode: true,
        centerPadding: '40px',
        slidesToShow: 1
      }
    }
  ]
});
});


</script>
</body>
