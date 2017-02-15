<?php

/**
 * Index file
 *
 * PHP Version 7.0
 *
 * @category Index
 * @package  Camagru
 * @author   Damien Altman <damien@tilkee.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     https://github.com/akoubayo/camagru
 */

namespace App;

session_start();

ini_set('display_errors', 1);

$app = require_once('vendor/Autoloader/Autoloader.php');

use App\Route\Route;
$app = new Route();

/**
 * Les Routes pour les photos
 */
$app->get("/", "PictureController@index");
$app->get("/takePicture", "PictureController@index");
$app->post('/takePicture', "PictureController@takePicture");

/**
 * Les routes de Connexion et oublie de mot de passe
 */

$app->get('/connexion', "ConnexionController@index");
$app->post('/connexion', "ConnexionController@connexion");
$app->post('/connexion/inscription', "ConnexionController@inscription");
