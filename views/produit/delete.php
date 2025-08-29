<h1>Supprimer le produit</h1>

<p>Êtes-vous sûr de vouloir supprimer le produit suivant ?</p>

<h2><?= $categorie['titre'] ?></h2>

<form method="POST" action="/produits/delete/<?= $categorie['id_produits'] ?>">
    <button type="submit">Confirmer la suppression</button>
    <a href="/produits">Annuler</a>
</form>