<h1>Liste des catégories</h1>

<a href="/categories/create">Ajouter une nouvelle catégorie</a>

<?php if (!empty($categories)): ?>
    <ul>
        <?php foreach ($categories as $categorie): ?>
            <li>
                <h3><?= $categorie['titre'] ?></h3>
                <a href="/categories/update/<?= $categorie['id_categories'] ?>">Modifier</a>
                <a href="/categories/delete/<?= $categorie['id_categories'] ?>">Supprimer</a>
            </li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>Aucune catégorie disponible.</p>
<?php endif; ?>