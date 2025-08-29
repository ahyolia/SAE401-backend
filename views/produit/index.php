<h1>Liste des produits</h1>

<a href="/produits/create">Ajouter un nouveau produit</a>

<?php if (!empty($produits)): ?>
    <ul>
        <?php foreach ($produits as $categorie): ?>
            <li>
                <h3><?= $categorie['titre'] ?></h3>
                <a href="/produits/update/<?= $categorie['id_produits'] ?>">Modifier</a>
                <a href="/produits/delete/<?= $categorie['id_produits'] ?>">Supprimer</a>
            </li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>Aucun produit disponible.</p>
<?php endif; ?>