<div id="pannelConnexion">
<!-- Pannel de connexion -->
    <form id="formConnexion" method="post" action="/connexion">
        <h1 style="text-align: center">Se connecter à Camagru</h1>
        <label>
            Votre Pseudo :
        </label>
        <input type="text" name="pseudo" placeholder="Entrez votre pseudo">
        <label>
            Votre mot de passe :
        </label>
        <input type="password" name="pass" placeholder="************">
        <input type="submit" name="connexion" value="Se connecter">
        <span id="right"><a href="#" onclick="inscription()">S'inscrire</a> | <a href="#" onclick="forgot()">Mot de passe oublié</a></span>
    </form>
    <!-- Mot de passe oublié -->
    <form id="formForgot" action="/connexion/forgot" method="post" style="display: none">
        <h1 style="text-align: center">Mot de passe oublié</h1>
        <label>
            Votre adresse mail :
        </label>
        <input type="email" name="email" placeholder="Entrez votre adresse mail">
        <input type="submit" name="connexion" value="Se connecter">
        <span id="right"><a href="#" onclick="inscription()">S'inscrire</a> | <a href="#" onclick="connexion()">Se connecter</a></span>
    </form>
    <!-- Formulaire d'inscription-->
    <form id="formInsc" action="/connexion/inscription" method="post" style="display: none">
        <h1 style="text-align: center">S'inscrire</h1>
        <label>
            Votre pseudo :
        </label>
        <input type="text" name="pseudo" placeholder="Entrez votre pseudo">
        <label>
            Votre adresse mail :
        </label>
        <input type="email" name="mail" placeholder="Entrez votre adresse mail">
        <label>
            Votre mot de passe :
        </label>
        <input type="password" name="pass" placeholder="*************">
        <label>
            Confirmer votre mot de passe :
        </label>
        <input type="password" name="passTwo" placeholder="*************">

        <input type="submit" value="Se connecter">
        <span id="right"><a href="#" onclick="forgot()">Mot de passe oublié</a> | <a href="#" onclick="connexion()">Se connecter.</a></span>
    </form>
    <div>
    <?php if(isset($_GET['valide']) == true) { ?>
        <h3 style="">Un email de confirmation vient de vous être envoyé.</h3>
        <p>Pour confirmer votre inscription veuillez cliquer sur le lien présent dans le mail.</p>
    <?php } ?>
    </div>
</div>
<script>

</script>
