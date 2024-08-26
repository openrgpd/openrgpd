<?php
if (!isset($_SESSION['identifiant'])){
    header('Location: index.php');
    exit();
}
# permet d'inclure les lib en dépendances sur toutes les pages
require_once __DIR__ . '/../vendor/autoload.php';
?>