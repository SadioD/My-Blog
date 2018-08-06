// Boutton DELETE ----------------------------------------------------------------------------------------------------------------
(function() {
    // Mise en place de l'évènement CLICK
    var links = document.querySelectorAll('.links'),
    len       = links.length;

    for(var i = 0; i < len; i++) {
        links[i].lastElementChild.addEventListener('click', function(e) {
            e.preventDefault();
            if(confirm('voulez vous vraiment supprimer ce Post?')) {

                deletePost(this);
            }
            else {

            }
        });
    }

    // On définit la fonction DE SUPPRESSION - AJAX
    function deletePost(element) {
        var xhr = new XMLHttpRequest();

        xhr.onprogress = function() {
            setOverlayON();            // Overlay ne marche pas avec alert et confirm, le mieux c'est de créer une div (z-index 2)
            displayLoadingMessage();
        };

        xhr.onload = function() {
            setOverlayOFF();
            removeLoadingMessage();
            displayResponse(element, xhr.responseText);
        };

        xhr.open('GET', 'http://homework:800/Projects/Blog/CodeIgniter/ajaxing/deletePost/' + element.id);
        xhr.send(null);
    }

    // On définit la fonction qui affiche la Réponse (message de succès + chargement de derniers Posts)
    function displayResponse(element, response) {
        var span    = document.querySelector('#ajaxBox'),
        len         = response.length,
        deleteLink  = document.getElementById(element.id);

        // On affiche le message flash de succès
        span.innerHTML     = response;
        span.style.display = 'block';
        span.style.color   = 'green';

        // On masque la div correspondant à la News supprimée
        deleteLink.parentNode.parentNode.style.display = 'none';
    }

    // On définit les fonctions OVERLAY
    function setOverlayON() {
        document.getElementById("setOverlay").style.display = "block";
    }
    function setOverlayOFF() {
        document.getElementById("setOverlay").style.display = "none";
    }

    // On définit les fonctions loading message pendant le traitement AJAX
    function displayLoadingMessage() {
        document.getElementById("progressDiv").style.display = "block";
    }
    function removeLoadingMessage() {
        document.getElementById("progressDiv").style.display = "none";
    }
})();
//-------------------------------------------------------------------------------------------------------------------------------
