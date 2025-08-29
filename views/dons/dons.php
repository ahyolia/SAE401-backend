<h1>Gestion des Dons</h1>
<div class="alert"><?= $bo['msg'] ?? '' ?></div>

<!-- Liste des dons à valider -->
<?php if (!empty($bo['dons'])): ?>
    <h2>Liste des dons à valider</h2>
    <?php foreach ($bo['dons'] as $don): ?>
        <div>
            <h3><?= htmlspecialchars($don['produit']) ?> (<?= htmlspecialchars($don['quantite']) ?>)</h3>
            <p>Catégorie ID : <?= htmlspecialchars($don['categorie_id']) ?></p>
            <p>Utilisateur : <?= htmlspecialchars($don['user_id']) ?></p>
            <p>Date du don : <?= htmlspecialchars($don['date_don']) ?></p>
            <!-- Formulaire pour valider le don et adapter le stock -->
            <form method="POST" action="/backoffice/updateDon/<?= $don['id'] ?>">
                <label for="quantite_<?= $don['id'] ?>">Quantité à ajouter :</label>
                <input type="number" name="quantite" id="quantite_<?= $don['id'] ?>" value="<?= htmlspecialchars($don['quantite']) ?>" min="1" required>
                <button type="submit" name="action" value="valider">Valider</button>
            </form>
            <!-- Formulaire pour refuser le don -->
            <form method="POST" action="/backoffice/updateDon/<?= $don['id'] ?>">
                <button type="submit" name="action" value="refuser" style="background:red;color:white;">Refuser</button>
            </form>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p>Aucun don à valider pour le moment.</p>
<?php endif; ?>