<link rel="stylesheet" href="/css/users/register.css">

<div class="inscription-hero">
    <div class="inscription-avatar">
        <img src="/images/user.png" alt="Avatar">
    </div>
    <div class="inscription-title" style="text-align:center; width:100%;">Inscription</div>
</div>

<div class="inscription-section">
    <?php if (!empty($msg)): ?>
        <div class="alert" id="alert-msg"><?= $msg ?></div>
        <script>
            setTimeout(function() {
                var alert = document.getElementById('alert-msg');
                if(alert) alert.style.display = 'none';
            }, 1500);
        </script>
    <?php endif; ?>
    <form method="POST" action="/users/register" id="register-form">
        <label>Vous êtes :</label>
        <div class="role-choice-group">
            <label for="role-etudiant">
                <input type="radio" name="role" value="etudiant" id="role-etudiant" required>
                Étudiant
            </label>
            <label for="role-particulier">
                <input type="radio" name="role" value="particulier" id="role-particulier" required>
                Particulier
            </label>
        </div>

        <div id="etudiant-fields" style="display:none;">
            <label>Numéro étudiant :</label>
            <input type="text" name="numero_etudiant">
            <label>Nom :</label>
            <input type="text" name="nom">
            <label>Prénom :</label>
            <input type="text" name="prenom">
            <label>Email :</label>
            <input type="email" name="email_etudiant">
            <label>Mot de passe :</label>
            <input type="password" name="password" id="password-etudiant" required>
            <label class="adhesion-checkbox">
                <input type="checkbox" name="adherent" value="1" id="adherent">
                Je souhaite être adhérent (200 F/an)
            </label>
        </div>

        <div id="particulier-fields" style="display:none;">
            <label>Nom :</label>
            <input type="text" name="nom_particulier">
            <label>Prénom :</label>
            <input type="text" name="prenom_particulier">
            <label>Email :</label>
            <input type="email" name="email_particulier">
            <label>Mot de passe :</label>
            <input type="password" name="password" id="password-particulier" required>
        </div>
        <div style="display: flex; justify-content: center; margin-top: 1.5em;">
            <button type="submit" class="btn-activation">S'inscrire</button>
        </div>
    </form>

    <div class="inscription-links">
        Déjà un compte ? <a href="/users/login">Se connecter</a>
    </div>
</div>

<script>
function updateRoleFields(value) {
    const etu = document.getElementById('etudiant-fields');
    const part = document.getElementById('particulier-fields');
    const pwdEtu = document.getElementById('password-etudiant');
    const pwdPart = document.getElementById('password-particulier');
    const adherent = document.getElementById('adherent');

    if (value === 'etudiant') {
        etu.style.display = 'block';
        part.style.display = 'none';
        pwdEtu.disabled = false;
        pwdPart.disabled = true;
        adherent.required = true; // rendre la case obligatoire
    } else if (value === 'particulier') {
        etu.style.display = 'none';
        part.style.display = 'block';
        pwdEtu.disabled = true;
        pwdPart.disabled = false;
        adherent.required = false; // ne pas la rendre obligatoire
    } else {
        etu.style.display = 'none';
        part.style.display = 'none';
        pwdEtu.disabled = true;
        pwdPart.disabled = true;
        adherent.required = false;
    }
}

document.getElementById('role-etudiant').addEventListener('change', function() {
    if (this.checked) updateRoleFields('etudiant');
});
document.getElementById('role-particulier').addEventListener('change', function() {
    if (this.checked) updateRoleFields('particulier');
});

// Désactive les deux au chargement
document.getElementById('password-etudiant').disabled = true;
document.getElementById('password-particulier').disabled = true;
updateRoleFields(); // cache les champs au chargement
</script>
