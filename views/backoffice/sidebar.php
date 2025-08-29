<ul class="sidebar">
    <li>
        <form method="post" action="/backoffice">
            <input type="hidden" name="modele" value="Articles">
            <button type="submit" name="choisir" class="<?= $active === 'articles' ? 'active' : '' ?>">
                <img src="/images/icons/article.png" alt="" class="sidebar-icon"> Articles
            </button>
        </form>
    </li>
    <li>
        <form method="post" action="/backoffice">
            <input type="hidden" name="modele" value="Benevoles">
            <button type="submit" name="choisir" class="<?= $active === 'benevoles' ? 'active' : '' ?>">
                <img src="/images/icons/benevole.png" alt="" class="sidebar-icon"> Bénévoles
            </button>
        </form>
    </li>
    <li>
        <form method="post" action="/backoffice">
            <input type="hidden" name="modele" value="Carrousel">
            <button type="submit" name="choisir" class="<?= $active === 'carrousel' ? 'active' : '' ?>">
                <img src="/images/icons/carrousel.png" alt="" class="sidebar-icon"> Carrousel
            </button>
        </form>
    </li>
    <li>
        <form method="post" action="/backoffice">
            <input type="hidden" name="modele" value="Categories">
            <button type="submit" name="choisir" class="<?= $active === 'categories' ? 'active' : '' ?>">
                <img src="/images/icons/categorie.png" alt="" class="sidebar-icon"> Catégories
            </button>
        </form>
    </li>
    <li>
        <form method="post" action="/backoffice">
            <input type="hidden" name="modele" value="Dons">
            <button type="submit" name="choisir" class="<?= $active === 'dons' ? 'active' : '' ?>">
                <img src="/images/icons/don.png" alt="" class="sidebar-icon"> Dons
            </button>
        </form>
    </li>
    <li>
        <form method="post" action="/backoffice">
            <input type="hidden" name="modele" value="Produits">
            <button type="submit" name="choisir" class="<?= $active === 'produits' ? 'active' : '' ?>">
                <img src="/images/icons/produit.png" alt="" class="sidebar-icon"> Produits
            </button>
        </form>
    </li>
    <li>
        <form method="post" action="/backoffice">
            <input type="hidden" name="modele" value="Reservations">
            <button type="submit" name="choisir" class="<?= $active === 'reservations' ? 'active' : '' ?>">
                <img src="/images/icons/reservation.png" alt="" class="sidebar-icon"> Réservations
            </button>
        </form>
    </li>
    <li>
        <form method="post" action="/backoffice/logout">
            <button class="logout-btn" type="submit" name="logout">
                <img src="/images/icons/logout.png" alt="" class="sidebar-icon"> Déconnexion
            </button>
        </form>
    </li>
</ul>