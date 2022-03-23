<?php
namespace connexion\connexion
{

    use Exception;

    class Connexion
    {

        static function getInstance()
        {
            static $dbh = NULL;
            if ($dbh == NULL) {
                $dsn = "mysql:host=localhost;dbname=openrgpd";
                $username = "openrgpd";
                $password = "openrgpd123";
                $option = array(
                    \PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
                );
                try {
                    $dbh = new \PDO($dsn, $username, $password, $option);
                } catch (Exception $e) {
                    $message="Probleme de connexion à la base de donnée :Redirection vers le site d'OpenRGPD";
            	echo '<script type="text/javascript">window.alert("' .$message.'");window.location="https://openrgpd.fr/"</script>'; ;
                }
            }
            return $dbh;
        }
    }
}

/***************************************************************
# Développé par : Service Informatique de la Ville de Saint-Avé,
# Informations disponible sur https://www.openrgpd.fr
# 04/07/2019
***************************************************************/
?>
