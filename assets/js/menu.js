// AutoCompletion -------------------------------------------------------------------------------------------------------------------
(function() {
    // On définit d'abord les variables dont on aura besoin
    var searchTag = document.querySelector('#search'),
    bigDiv        = document.querySelector('#searchDiv'),
    selectedResult = -1,  // Le -1 signifie qu'aucun résultat n'est sélectionné
    previousRequest,
    responses,
    previousValue = searchTag.value;

    // On définit la fonction getResult dont le rôle sera d'envoyer une requete AJAX et récupérer la réponse
    function getData() {
        var myResearch = document.querySelector('#myResearch'),
        formData = new FormData(myResearch),
        xhr = new XMLHttpRequest();

        // On définit quoi faire lorsque la réponse era obtenue...
        xhr.onload = function() {
            displayResponse(xhr.responseText);
        }
        // On envoie la requete AJAX et on retourne l'objet XHR
        xhr.open('POST', 'http://homework:800/Projects/Blog/CodeIgniter/ajaxing/search');
        xhr.send(formData);
        return xhr;
    }

    // La fonction displayResponse() affiche la réponse dans des div et met en place un évènement click sur ceux-ci
    function displayResponse(data) {
        if(data.length) {
            responses = data.split('|');
            var len   = responses.length;
            bigDiv.style.display = 'block';

            // On vide le container pour le nouvel affichage
            bigDiv.innerHTML = '';

            // On crée les div qui contiendront les réponses et on ajoute un CLICK event
            for(var i = 0, lilDiv; i < len; i++) {
                var lilDiv = document.createElement('div');
                lilDiv.innerHTML = responses[i];
                bigDiv.appendChild(lilDiv);

                lilDiv.addEventListener('click', function(e) {
                    //chooseResult(e.target);
                });
            }
        }
        else {
            bigDiv.style.display = 'none';
        }
    }

    // La fonction chooseResult - remplace la valeur du champ search par la valeur choisie
    function chooseResult(result) {
        searchTag.value = previousValue = result.innerHTML;
        bigDiv.style.display = 'none';
        result.className = '';
        // Enfin on remet le compteur à 0 pour la valeur sélectionnée
        selectedResult = -1;
        searchTag.focus();

    }

    // Enfin on met en place l'évènement KeyUp pour les touches bas, haut, Entrée et les autrs caractères
    searchTag.addEventListener('keyup', function(e) {
        var lilDivs = bigDiv.getElementsByTagName('div');

        if(e.keyCode == 38 && selectedResult > -1)                         // Touche HAUT
        {
            lilDivs[selectedResult--].className = '';
            if(selectedResult > -1) {
                lilDivs[selectedResult].className = 'focus';
            }
        }
        else if (e.keyCode == 40 && selectedResult <  lilDivs.length - 1)  // Touche BAS
        {
            bigDiv.style.display = 'block';
            if(selectedResult > -1) {
                lilDivs[selectedResult].className = '';
            }
            lilDivs[++selectedResult].className = 'focus';
        }
        else if(e.keyCode == 39 && selectedResult > -1)                   // Touche DROITE
        {
            chooseResult(lilDivs[selectedResult]);
        }
        else if(searchTag.value != previousValue)                       // Cas ou la valeur entrée != valeur initiale
        {
            previousValue = searchTag.value;
            if(previousRequest && previousRequest.readyState < XMLHttpRequest.DONE) {
                previousRequest.abort();
            }
            previousRequest = getData();
            selectedResult  = -1;
        }
    });
})();
//-----------------------------------------------------------------------------------------------------------------------------------
