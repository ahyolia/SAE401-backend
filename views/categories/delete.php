<h1>Supprimer la catégorie</h1>

<p>Êtes-vous sûr de vouloir supprimer la catégorie suivante ?</p>

<h2><?= $categorie['titre'] ?></h2>

<form method="POST" action="/categories/delete/<?= $categorie['id_categories'] ?>">
    <button type="submit">Confirmer la suppression</button>
    <a href="/categories">Annuler</a>
</form>