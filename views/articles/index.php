<?php
\app\Debug::debug($articles); 
?>

<link rel="stylesheet" href="/css/backoffice.css">

<?php foreach($articles as $article): ?>
<div class='container'>
    <section class="article">
    <h2>
    <a href="/articles/lire/<?= urlencode($article['slug']) ?>">
        <?= htmlspecialchars($article['titre']) ?>
    </a>
    </h2>
    <p><?= substr($article['contenu'],0,30)."..." ?></p>
    </section>
</div>
<?php endforeach ?>