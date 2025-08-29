<meta name="viewport" content="width=device-width, initial-scale=1">
<?php
$msg = $bo['msg'] ?? '';
$benevoles = $bo['benevoles'] ?? [];
$benevoles_valides = $bo['benevoles_valides'] ?? [];
$active = 'benevoles';
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
        <h1>Validation des Bénévoles</h1>
        <?php if (!empty($benevoles)): ?>
            <table>
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Email</th>
                        <th>Téléphone</th>
                        <th>Date demande</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($benevoles as $b): ?>
                    <tr>
                        <form class="d-inline-block" method="POST" action="/benevoles/updateBenevole/<?= $b['id'] ?>">
                            <td><?= htmlspecialchars($b['nom']) ?></td>
                            <td><?= htmlspecialchars($b['prenom']) ?></td>
                            <td><?= htmlspecialchars($b['email']) ?></td>
                            <td><?= htmlspecialchars($b['telephone']) ?></td>
                            <td><?= htmlspecialchars($b['date_demande']) ?></td>
                            <td>
                                <button type="submit" name="action" value="valider" class="bo-btn bo-btn-update">Accepter</button>
                                <button type="submit" name="action" value="refuser" class="bo-btn bo-btn-delete">Refuser</button>
                            </td>
                        </form>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Aucun bénévole à valider pour le moment.</p>
        <?php endif; ?>

        <h1>Liste des bénévoles validés</h1>
            <table>
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Email</th>
                    <th>Téléphone</th>
                    <th>Date validation</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php if (!empty($benevoles_valides)): ?>
                <?php foreach ($benevoles_valides as $b): ?>
                    <tr>
                        <td><?= htmlspecialchars($b['nom']) ?></td>
                        <td><?= htmlspecialchars($b['prenom']) ?></td>
                        <td><?= htmlspecialchars($b['email']) ?></td>
                        <td><?= htmlspecialchars($b['telephone']) ?></td>
                        <td><?= htmlspecialchars($b['date_validation']) ?></td>
                        <td>
                            <form method="POST" action="/benevoles/updateBenevole/<?= $b['id'] ?>" style="display:inline;">
                                <button type="submit" name="action" value="supprimer" class="bo-btn bo-btn-delete">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6">Aucun bénévole validé pour le moment.</td>
                </tr>
            <?php endif; ?>
            </tbody>
            </table>
    </main>
</div>