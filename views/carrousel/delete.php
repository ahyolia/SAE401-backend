<h1>Supprimer l'élément du carrousel</h1>

<p>Êtes-vous sûr de vouloir supprimer l'élément suivant ?</p>

<h2><?= $carrouselItem['titre'] ?></h2>
<img src="<?= $carrouselItem['image'] ?>" alt="<?= $carrouselItem['titre'] ?>" style="max-width: 200px;">
<p><?= $carrouselItem['description'] ?></p>

<form method="POST" action="/carrousel/delete/<?= $carrouselItem['id'] ?>">
    <button type="submit">Confirmer la suppression</button>
    <a href="/carrousel">Annuler</a>
</form>