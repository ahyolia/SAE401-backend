// Récupération des données du panier depuis le localStorage
let panier = JSON.parse(localStorage.getItem('panier')) || [];

// S'assurer que chaque produit du panier a bien une propriété "category"
panier.forEach(p => {
    if (typeof p.category === 'undefined') {
        p.category = '';
    }
});
localStorage.setItem('panier', JSON.stringify(panier));

// Fonction pour afficher les produits dans le tableau
function afficherPanier() {
    panier = JSON.parse(localStorage.getItem('panier')) || []; // <-- recharge le panier
    const tableau = document.querySelector('#panier tbody');
    tableau.innerHTML = '';

    if (panier.length === 0) {
        tableau.innerHTML = '<tr><td colspan="5">Votre panier est vide.</td></tr>';
        return;
    }

    panier.forEach((produit, index) => {
        const ligne = document.createElement('tr');
        ligne.innerHTML = `
            <td><img src="${produit.image || '/images/default.png'}" alt="${produit.name || ''}" style="width: 50px; height: auto;"></td>
            <td>${produit.name || ''}</td>
            <td>
                <button class="btn-minus btn-cartoon" data-index="${index}">-</button>
                <input type="number" id="quantite-${index}" name="quantite-${index}" min="1" max="${produit.stock || 99}" value="${produit.quantity}" data-index="${index}" class="quantite">
                <button class="btn-plus btn-cartoon" data-index="${index}">+</button>
                <span style="font-size:12px;color:#888;">/ ${produit.stock || 99} en stock</span>
            </td>
            <td>
                <button class="supprimer" data-index="${index}">Supprimer</button>
            </td>
        `;
        // Ajout d'un écouteur pour synchroniser l'input quantité
        ligne.querySelector('.quantite').addEventListener('input', (event) => {
            let newQuantity = parseInt(event.target.value, 10);
            if (produit.stock && newQuantity > produit.stock) {
                newQuantity = produit.stock;
                event.target.value = newQuantity;
            }
            if (newQuantity > 0) {
                panier[index].quantity = newQuantity;
                localStorage.setItem('panier', JSON.stringify(panier));
                afficherPanier();
            }
        });
        tableau.appendChild(ligne);
    });

    ajouterEcouteurs();
    afficherJaugeAliments();
    updateCartCount();
}

// Réappliquer les écouteurs pour les boutons après chaque mise à jour du tableau
function ajouterEcouteurs() {
    // Écouteurs pour les boutons "+"
    document.querySelectorAll('.btn-plus').forEach(button => {
        button.onclick = (event) => {
            event.stopPropagation();
            const index = event.target.dataset.index;
            const produit = panier[index];
            const totalProduits = panier.reduce((total, item) => total + item.quantity, 0);

            if (produit.stock && panier[index].quantity >= produit.stock) {
                alert("Stock maximum atteint !");
                return;
            }
            if (totalProduits >= 5) {
                alert("Vous ne pouvez pas réserver plus de 5 produits au total.");
                return;
            }
            if (produit.category === 'alimentation' && !window.isAdherent && countAliments() >= 5) {
                alert("Vous ne pouvez pas réserver plus de 5 aliments.");
                return;
            }
            panier[index].quantity += 1;
            localStorage.setItem('panier', JSON.stringify(panier));
            afficherPanier();
        };
    });

    // Écouteurs pour les boutons "-"
    document.querySelectorAll('.btn-minus').forEach(button => {
        button.onclick = (event) => {
            event.stopPropagation();
            const index = event.target.dataset.index;
            if (panier[index].quantity > 1) {
                panier[index].quantity -= 1;
                localStorage.setItem('panier', JSON.stringify(panier));
                afficherPanier();
            }
        };
    });

    // Écouteurs pour les boutons "Supprimer"
    document.querySelectorAll('.supprimer').forEach(button => {
        button.onclick = (event) => {
            event.stopPropagation();
            const index = event.target.dataset.index;
            panier.splice(index, 1);
            localStorage.setItem('panier', JSON.stringify(panier));
            afficherPanier();
        };
    });
}

// Fonction pour vider le panier
function viderPanier() {
    panier = [];
    localStorage.setItem('panier', JSON.stringify(panier));
    afficherPanier();
    afficherJaugeAliments();
    updateCartCount(); // Ajoute ici aussi
}

// Ajout de l'écouteur pour le bouton "Vider le panier"
document.getElementById('btn-vider').addEventListener('click', viderPanier);
const btnViderNonAdherent = document.getElementById('btn-vider-nonadherent');
if (btnViderNonAdherent) {
    btnViderNonAdherent.addEventListener('click', viderPanier);
}

// Validation du panier
document.getElementById('btn-valider').addEventListener('click', () => {
    if (panier.length === 0) {
        alert('Votre panier est vide.');
    } else {
        fetch('/panier/valider', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(panier),
            credentials: 'include' 
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                // Pop-up de confirmation
                alert(data.message); // Remplace par ta modale si besoin
                panier = [];
                localStorage.setItem('panier', JSON.stringify(panier));
                afficherPanier();
                afficherJaugeAliments();
                updateCartCount();
            } else {
                // Pop-up d'erreur
                alert(data.message || 'Erreur lors de la validation.');
            }
        });
    }
});

// Met à jour les stocks et affiche le panier
function majStocksEtAfficherPanier() {
    fetch('/panier/stocks', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(panier)
    })
    .then(res => res.json())
    .then(stocks => {
        panier.forEach(p => {
            if (typeof stocks[p.id] !== 'undefined') {
                p.stock = stocks[p.id];
                if (p.quantity > p.stock) p.quantity = p.stock;
            }
        });
        localStorage.setItem('panier', JSON.stringify(panier));
        afficherPanier();
    });
}

// Initialisation de la page panier
function initialiserPanier() {
    majStocksEtAfficherPanier();
    ajouterEcouteurs();
}

// Charger le panier au démarrage de la page
document.addEventListener('DOMContentLoaded', initialiserPanier);

// Style pour masquer les flèches du champ number
const style = document.createElement("style");
style.textContent = `
    input[type="number"]::-webkit-inner-spin-button,
    input[type="number"]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
    input[type="number"] {
        -moz-appearance: textfield;
    }
`;
document.head.appendChild(style);

// Fonction pour compter les aliments dans le panier
function countAliments() {
    return panier.reduce((total, item) => {
        return item.category === 'alimentation' ? total + item.quantity : total;
    }, 0);
}

// Fonction pour afficher la jauge des aliments
function afficherJaugeAliments() {
    const jaugeDiv = document.getElementById('jauge-aliments');
    const nbProduits = panier.reduce((total, item) => total + item.quantity, 0);
    jaugeDiv.innerHTML = `
        <div style="margin:1em 0; display: flex; align-items: center;">
            <strong>Produits réservés : </strong> ${nbProduits} / 5
            <div style="background:#eee;flex:1;height:15px;border-radius:8px;overflow:hidden;display:inline-block;margin-left:1em;max-width:300px;">
                <div style="background:#27ae60;width:${Math.min(nbProduits/5,1)*100}%;height:100%;"></div>
            </div>
        </div>
    `;
}

// Fonction pour mettre à jour le compteur de produits dans le panier
function updateCartCount() {
    const cartCount = document.getElementById('cart-count');
    const panierLS = JSON.parse(localStorage.getItem('panier')) || [];
    if (cartCount) {
        cartCount.textContent = panierLS.reduce((total, item) => total + item.quantity, 0);
    }
}

// Fonction pour ajouter un produit au panier
function ajouterAuPanier(produit) {
    const index = panier.findIndex(p => p.id === produit.id);
    if (index !== -1) {
        // Le produit est déjà dans le panier, on met juste à jour la quantité
        panier[index].quantity += produit.quantity;
    } else {
        // Le produit n'est pas dans le panier, on l'ajoute
        panier.push(produit);
    }
    localStorage.setItem('panier', JSON.stringify(panier));
    afficherPanier();
}

// Exemple d'utilisation : ajouter un produit avec ID 123 au panier
// ajouterAuPanier({ id: 123, name: 'Produit 123', quantity: 1, price: 10.99, image: '/images/produit123.png' });

// Fonction pour valider le panier et envoyer les données au serveur
function validerPanier() {
    const panier = JSON.parse(localStorage.getItem('panier')) || [];
    if (panier.length === 0) {
        alert('Votre panier est vide.');
        return;
    }

    // Ici, vous pouvez ajouter des vérifications supplémentaires si nécessaire

    fetch('/panier/valider', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(panier),
        credentials: 'include' // <-- Obligatoire !
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            alert('Votre commande a été validée avec succès !');
            localStorage.removeItem('panier');
            afficherPanier();
        } else {
            alert('Erreur lors de la validation de la commande : ' + (data.message || 'Inconnue'));
        }
    })
    .catch(error => {
        console.error('Erreur lors de la validation du panier :', error);
        alert('Une erreur est survenue. Veuillez réessayer plus tard.');
    });
}