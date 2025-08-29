<meta name="viewport" content="width=device-width, initial-scale=1">
<?php
$msg = $bo['msg'] ?? '';
$carrousel = $bo['carrousel'] ?? [];
$active = 'carrousel';
?>
<?php
if (!isset($_SESSION['connecte'])) {
    header('Location: /backoffice/connexion');
    exit;
}
?>
<link rel="stylesheet" href="/css/backoffice.css">
<div class="backoffice-layout">
    <?php include __DIR__.'/sidebar.php'; ?>
    <main class="main-content">
        <?php if (!empty($msg)): ?>
            <div class="alert"><?= htmlspecialchars($msg) ?></div>
            <script>
                setTimeout(function() {
                    var alert = document.querySelector('.alert');
                    if(alert) alert.style.display = 'none';
                }, 3000);
            </script>
        <?php endif; ?>
        <h1>Gestion du Carrousel</h1>
        <form class="d-inline-block" method="POST" action="/backoffice/create" enctype="multipart/form-data" style="margin-bottom:2em;">
            <fieldset>
                <legend>Ajouter un nouvel élément</legend>
                <label for="titre">Titre :</label>
                <input type="text" name="titre" required>
                <label for="image">Image :</label>
                <input type="file" name="image" accept="image/*">
                <label for="description">Description :</label>
                <textarea name="description" required></textarea>
                <label for="categorie">Catégorie :</label>
                <select name="categorie" required>
                    <option value="accueil" <?= (!empty($bo['categorie_active']) && $bo['categorie_active'] == 'accueil') ? 'selected' : '' ?>>Accueil</option>
                    <option value="partenaires" <?= (!empty($bo['categorie_active']) && $bo['categorie_active'] == 'partenaires') ? 'selected' : '' ?>>Partenaires</option>
                    <option value="evenements" <?= (!empty($bo['categorie_active']) && $bo['categorie_active'] == 'evenements') ? 'selected' : '' ?>>Événements</option>
                </select>
                <input type="submit" name="maj" class="bo-btn bo-btn-create" value="Ajouter"/>
            </fieldset>
        </form>
        <?php if (!empty($carrousel)): ?>
            <h2>Liste des éléments du carrousel</h2>
            <table>
                <thead>
                    <tr>
                        <th>Titre</th>
                        <th>Image</th>
                        <th>Description</th>
                        <th>Catégorie</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($carrousel as $item): ?>
                    <tr>
                        <form class="d-inline-block" method="POST" action="/backoffice/update/<?= $item['id'] ?>" enctype="multipart/form-data">
                            <td>
                                <input type="text" name="titre" value="<?= htmlspecialchars($item['titre']) ?>" required style="width:120px;">
                            </td>
                            <td>
                                <input type="file" name="image" accept="image/*">
                                <?php if (!empty($item['image'])): ?>
                                    <br><img src="/images/<?= htmlspecialchars($item['image']) ?>" alt="" style="max-width:80px;">
                                <?php endif; ?>
                            </td>
                            <td>
                                <textarea name="description" required style="width:180px;"><?= htmlspecialchars($item['description']) ?></textarea>
                            </td>
                            <td>
                                <select name="categorie" required>
                                    <option value="accueil" <?= $item['categorie'] == 'accueil' ? 'selected' : '' ?>>Accueil</option>
                                    <option value="partenaires" <?= $item['categorie'] == 'partenaires' ? 'selected' : '' ?>>Partenaires</option>
                                    <option value="evenements" <?= $item['categorie'] == 'evenements' ? 'selected' : '' ?>>Événements</option>
                                </select>
                            </td>
                            <td>
                                <button type="submit" name="update" class="bo-btn bo-btn-update">Modifier</button>
                                <button type="submit" name="delete" class="bo-btn bo-btn-delete">Supprimer</button>
                            </td>
                        </form>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </main>
</div>