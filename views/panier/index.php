<!-- filepath: c:\wamp64\www\MVC25\views\panier\index.php -->
<link rel="stylesheet" href="/css/panierstyle.css">

<main>
    <h2 class="panier-title">Votre panier</h2>
    <div id="panier-container">
        <table id="panier" class="cart">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Produit</th>
                    <th>Quantité</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <!-- Les produits seront ajoutés dynamiquement ici -->
            </tbody>
        </table>
        <div id="panier-totaux">
            <p>
                Réservée aux adhérents (adhésion annuelle : 200 F).<br>
                Sélectionnez vos produits, puis validez votre réservation.
            </p>
            <div id="jauge-aliments"></div>
                <div id="actions-adherent" style="display:none;">
                    <button id="btn-vider" class="btn-secondary">Vider le panier</button>
                    <button id="btn-valider" class="btn-primary">Commander</button>
                </div>
                <div id="actions-nonadherent" style="display:none;">
                    <button id="btn-vider-nonadherent" class="btn-secondary">Vider le panier</button>
                    <button id="btn-adhesion" class="btn-primary">Payer l'adhésion</button>
                </div>
            
        </div>
    </div>
</main>

<div id="popup-modal" style="display:none;position:fixed;top:30%;left:50%;transform:translate(-50%,-50%);background:#fff;padding:2em;border-radius:12px;box-shadow:0 2px 16px #3A9D9A;">
  <span id="popup-message"></span>
  <button onclick="document.getElementById('popup-modal').style.display='none'">Fermer</button>
</div>

<script src="/js/page_panier.js"></script>
<script>
window.isAdherent = "<?= (!empty($_SESSION['user']['adherent']) && $_SESSION['user']['adherent']) ? 'true' : 'false' ?>";

if(window.isAdherent === "true") {
    document.getElementById('actions-adherent').style.display = 'block';
    document.getElementById('actions-nonadherent').style.display = 'none';
} else {
    document.getElementById('actions-adherent').style.display = 'none';
    document.getElementById('actions-nonadherent').style.display = 'block';
    document.getElementById('btn-adhesion').onclick = function() {
        window.location.href = '/users/pay';
    };
}
</script>
