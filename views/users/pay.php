<div class="container" style="max-width: 420px; margin: 3em auto; background: #fff; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.07); padding: 2.5em 2em;">
    <h2 style="text-align:center; color:#8D6748; margin-bottom: 1.5em;">Paiement de l'adhésion annuelle</h2>

    <?php if (!empty($msg)): ?>
        <div class="alert" style="color: #27ae60; background: #eafaf1; border-radius: 5px; padding: 0.7em 1em; text-align:center; margin-bottom:1em;">
            <?= htmlspecialchars($msg) ?>
        </div>
        <div style="display:flex; justify-content:center; gap:1em;">
            <button onclick="window.location.href='<?= !empty($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], '/panier') !== false ? '/panier' : '/' ?>'" style="padding:1em 2em; font-size:1.1em; background:#55BDC6; color:#fff; border:none; border-radius:5px; font-weight:bold; cursor:pointer; transition:background 0.2s;">
                Retour
            </button>
        </div>
    <?php else: ?>
        <p style="text-align:center; color:#555; margin-bottom:1.5em;">
            Pour réserver des produits, vous devez être adhérent.<br>
            <span style="color:#222;">L'adhésion coûte <strong>200 F</strong> par an.</span>
        </p>
        <form method="post" action="/users/payProcess" style="display:flex; flex-direction:column; align-items:center;">
            <button type="submit" style="padding:1em 2em; font-size:1.1em; background:#27ae60; color:#fff; border:none; border-radius:5px; font-weight:bold; cursor:pointer; transition:background 0.2s;">
                Payer mon adhésion
            </button>
        </form>
    <?php endif; ?>
</div>
