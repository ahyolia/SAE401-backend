<meta name="viewport" content="width=device-width, initial-scale=1">
<?php
$msg = $bo['msg'] ?? '';
$reservations = $bo['reservations'] ?? [];
$reservations_valides = $bo['reservations_valides'] ?? [];
$active = 'reservations';
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

        <!-- Affichage des réservations à valider -->
        <h1>Réservations à valider</h1>
        <?php if (!empty($reservations)): ?>
            <table>
                <thead>
                    <tr>
                        <th>Adhérent(e)</th>
                        <th>Date</th>
                        <th>Produits</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($reservations as $r): ?>
                    <tr>
                        <td><?= htmlspecialchars($r['nom'] . ' ' . $r['prenom']) ?></td>
                         <td><?= htmlspecialchars($r['date']) ?></td>
                        <td><?= $r['produits'] ?></td>
                        <td>
                            <button class="bo-btn bo-btn-update" data-id="<?= $r['id'] ?>">Valider</button>
                            <button class="bo-btn bo-btn-delete" data-id="<?= $r['id'] ?>">Refuser</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Aucune réservation à valider.</p>
        <?php endif; ?>

        <!-- Affichage des réservations validées -->
        <h1>Réservations validées</h1>
        <?php if (!empty($reservations_valides)): ?>
            <table>
                <thead>
                    <tr>
                        <th>Adhérent(e)</th>
                        <th>Date de réservation</th>
                        <th>Produits</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($reservations_valides as $r): ?>
                    <tr>
                        <td><?= htmlspecialchars($r['nom'] . ' ' . $r['prenom']) ?></td> 
                        <td><?= htmlspecialchars($r['date']) ?></td>
                        <td><?= $r['produits'] ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Aucune réservation validée pour le moment.</p>
        <?php endif; ?>
    </main>
</div>

<script>
    // Fonction AJAX pour valider ou refuser une réservation
    document.querySelectorAll('.valider-btn').forEach(button => {
        button.addEventListener('click', function() {
            const reservationId = this.getAttribute('data-id');
            sendRequest(reservationId, 'valider');
        });
    });

    document.querySelectorAll('.refuser-btn').forEach(button => {
        button.addEventListener('click', function() {
            const reservationId = this.getAttribute('data-id');
            sendRequest(reservationId, 'refuser');
        });
    });

    function sendRequest(reservationId, action) {
        fetch('/reservations/updateReservation', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
                'reservation_id': reservationId,
                'action': action,
            })
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
            if (data.success) {
                location.reload(); // Recharge la page pour mettre à jour l'affichage
            }
        })
        .catch(error => {
            alert('Une erreur est survenue.');
        });
    }
</script>
