<?php
if (!isset($_SESSION['identifiant'])){
    header('Location: index.php');
    exit();
} else if (($_SESSION['admin']) == "contributeur") {
    header('Location: visu.php');
    exit();
}
?> 