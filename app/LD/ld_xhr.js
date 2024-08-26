/**
 * Lister les pôles et services en fonction d'une entité
 * XMLHTTPRequest.
 */
/* Création de la variable globale qui contiendra l'objet XHR */
var requete = null;
/**
 * Fonction privée qui va créer un objet XHR.
 * Cette fonction initialisera la valeur dans la variable globale définie
 * ci-dessus.
 */
function creerRequete() {
    try {
        /* On tente de créer un objet XmlHTTPRequest */
        requete = new XMLHttpRequest();
    } catch (microsoft) {
        /* Microsoft utilisant une autre technique, on essays de créer un objet ActiveX */
        try {
            requete = new ActiveXObject('Msxml2.XMLHTTP');
        } catch(autremicrosoft) {
            /* La première méthode a échoué, on en teste une seconde */
            try {
                requete = new ActiveXObject('Microsoft.XMLHTTP');
            } catch(echec) {
                /* À ce stade, aucune méthode ne fonctionne... mettez donc votre navigateur à jour ;) */
                requete = null;
            }
        }
    }
    if(requete == null) {
        alert('Impossible de créer l\'objet requête,\nVotre navigateur ne semble pas supporter les object XMLHttpRequest.');
    }
}

/**
 * Fonction privée qui va mettre à jour l'affichage de la page.
 */

function actualiserPole() {
    var listePol = requete.responseText;
    var blocListePol = document.getElementById('blocPoles');
    blocListePol.innerHTML = listePol;
}

function actualiserService() {
    var listeServ = requete.responseText;
    var blocListeServ = document.getElementById('blocServices');
    blocListeServ.innerHTML = listeServ;
}

function actualiserResponsable() {
    var listeResp = requete.responseText;
    var blocListeResp = document.getElementById('blocResp');
    blocListeResp.innerHTML = listeResp;
}

function actualiserGestionnaire() {
    var listeGest = requete.responseText;
    var blocListeGest = document.getElementById('blocGest');
    blocListeGest.innerHTML = listeGest;
}

/**
 * Fonction publique appelée par la page affichée.
 * Cette fonction va initialiser la création de l'objet XHR puis appeler
 * le code serveur afin de récupérer les données à modifier dans la page.
 */

function getmaj(value) {
	getPoles(value);
	getServices(value);
	getResponsable(value);
	getGestionnaire(value);
}

function getServices(idp){
    /* Si il n'y a pas d'identifiant de Pôle, on fait disparaître la seconde liste au cas où elle serait affichée */
    if(idp == '') {
        document.getElementById('blocServices').innerHTML = '';
    } else {
        /* À cet endroit précis, on peut faire apparaître un message d'attente */
        var blocListeServ = document.getElementById('blocServices');
        blocListeServ.innerHTML = "Traitement en cours, veuillez patienter...";
        /* On crée l'objet XHR */
        creerRequete();
        /* Définition du fichier de traitement */
        var url = 'ld.php?idp='+ idp;
        /* Envoi de la requête à la page de traitement */
        requete.open('GET', url, true);
        /* On surveille le changement d'état de la requête qui va passer successivement de 1 à 4 */
        requete.onreadystatechange = function() {
            /* Lorsque l'état est à 4 */
            if(requete.readyState == 4) {
                /* Si on a un statut à 200 */
                if(requete.status == 200) {
                    /* Mise à jour de l'affichage, on appelle la fonction apropriée */
                    actualiserService();
                }
            }
        };
        requete.send(null);
    }
}

function getPoles(ide) {
    if(ide == '') {
        document.getElementById('blocPoles').innerHTML = '';
    } else {
        var blocListePol = document.getElementById('blocPoles');
        blocListePol.innerHTML = "Traitement en cours, veuillez patienter...";
        creerRequete();
        var url = 'ld.php?ide='+ ide;
        requete.open('GET', url, true);
        requete.onreadystatechange = function() {
            if(requete.readyState == 4) {
                if(requete.status == 200) {
                    actualiserPole();
					getResponsable(ide);
                }
            }
        };
        requete.send(null);
    }
}

function getResponsable(idr){
    if(idr == '') {
		document.getElementById('blocResp').innerHTML = '';
    } else {
		var blocListeResp = document.getElementById('blocResp');
        blocListeResp.innerHTML = "Traitement en cours, veuillez patienter...";
        creerRequete();
        var url = 'ld.php?idr='+ idr;
        requete.open('GET', url, true);
        requete.onreadystatechange = function() {
            if(requete.readyState == 4) {
                if(requete.status == 200) {
					actualiserResponsable();
                }
            }
        };
        requete.send(null);
    }
}

/* Pour les droits d'accès utilisateur */
function getGestionnaire(idl){
    if(idl == '') {
        document.getElementById('blocGest').innerHTML = '';
    } else {
        var blocListeGest = document.getElementById('blocGest');
        blocListeGest.innerHTML = "Traitement en cours, veuillez patienter...";
        creerRequete();
        var url = 'ld.php?idl='+ idl;
        requete.open('GET', url, true);
        requete.onreadystatechange = function() {
            if(requete.readyState == 4) {
                if(requete.status == 200) {
                    actualiserGestionnaire();
                }
            }
        };
        requete.send(null);
    }
}