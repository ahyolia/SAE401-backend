<meta name="viewport" content="width=device-width, initial-scale=1">
<?php
$msg = $bo['msg'] ?? '';
$dons = $bo['dons'] ?? [];
$categories = $bo['categories'] ?? [];
$active = 'dons';
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
                }, 10000);
            </script>
        <?php endif; ?>
        <h1>Gestion des Dons</h1>
        <?php if (!empty($dons)): ?>
            <h2>Liste des dons à valider</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID Utilisateur</th>
                        <th>Produit</th>
                        <th>Quantité</th>
                        <th>Catégorie</th>
                        <th>Date du don</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($dons as $don): ?>
                    <tr>
                        <form class="d-inline-block" method="POST" action="/backoffice/updateDon/<?= $don['id'] ?>">
                            <td><?= htmlspecialchars($don['user_id']) ?></td>
                            <td><?= htmlspecialchars($don['produit']) ?></td>
                            <td>
                                <input type="number" name="quantite" value="<?= htmlspecialchars($don['quantite']) ?>" min="1" required style="width:60px;">
                            </td>
                            <td>
                            <?php
                                $catName = $don['categorie_id'];
                                if (!empty($categories)) {
                                    foreach ($categories as $cat) {
                                        if ((string)$cat['id'] === (string)$don['categorie_id']) {
                                            $catName = $cat['name'];
                                            break;
                                        }
                                    }
                                }
                                echo htmlspecialchars($catName);
                            ?>
                            </td>
                            <td><?= htmlspecialchars($don['date_don']) ?></td>
                            <td>
                                <button type="submit" name="action" value="valider" class="bo-btn bo-btn-update">Valider</button>
                                <button type="submit" name="action" value="refuser" class="bo-btn bo-btn-delete">Refuser</button>
                            </td>
                        </form>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Aucun don à valider pour le moment.</p>
        <?php endif; ?>
    </main>
</div>