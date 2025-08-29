<link rel="stylesheet" href="/css/users/account.css">

<div class="account-hero">
    <div class="account-avatar">
        <img src="/images/user.png" alt="Avatar">
    </div>
    <div class="account-title">Mon compte</div>
</div>

<div class="account-main">
    <div class="account-section account-info-block">
        <div class="account-info">
            <label>Numéro étudiant</label>
            <div class="info-value"><?= htmlspecialchars($user['numero_etudiant'] ?? '') ?></div>

            <label>Email</label>
            <div class="info-value"><?= htmlspecialchars($user['email'] ?? '') ?></div>

            <label>Nom Prénom</label>
            <div class="info-value"><?= htmlspecialchars(($user['prenom'] ?? '') . ' ' . ($user['nom'] ?? '')) ?></div>
        </div>
        <div style="margin-top:2em; text-align:center;">
            <a href="/users/edit" class="btn-compte">Modifier mon profil</a>
            <a href="/users/logout" class="btn-compte" style="margin-left:1em;">Déconnexion</a>
        </div>
    </div>

    <div class="account-section account-orders-block">
        <h2>Historique de mes commandes</h2>
        <?php if (!empty($reservations)): ?>
            <table class="account-orders">
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
                            <td><?= htmlspecialchars($res['produits']) ?></td>
                            <td><?= htmlspecialchars($res['statut']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Aucune commande enregistrée.</p>
        <?php endif; ?>
    </div>
</div>