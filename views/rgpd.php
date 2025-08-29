<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>RGPD – EPISE</title>
  <link rel="stylesheet" href="/css/layout.css">
  <style>
    body {
      background: #f9f9f9;
      color: #222;
      font-family: Arial, sans-serif;
      margin: 0;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }
    .rgpd-container {
      max-width: 1000px;
      margin: 3em auto 2em auto;
      background: #fff;
      border-radius: 18px;
      box-shadow: 0 2px 16px rgba(61,214,225,0.12);
      padding: 3em 2.5em 2.5em 2.5em;
      border-left: 10px solid #61D6E1;
    }
    .rgpd-container h1 {
      color: #3AD9A9;
      font-size: 2.3em;
      margin-bottom: 0.7em;
      text-align: center;
      letter-spacing: 1px;
    }
    .rgpd-container h2 {
      color: #3BAFE2;
      font-size: 1.35em;
      margin-top: 2em;
      margin-bottom: 0.5em;
      border-left: 4px solid #3AD9A9;
      padding-left: 0.5em;
    }
    .rgpd-container h3 {
      color: #18876A;
      font-size: 1.15em;
      margin-top: 1.5em;
      margin-bottom: 0.5em;
    }
    .rgpd-container ul {
      margin: 0.5em 0 1em 1.5em;
    }
    .rgpd-container a {
      color: #3BAFE2;
      text-decoration: underline;
      transition: color 0.2s;
    }
    .rgpd-container a:hover {
      color: #18876A;
    }
    .rgpd-container section {
      margin-bottom: 1.5em;
    }
    .rgpd-container p, .rgpd-container li {
      font-size: 1.08em;
      line-height: 1.7;
    }
    .rgpd-container .back-home {
      display: flex;
      justify-content: center;
      align-items: center;
      margin: 3em auto 0 auto;
      background: #3AD9A9;
      color: #fff;
      padding: 1.2em 3.5em;
      border-radius: 40px;
      font-weight: bold;
      font-size: 1.35em;
      text-decoration: none;
      transition: background 0.2s;
      box-shadow: 0 2px 12px rgba(61,214,225,0.10);
      text-align: center;
      letter-spacing: 1px;
      width: fit-content;
    }
    .rgpd-container .back-home:hover {
      background: #3BAFE2;
      color: #fff;
    }
    @media (max-width: 700px) {
      .rgpd-container {
        max-width: 98vw;
        padding: 1.2em 0.5em;
      }
      .rgpd-container .back-home {
        font-size: 1.1em;
        padding: 1em 1.5em;
      }
    } 
  </style>
</head>
<body>
  <div class="rgpd-container">
    <h1>Protection des données personnelles (RGPD)</h1>

    <section>
      <h2 id="rgpd">Données personnelles</h2>
      <p>Les données personnelles collectées, telles que le nom, le prénom, l’adresse e-mail universitaire et le numéro étudiant, sont utilisées uniquement pour la gestion de l’accès à l’épicerie solidaire. L’historique des réservations est également enregistré et conservé sur une période glissante d’un an, c’est-à-dire que chaque réservation est conservée pendant un an à compter de sa date. Le traitement de ces données repose sur le consentement de l’utilisateur, et la Mission Vie Étudiante – EPISE en est responsable. Seul le personnel habilité de l’UNC a accès à ces informations, qui ne sont jamais transmises à des tiers.</p>
    </section>

    <section>
      <h3>Vos droits</h3>
      <p>Conformément au RGPD, vous pouvez à tout moment exercer vos droits :</p>
      <ul>
        <li>Accès à vos données</li>
        <li>Rectification ou suppression</li>
        <li>Limitation ou opposition au traitement</li>
        <li>Portabilité de vos données</li>

      </ul>
      <p>Pour toute demande : <a href="mailto:epise@unc.nc">epise@unc.nc</a></p>
    </section>

    <a href="/" class="back-home">Retour à l'accueil</a>
  </div>
</body>
</html>
