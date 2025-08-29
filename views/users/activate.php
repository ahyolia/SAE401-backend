<?php if (!empty($msg)): ?>
    <div class="alert" id="alert-msg"><?= $msg ?></div>
    <script>
        setTimeout(function() {
            var alert = document.getElementById('alert-msg');
            if(alert) alert.style.display = 'none';
        }, 1500);
    </script>
<?php endif; ?>

<a href="/" style="display:inline-block;margin-top:2em;">
    <button>Retour à l'accueil</button>
</a>