<!DOCTYPE html>
<html>
<head>
    <title>Camagru</title>
    <link rel="stylesheet" type="text/css" href="/../../src/css/app.css">
</head>
<body>
    <?php if (isset($_SESSION['token'])) { ?>
    <div id="menu">
        <h3>Bonjour <?php if(isset($user)){echo $user->pseudo;} ?></h3>
        <ul>
            <li><a href="/takePicture">Prendre une photo</a></li>
            <li><a href="/galerie">Galerie des images</a></li>
            <li><a href="/deconnexion">Déconnexion</a></li>
        </ul>

    </div>
    <?php } else { ?>
    <div id="menuNone"></div>
    <?php }?>
    <div id="head">
        <h1>Camagru take beautiful pictures</h1>
    </div>
    <div id="body" style="">
        <?php include_once($view); ?>
    </div>
    <?php include_once('foot.php'); ?>
<script>
console.log(navigator);
if(navigator.geolocation)
{
    console.log(navigator.geolocation);
    navigator.geolocation.getCurrentPosition(showLocation, errorHandler);
}
else
{
    alert('Votre navigateur ne prend malheureusement pas en charge la géolocalisation.');
}
function showLocation(position)
{
    console.log(position);
}
function errorHandler(error)
{
    // On log l'erreur sans l'afficher, permet simplement de débugger.
    console.log('Geolocation error : code '+ error.code +' - '+ error.message);

    // Affichage d'un message d'erreur plus "user friendly" pour l'utilisateur.
    alert('Une erreur est survenue durant la géolocalisation. Veuillez réessayer plus tard ou contacter le support.');
}
var token = '';
</script>
<script type="text/javascript" src="/../../script/app.js"></script>
<script type="text/javascript" src="/script/dragAndResize.js"></script>
<script type="text/javascript" src="/script/captureWebcam.js"></script>
</body>
</html>
