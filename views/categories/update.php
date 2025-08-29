<h1>Modifier la catégorie</h1>

<form method="POST" action="/categories/update/<?= $categorie['id_categories'] ?>">
    <label for="titre">Titre :</label>
    <input type="text" name="titre" id="titre" value="<?= $categorie['titre'] ?>" required>
    <button type="submit">Mettre à jour</button>
</form>