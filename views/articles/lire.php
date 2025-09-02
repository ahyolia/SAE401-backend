
<link rel="stylesheet" href="/css/article.css">

<div class="article-container">
    <h1><?= htmlspecialchars($article['titre']) ?></h1>
    <div class="article-content">
        <p><?= nl2br(htmlspecialchars($article['contenu'])) ?></p>
    </div>
    <a href="/" class="back-home">Retour à l'accueil</a>
</div>