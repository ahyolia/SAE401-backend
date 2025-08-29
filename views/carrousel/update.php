<h1>Modifier l'élément du carrousel</h1>

<form method="POST" action="/carrousel/update/<?= $carrouselItem['id'] ?>">
    <label for="titre">Titre :</label>
    <input type="text" name="titre" id="titre" value="<?= $carrouselItem['titre'] ?>" required>

    <label for="image">Image (URL ou chemin) :</label>
    <input type="text" name="image" id="image" value="<?= $carrouselItem['image'] ?>" required>

    <label for="description">Description :</label>
    <textarea name="description" id="description" required><?= $carrouselItem['description'] ?></textarea>

    <button type="submit">Mettre à jour</button>
</form>