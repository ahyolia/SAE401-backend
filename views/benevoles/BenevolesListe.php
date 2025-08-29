<?php
$benevoles = $bo['benevoles'] ?? [];
$active = 'benevoles';
?>
<link rel="stylesheet" href="/css/backoffice.css">
<div class="backoffice-layout">
    <main class="main-content">
        <h1>Liste des Bénévoles</h1>
        <?php if (!empty($benevoles)): ?>
            <table>
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Email</th>
                        <th>Téléphone</th>
                        <th>Date demande</th>
                        <th>Statut</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($benevoles as $b): ?>
                    <tr>
                        <td><?= htmlspecialchars($b['nom']) ?></td>
                        <td><?= htmlspecialchars($b['prenom']) ?></td>
                        <td><?= htmlspecialchars($b['email']) ?></td>
                        <td><?= htmlspecialchars($b['telephone']) ?></td>
                        <td><?= htmlspecialchars($b['date_demande']) ?></td>
                        <td><?= $b['valide'] ? 'Validé' : 'En attente' ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Aucun bénévole enregistré.</p>
        <?php endif; ?>
    </main>
</div>