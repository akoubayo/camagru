<div id="pannelConnexion">
<!-- Pannel de connexion -->
    <form id="formConnexion" method="post" action="/resetPassword">
        <h1 style="text-align: center">Modifier votre mot de passe</h1>
        <label>
            Nouveau mot de passe :
        </label>
        <input type="password" name="pass" placeholder="************">
        <label>
            Répetez votre mot de passe :
        </label>
        <input type="password" name="passTwo" placeholder="************">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <input type="hidden" name="hash" value="<?php echo $hash; ?>">
        <input type="submit" name="connexion" value="Se connecter">
        <span id="right"><a href="#" onclick="inscription()">S'inscrire</a> | <a href="#" onclick="forgot()">Mot de passe oublié</a></span>
    </form>
</div>
