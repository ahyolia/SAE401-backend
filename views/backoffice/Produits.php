<meta name="viewport" content="width=device-width, initial-scale=1">
<?php
$msg = $bo['msg'] ?? '';
$produits = $bo['produits'] ?? [];
$categories = $bo['categories'] ?? [];
$active = 'produits';
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
        <h1>Gestion des produits</h1>
        <form class="d-inline-block" method="POST" action="/backoffice/create" enctype="multipart/form-data" style="margin-bottom:2em;">
            <fieldset>
                <legend>Ajouter un produit</legend>
                <label for="name">Nom :</label>
                <input type="text" name="name" required>
                <label for="description">Description :</label>
                <textarea name="description" required></textarea>
                <label for="stock">Stock :</label>
                <input type="number" name="stock" min="0" required>
                <label for="category_id">Catégorie :</label>
                <select name="category_id" required>
                    <?php foreach ($categories as $categorie): ?>
                        <option value="<?= $categorie['id'] ?>"><?= $categorie['name'] ?></option>
                    <?php endforeach; ?>
                </select>
                <label for="image">Image :</label>
                <input type="file" name="image" accept="image/*"><br/><br/>
                <input type="submit" name="maj" class="bo-btn bo-btn-create" value="Ajouter"/>
            </fieldset>
        </form>
        <?php if (!empty($produits)): ?>
            <h2>Liste des produits</h2>
            <form id="search-form" style="margin-bottom:1em; display: flex; align-items: center;">
                <img src="/images/search.png" alt="Loupe" style="width: 20px; height: 20px; margin-left: 10px;">
                <input type="text" id="search-input" placeholder="Rechercher un produit..." style="margin:10px; border-radius:20px; border:1px solid #ccc; width:220px;">
            </form>
            <table>
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Description</th>
                        <th>Stock</th>
                        <th>Catégorie</th>
                        <th>Image</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($produits as $produit): ?>
                    <tr>
                        <form class="d-inline-block" method="POST" action="/backoffice/update/<?= $produit['id'] ?>" enctype="multipart/form-data">
                            <td>
                                <input type="text" name="name" value="<?= htmlspecialchars($produit['name']) ?>" required style="width:120px;">
                            </td>
                            <td>
                                <textarea name="description" required style="width:180px;"><?= htmlspecialchars($produit['description']) ?></textarea>
                            </td>
                            <td>
                                <input type="number" name="stock" value="<?= htmlspecialchars($produit['stock']) ?>" min="0" required style="width:60px;">
                            </td>
                            <td>
                                <select name="category_id" required>
                                    <?php foreach ($categories as $categorie): ?>
                                        <option value="<?= $categorie['id'] ?>" <?php if ($categorie['id'] == $produit['category_id']) echo 'selected'; ?>>
                                            <?= htmlspecialchars($categorie['name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                            <td>
                                <input type="file" name="image" accept="image/*">
                                <?php if (!empty($produit['image'])): ?>
                                    <br><img src="<?= htmlspecialchars($produit['image']) ?>" alt="" style="max-width:80px;max-height:40px;">
                                <?php endif; ?>
                            </td>
                            <td>
                                <button type="submit" name="update" class="bo-btn bo-btn-update">Modifier</button>
                                <button type="submit" name="delete" class="bo-btn bo-btn-delete">Supprimer</button>
                            </td>
                        </form>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </main>
</div>

<script>
document.getElementById('search-input').addEventListener('input', function() {
    const search = this.value.toLowerCase();
    document.querySelectorAll('tbody tr').forEach(function(row) {
        const name = row.querySelector('input[name="name"]')?.value.toLowerCase() || '';
        const desc = row.querySelector('textarea[name="description"]')?.value.toLowerCase() || '';
        row.style.display = (name.includes(search) || desc.includes(search)) ? '' : 'none';
    });
}); 
</script>