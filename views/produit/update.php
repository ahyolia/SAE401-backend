<h1>Modifier le produit</h1>

<form method="POST" action="/produits/update/<?= $produit['id'] ?>">
    <label for="name">Nom :</label>
    <input type="text" name="name" id="name" value="<?= htmlspecialchars($produit['name'] ?? '') ?>" required>

    <label for="description">Description :</label>
    <textarea name="description" id="description" required><?= htmlspecialchars($produit['description'] ?? '') ?></textarea>

    <label for="price">Prix :</label>
    <input type="number" step="0.01" name="price" id="price" value="<?= htmlspecialchars($produit['price'] ?? '') ?>" required>

    <label for="category_id">Catégorie :</label>
    <select name="category_id" id="category_id" required>
        <?php if (!empty($categories)): ?>
            <?php foreach ($categories as $cat): ?>
                <option value="<?= $cat['id'] ?>" <?= ($produit['category_id'] == $cat['id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($cat['name']) ?>
                </option>
            <?php endforeach; ?>
        <?php endif; ?>
    </select>

    <button type="submit">Mettre à jour</button>
</form>