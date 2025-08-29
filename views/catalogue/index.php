<link rel="stylesheet" href="/css/catalogue.css">

<div class="cata">
    <h1>Magasin</h1>
    <p>Les étudiants adhérents peuvent réserver jusqu'à <strong>5 produits</strong> et <strong>2 paniers par semaine</strong>, dans la limite des ressources disponibles.</p>

    <form class="catalogue-search" id="search-form" method="get">
                <input type="text" id="search-input" name="search" placeholder="Rechercher un produit..." required>
                <button type="submit" id="search-btn"><i class="fas fa-search"></i></button>
            </form>
     <div class="head">
         <div class="catalogue-categories">
            <a href="#" class="category-btn active" data-category="all">Toutes les catégories</a>
            <?php foreach ($categories as $category): ?>
                <a href="#" class="category-btn" data-category="<?= $category['id'] ?>">
                    <?= htmlspecialchars($category['name']) ?>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
    <main>

        <div class="product-grid">
            <?php foreach ($produits as $produit): ?>
                <?php if ((int)$produit['stock'] > 0): ?>
                    <div class="product-card"
                        data-id="<?= htmlspecialchars($produit['id']) ?>"
                        data-category="<?= htmlspecialchars($produit['category_id']) ?>"
                        data-stock="<?= htmlspecialchars($produit['stock']) ?>"
                        data-price="<?= htmlspecialchars($produit['price'] ?? 0) ?>">
                        <img src="<?= htmlspecialchars($produit['image'] ?? '/images/default.png') ?>" alt="<?= htmlspecialchars($produit['name'] ?? '') ?>" class="product-image">
                        <h4><?= htmlspecialchars($produit['name']) ?></h4>
                        <p><?= htmlspecialchars($produit['description'] ?? '') ?></p>
                        <p class="stock">Stock : <?= $produit['stock'] ?></p>
                        <div class="quantity-controls">
                            <button class="quantity-btn">-</button>
                            <span class="quantity">1</span>
                            <button class="quantity-btn">+</button>
                        </div>
                        <button class="add-to-cart">Ajouter au panier</button>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </main>
</div>
<button id="btn-top" title="Remonter en haut"><i class="fas fa-arrow-up"></i></button>
<script src="/js/catalogue.js"></script>

