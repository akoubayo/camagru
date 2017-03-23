<?php
namespace App;

session_start();

ini_set('display_errors', 1);

$app = require_once('vendor/Autoloader/Autoloader.php');

use App\Route\Route;

$app = new Route();
/**
 * Les Routes pour les photos
 */
$app->auth(function ($app) {
    $app->get("/", "PictureController@index");
    $app->get("/takePicture", "PictureController@index");
    $app->post('/takePicture', "PictureController@takePicture");
    $app->delete('/takePicture/{id}', "PictureController@delete");
    $app->get("/showPictures", "PictureController@showAll");
    $app->get("/galerie", "PictureController@galerie");
    $app->get("/galerie/{id}", "PictureController@picture");
    $app->post("/commentaires", 'CommentairesController@create');
    $app->post("/like", "LikesController@addLikes");
}, "/connexion", "ConnexionController@index");

/**
 * Les routes de Connexion et oublie de mot de passe
 */

$app->get('/connexion', "ConnexionController@index");
$app->post('/connexion', "ConnexionController@connexion");
$app->post('/connexion/inscription', "ConnexionController@inscription");
$app->post('/connexion/forgot', 'ConnexionController@forgot');
$app->get('/deconnexion', 'ConnexionController@deco');
$app->get('/confirme/{id}/{hash}','ConnexionController@confirme');
$app->get('/changepass/{id}/{hash}', 'ConnexionController@changePass');
$app->post('/resetPassword', 'ConnexionController@resetPassword');
$app->defaultRoute("/", "ConnexionController@index");
