<meta name="viewport" content="width=device-width, initial-scale=1">
<?php
$msg = $bo['msg'] ?? '';
$categories = $bo['categories'] ?? [];
$active = 'categories';
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
        <h1>Gestion des Catégories</h1>
        <form class="d-inline-block" method="POST" action="/backoffice/create" style="margin-bottom:2em;">
            <fieldset>
                <legend>Ajouter une nouvelle catégorie</legend>
                <label for="titre">Titre :</label>
                <input type="text" name="titre" id="titre" required>
                <input type="submit" name="maj" class="bo-btn bo-btn-create" value="Ajouter"/>
            </fieldset>
        </form>
        <?php if (!empty($categories)): ?>
            <h2>Liste des catégories</h2>
            <table class="table-categorie">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($categories as $categorie): ?>
                    <tr>
                        <form class="d-inline-block" method="POST" action="/backoffice/update/<?= $categorie['id'] ?>">
                            <td>
                                <input type="text" name="titre" value="<?= htmlspecialchars($categorie['name']) ?>" required style="width:120px;">
                            </td>
                            <td>
                                <div class="actions-cell">
                                    <button type="submit" name="update" class="bo-btn bo-btn-update">Modifier</button>
                                    <button type="submit" name="delete" class="bo-btn bo-btn-delete">Supprimer</button>
                                </div>
                            </td>
                        </form>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </main>
</div>