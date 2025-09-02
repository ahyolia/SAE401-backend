<link rel="stylesheet" href="/css/users/account.css">

<div class="account-hero">
    <div class="account-avatar">
        <img src="/images/user.png" alt="Avatar">
    </div>
    <div class="account-title">Mon compte</div>
</div>

<div class="account-main">
    <div class="account-info-block">
        <div class="account-info">
            <label>Numéro étudiant</label>
            <div class="info-value"><?= htmlspecialchars($user['numero_etudiant'] ?? '-') ?></div>

            <label>Email</label>
            <div class="info-value"><?= htmlspecialchars($user['email'] ?? '-') ?></div>

            <label>Prénom</label>
            <div class="info-value"><?= htmlspecialchars($user['prenom'] ?? '-') ?></div>

            <label>Adhérent</label>
            <div class="info-value"><?= !empty($user['adherent']) ? 'Oui' : 'Non' ?></div>
        </div>
        <div class="account-btns-row">
            <a href="/users/edit" class="btn-compte btn-small">Modifier mon profil</a>
            <a href="/users/logout" class="btn-compte btn-small">Déconnexion</a>
        </div>
    </div>
    <div class="account-historiques">
        <div class="account-section account-orders-block" style="width:100%; max-width:1100px; margin:0 auto;">
            <h2>Historique de mes commandes</h2>
            <?php if (!empty($reservations)): ?>
                <table class="account-orders" style="width:100%;">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Produits</th>
                            <th>Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($reservations as $res): ?>
                            <tr>
                                <td><?= htmlspecialchars(date('d/m/Y H:i', strtotime($res['date']))) ?></td>
                                <td>
                                <?= !empty($res['produits']) ? htmlspecialchars($res['produits']) : '<em>Aucun produit</em>' ?>
                                </td>
                                <td><?= htmlspecialchars($res['statut']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>Aucune commande enregistrée.</p>
            <?php endif; ?>
        </div>

        <div class="account-section account-dons-block" style="width:100%; max-width:1100px; margin:2em auto 0 auto;">
            <h2>Mes dons</h2>
            <?php if (!empty($dons)): ?>
                <table class="account-dons" style="width:100%;">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Produit</th>
                            <th>Quantité</th>
                            <th>Catégorie</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($dons as $don): ?>
                            <tr>
                                <td><?= htmlspecialchars(date('d/m/Y H:i', strtotime($don['date_don']))) ?></td>
                                <td><?= htmlspecialchars($don['produit']) ?></td>
                                <td><?= htmlspecialchars($don['quantite']) ?></td>
                                <td><?= htmlspecialchars($don['categorie_id']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>Aucun don enregistré.</p>
            <?php endif; ?>
        </div>
    </div>
</div>