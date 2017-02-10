<!DOCTYPE html>
<html>
<head>
    <title>Camagru</title>
    <link rel="stylesheet" type="text/css" href="/../../src/css/app.css">
</head>
<body>
    <?php if (isset($_SESSION['pseudo'])) { ?>
    <div id="menu">
        Menu
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
<script type="text/javascript" src="/../../script/app.js"></script>
<script type="text/javascript" src="/script/dragAndResize.js"></script>
<script type="text/javascript" src="/script/captureWebcam.js"></script>
</body>
</html>
