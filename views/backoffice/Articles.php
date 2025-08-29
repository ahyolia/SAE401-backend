<meta name="viewport" content="width=device-width, initial-scale=1">
<?php
$msg = $bo['msg'] ?? '';
$articles = $bo['articles'] ?? [];
$categories = $bo['categories'] ?? [];
$active = 'articles';
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
        <h1>Gestion des articles</h1>
        <form class="d-inline-block" method="POST" action="/backoffice/create" enctype="multipart/form-data" style="margin-bottom:2em;">
            <fieldset>
                <legend>Créer un nouvel article</legend>
                <label for="titre">Titre :</label>
                <input type="text" name="titre" required/>
                <label for="contenu">Contenu :</label>
                <textarea name="contenu" required></textarea>
                <label for="slug">Slug :</label>
                <input type="text" name="slug" required>
                <label for="image">Image :</label>
                <input type="file" name="image" accept="image/*">
                <label for="date_publication">Date de publication :</label>
                <input type="date" name="date_publication" required>
                <label>
                    <input type="checkbox" name="is_main" value="1"> Article principal
                </label>
                <button type="submit" name="maj" class="bo-btn bo-btn-create">Ajouter</button>
            </fieldset>
        </form>
        <?php if (!empty($articles)): ?>
            <h2>Liste des articles</h2> 
            <table>
                <thead>
                    <tr>
                        <th>Titre</th>
                        <th>Contenu</th>
                        <th>Slug</th>
                        <th>Date de publication</th>
                        <th>Image</th>
                        <th>Principal</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($articles as $item): ?>
                    <tr>
                        <form class="d-inline-block" method="POST" action="/backoffice/update/<?= $item['id_article'] ?>" enctype="multipart/form-data">
                            <td>
                                <input type="text" name="titre" value="<?= htmlspecialchars($item['titre']) ?>" required style="width:120px;">
                            </td>
                            <td>
                                <textarea name="contenu" required style="width:180px;"><?= htmlspecialchars($item['contenu']) ?></textarea>
                            </td>
                            <td>
                                <input type="text" name="slug" value="<?= htmlspecialchars($item['slug']) ?>" required style="width:100px;">
                            </td>
                            <td>
                                <input type="date" name="date_publication" value="<?= htmlspecialchars($item['date_publication']) ?>" required>
                            </td>
                            <td>
                                <?php if (!empty($item['image'])): ?>
                                    <img src="/images/<?= htmlspecialchars($item['image']) ?>" alt="miniature" style="width:40px;">
                                <?php endif; ?>
                                <input type="file" name="image" accept="image/*">
                            </td>
                            <td>
                                <input type="checkbox" name="is_main" value="1" <?= !empty($item['is_main']) ? 'checked' : '' ?>>
                            </td>
                            <td>
                                <button type="submit" name="update" class="bo-btn bo-btn-update">Modifier</button>
                                <button type="submit" name="delete" class="bo-btn bo-btn-delete">Supprimer</button>
                            </td>
                        </form>
                    </tr>
                <?php endforeach ?>
                </tbody>
            </table>
        <?php endif; ?>
    </main>
</div>