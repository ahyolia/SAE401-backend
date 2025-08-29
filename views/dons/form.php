<link rel="stylesheet" href="/css/dons.css">

<div class="dons-hero">
    <div class="dons-avatar">
        <img src="/images/icons/don.png" alt="Avatar Don">
    </div>
    <div class="dons-title">Faire un Don</div>
</div>

<div class="dons-section">
 <?php if (!empty($_SESSION['msg'])): ?>
        <div class="alert"><?=$_SESSION['msg'] ?></div>
        <script>
            setTimeout(function() {
                var alert = document.getElementById('alert-msg');
                if (alert) alert.style.display = 'none';
            }, 3000);
        </script>
    <?php endif; ?>
    <form method="POST" action="/dons/ajouter" enctype="multipart/form-data">
        <label>Catégorie :</label>
        <select name="categorie" required>
            <option value="">
                <?php foreach ($categories as $cat): ?>
                    <option value="<?= htmlspecialchars($cat['id']) ?>"><?= htmlspecialchars($cat['name']) ?></option>
                <?php endforeach; ?>
            </option>
            
        </select>

        <label>Produit :</label>
        <input type="text" name="produit" required>

        <label>Quantité :</label>
        <input type="number" name="quantite" min="1" required>

        <label>Photo du produit :</label>
        <input type="file" name="photo" accept="image/*">

        <label>Date disponible :</label>
        <input type="date" name="date_disponible" required>

        <label>Lieu de récupération :</label>
        <input type="text" name="lieu" required>

        <button type="submit">Faire un don</button>
    </form>
</div>