<h1>Supprimer l'article</h1>

<p>Êtes-vous sûr de vouloir supprimer l'article suivant ?</p>

<h2><?= $article['titre'] ?></h2>
<p><?= $article['contenu'] ?></p>

<form action="/articles/delete/<?= $article['id_article'] ?>" method="POST">
    <button type="submit">Confirmer la suppression</button>
    <a href="/articles">Annuler</a>
</form>