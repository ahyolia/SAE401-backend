<h1>Ajouter un nouvel élément au carrousel</h1>

<form method="POST" action="/carrousel/create">
    <label for="titre">Titre :</label>
    <input type="text" name="titre" id="titre" required>

    <label for="image">Image (URL ou chemin) :</label>
    <input type="text" name="image" id="image" required>

    <label for="description">Description :</label>
    <textarea name="description" id="description" required></textarea>

    <button type="submit">Ajouter</button>
</form>