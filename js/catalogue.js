// Initialisation du panier à partir du localStorage ou d'un tableau vide
let panier = JSON.parse(localStorage.getItem('panier')) || [];

// Mise à jour du compteur d'articles dans le panier
function updateCartCount() {
    const cartCount = document.getElementById('cart-count');
    if (cartCount) {
        cartCount.textContent = panier.reduce((total, item) => total + item.quantity, 0);
    }
}

function countAliments() {
    return panier.reduce((total, item) => {
        return item.category === 'alimentation' ? total + item.quantity : total;
    }, 0);
}

// Fonction pour ajouter un produit au panier
function addToCart(product, quantite = 1) {
    // Limite pour les aliments
    if (product.category === 'alimentation') {
        const nbAliments = countAliments();
        if (!window.isAdherent && nbAliments + quantite > 5) {
            alert("Vous ne pouvez pas réserver plus de 5 aliments.");
            return;
        }
    }
    // Vérifie si le produit existe déjà dans le panier (par id)
    const existingProduct = panier.find(item => item.id === product.id);
    if (existingProduct) {
        // Limite pour les aliments si déjà présent
        if (product.category === 'alimentation' && !window.isAdherent && countAliments() + quantite > 5) {
            alert("Vous ne pouvez pas réserver plus de 5 aliments.");
            return;
        }
        // Mise à jour de la quantité sans dépasser le stock
        existingProduct.quantity = Math.min(existingProduct.quantity + quantite, product.stock || 99);
        // Mise à jour des autres propriétés si besoin
        existingProduct.name = product.name;
        existingProduct.image = product.image;
        existingProduct.category = product.category;
        existingProduct.stock = product.stock;
        existingProduct.price = product.price;
    } else {
        // Ajoute toutes les propriétés nécessaires pour le panier
        panier.push({
            id: product.id,
            name: product.name,
            image: product.image,
            category: product.category || '',
            stock: product.stock || 99,
            price: product.price || 0,
            quantity: quantite
        });
    }
    localStorage.setItem('panier', JSON.stringify(panier));
    updateCartCount();
    alert(`${product.name} (${quantite}) a été ajouté au panier !`);
    if (typeof afficherJaugeAliments === 'function') afficherJaugeAliments();
}

// Tout le code DOM dans DOMContentLoaded
document.addEventListener('DOMContentLoaded', function() {
    // Gestion des boutons + et - pour la quantité
    document.querySelectorAll('.quantity-controls').forEach(container => {
        const minusBtn = container.querySelector('.quantity-btn:first-child');
        const plusBtn = container.querySelector('.quantity-btn:last-child');
        const quantity = container.querySelector('.quantity');

        minusBtn.addEventListener('click', () => {
            let val = parseInt(quantity.textContent);
            if (val > 1) quantity.textContent = val - 1;
        });

        plusBtn.addEventListener('click', () => {
            let val = parseInt(quantity.textContent);
            quantity.textContent = val + 1;
        });
    });

    // Ajout des écouteurs d'événements sur chaque bouton "Ajouter au panier"
    document.querySelectorAll('.add-to-cart').forEach((button) => {
        button.addEventListener('click', (event) => {
            if (button.disabled) {
                event.preventDefault();
                return;
            }
            const productElement = event.target.closest('.product-card');
            let productName = '';
            if (productElement) {
                const h4 = productElement.querySelector('h4');
                if (h4) {
                    productName = h4.textContent;
                }
            }
            // Récupère la quantité depuis le span.quantity
            const quantitySpan = productElement.querySelector('.quantity-controls .quantity');
            let qty = quantitySpan ? parseInt(quantitySpan.textContent, 10) : 1;
            if (qty < 1) qty = 1;

            // Construction de l'objet produit avec toutes les propriétés nécessaires
            const product = {
                id: productElement ? productElement.dataset.id : '',
                name: productName,
                image: productElement ? productElement.querySelector('img').src : '',
                category: productElement ? (productElement.dataset.category || '').toLowerCase() : '',
                stock: productElement ? parseInt(productElement.dataset.stock, 10) : 99,
                price: productElement ? parseInt(productElement.dataset.price, 10) || 0 : 0
            };
            if (qty > product.stock) qty = product.stock;
            addToCart(product, qty);
        });
    });

    const searchForm = document.getElementById('search-form');
    const searchInput = document.getElementById('search-input');
    if (!searchInput) return;

    // Empêche le submit du formulaire
    searchForm.addEventListener('submit', function(e) {
        e.preventDefault();
        filterProducts();
    });

    // Filtre aussi à chaque saisie
    searchInput.addEventListener('input', filterProducts);

    function filterProducts() {
        const search = searchInput.value.toLowerCase().trim();
        const keywords = search.split(/\s+/).filter(Boolean);

        document.querySelectorAll('.product-card').forEach(function(prod) {
            const name = prod.querySelector('h4').textContent.toLowerCase();
            const desc = prod.querySelector('p') ? prod.querySelector('p').textContent.toLowerCase() : '';
            // Un produit est affiché si au moins un mot-clé est présent dans le nom ou la description
            const match = keywords.length === 0 || keywords.some(kw => name.includes(kw) || desc.includes(kw));
            prod.style.display = match ? '' : 'none';
        });
    }

    const categoryBtns = document.querySelectorAll('.category-btn');
    const productCards = document.querySelectorAll('.product-card');

    categoryBtns.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            // Active le bouton sélectionné
            categoryBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            const cat = this.dataset.category;
            // Affiche/masque les produits
            productCards.forEach(card => {
                if (cat === 'all' || card.dataset.category === cat) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    });
    updateCartCount();
    if (typeof afficherJaugeAliments === 'function') afficherJaugeAliments();

    // Bouton retour en haut de page
    const btnTop = document.getElementById('btn-top');
    if (btnTop) {
        window.addEventListener('scroll', function() {
            if (window.scrollY > 0) {
                btnTop.style.display = 'flex';
            } else {
                btnTop.style.display = 'none';
            }
        });
        btnTop.addEventListener('click', function() {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    }
});