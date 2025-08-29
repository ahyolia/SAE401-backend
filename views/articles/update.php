<h1>Mettre à jour l'article</h1>

<form action="/articles/update/<?= $article['id_article'] ?>" method="POST">
    <div>
        <label for="titre">Titre :</label>
        <input type="text" id="titre" name="titre" value="<?= $article['titre'] ?>" required>
    </div>
    <div>
        <label for="contenu">Contenu :</label>
        <textarea id="contenu" name="contenu" required><?= $article['contenu'] ?></textarea>
    </div>
    <div>
        <label for="slug">Slug :</label>
        <input type="text" id="slug" name="slug" value="<?= $article['slug'] ?>" required>
    </div>
    <div>
        <label for="article_categorie">Catégorie :</label>
        <input type="number" id="article_categorie" name="article_categorie" value="<?= $article['article_categorie'] ?>" required>
    </div>
    <button type="submit">Mettre à jour</button>
</form>