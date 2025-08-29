<h1>Créer un nouvel article</h1>

<form action="/articles/create" method="POST">
    <div>
        <label for="titre">Titre :</label>
        <input type="text" id="titre" name="titre" required>
    </div>
    <div>
        <label for="contenu">Contenu :</label>
        <textarea id="contenu" name="contenu" required></textarea>
    </div>
    <div>
        <label for="slug">Slug :</label>
        <input type="text" id="slug" name="slug" required>
    </div>
    <button type="submit">Créer</button>
</form>