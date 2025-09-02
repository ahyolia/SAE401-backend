<link rel="stylesheet" href="/css/benevole.css">

<div class="benevole-hero">
    <div class="benevole-avatar">
        <img src="/images/icons/benevole.png" alt="Avatar Don">
    </div>
    <div class="benevole-title">Devenir bénévole</div>
</div>


<div class="benevole-section">
     <?php if (!empty($_SESSION['msg'])): ?>
        <div class="alert" id="alert-msg"><?= htmlspecialchars($_SESSION['msg']) ?></div>
        <script>
            setTimeout(function() {
                var alert = document.getElementById('alert-msg');
                if (alert) alert.style.display = 'none';
            }, 3000);
        </script>
        <?php unset($_SESSION['msg']); ?>
    <?php endif; ?>

    <form method="POST" action="/benevoles/ajouter">
        <label>Nom :</label>
        <input type="text" name="nom" required>
        
        <label>Prénom :</label>
        <input type="text" name="prenom" required>
        
        <label>Email :</label>
        <input type="email" name="email" required>
        
        <label>Téléphone :</label>
        <input type="text" name="telephone" required>
        
        <button type="submit">Envoyer</button>
    </form>
</div>

