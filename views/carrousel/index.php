<h1>Liste des éléments du carrousel</h1>

<a href="/carrousel/create">Ajouter un nouvel élément</a>

<?php if (!empty($carrousel)): ?>
    <ul>
        <?php foreach ($carrousel as $item): ?>
            <li>
                <h3><?= $item['titre'] ?></h3>
                <img src="<?= $item['image'] ?>" alt="<?= $item['titre'] ?>" style="max-width: 200px;">
                <p><?= $item['description'] ?></p>
                <a href="/carrousel/update/<?= $item['id'] ?>">Modifier</a>
                <a href="/carrousel/delete/<?= $item['id'] ?>">Supprimer</a>
            </li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>Aucun élément dans le carrousel pour le moment.</p>
<?php endif; ?>