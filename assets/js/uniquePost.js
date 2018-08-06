// BOUTTON LIKE and HATE --------------------------------------------------------------------------------------------------
// Requete Ajax pour afficher les nombres de Likes et Hates
(function() {
    var load = {
        // Met en place l'évènement CLICK et envoie une requete AJAX
        ajaxing: function(element, socialPluggin) {
            for(var i = 0, c = element.length; i < c; i++) {
                element[i].addEventListener('click', function(e) {
                    e.preventDefault();
                    var myTarget = this;

                    // AJAX - Mise en place de l'évènement ReadyStateChange
                    var xhr = new XMLHttpRequest();
                    xhr.addEventListener('readystatechange', function() {
                        if(xhr.readyState == XMLHttpRequest.DONE && xhr.status == 200)
                        {
                            // Si la requete est OK on récupère la réponse au format JSON
                            // On l'affiche dans le bon boutton suivant le statut(liked, hated, none)
                            var response = JSON.parse(xhr.responseText);
                            if(socialPluggin == 'liked') {
                                if(response.status == 'liked') {
                                    myTarget.innerHTML = '<i class="fa fa-check"></i> <span id = "' + response.idMembre + '">' + response.liked + '</span>';
                                }
                                else {
                                    myTarget.innerHTML = '<i class="fa fa-thumbs-up icon"></i> <span id = "' + response.idMembre + '">' + response.liked + '</span>';
                                }
                                myTarget.nextElementSibling.innerHTML = '<i class="fa fa-thumbs-down icon"></i> <span id = "' + response.idMembre + '">' + response.hated + '</span>';
                            }
                            else if(socialPluggin == 'hated') {
                                if(response.status == 'hated') {
                                    myTarget.innerHTML = '<i class="fa fa-check"></i> <span id = "' + response.idMembre + '">' + response.hated + '</span>';
                                }
                                else {
                                    myTarget.innerHTML = '<i class="fa fa-thumbs-down icon"></i> <span id = "' + response.idMembre + '">' + response.hated + '</span>';
                                }
                                myTarget.previousElementSibling.innerHTML = '<i class="fa fa-thumbs-down icon"></i> <span id = "' + response.idMembre + '">' + response.liked + '</span>';
                            }
                        }
                    });
                    // AJAX - Envoi requete GET avec paramètre
                    xhr.open('GET', 'http://homework:800/Projects/Blog/CodeIgniter/ajaxing/socialButtons/' + socialPluggin + '/' + myTarget.id + '/' + myTarget.firstElementChild.nextElementSibling.id);
                    xhr.send(null);
                });
            }
        },
        // Renvoie le nouveau nombre de likes (via AJAX)
        likesPlugin: function() {
            var likes     = document.querySelectorAll('.like');
            load.ajaxing(likes, 'liked');
        },
        // Renvoie le nouveau nombre de hates (via AJAX)
        hatesPluggin: function() {
            var hates     = document.querySelectorAll('.hate');
            load.ajaxing(hates, 'hated');
        }
    };
    // Initialisation des fonctions
    load.likesPlugin();
    load.hatesPluggin();
})();
//-------------------------------------------------------------------------------------------------------------------------
// FORMULAIRE CONTROLE AJOUT COMENTAIRE ------------------------------------------------------------------------------------------
(function() {
    var form = document.querySelector('#myForm'),
    text     = document.querySelector('#textArea'),
    error    = document.getElementById('errorMessage'),
    myRegex  = /[a-z0-9]+/i;

    // Si la Personne est connectée on crée les fonctions de controle des champs
    if(form)
    {
        // On définit les fonctions qui permettent d'éviter de dupliquer le code
         var checkString = function() {

             //if(text.value == '' || text.value.length < 1 || text.value == ) {
             if(myRegex.test(text.value)) {
                 text.className = 'form-control is-valid';
                 error.innerHTML = '';
             }
             else {
                 text.className = 'form-control is-invalid';
                 error.innerHTML = 'Le champ est requis!';
             }
         };
        // Mise en place des évènements FOCUS - KEYUP - SUBMIT
        text.addEventListener('focus', function() {
            checkString();
        });
        text.addEventListener('keyup', function() {
            checkString();
        })
        form.addEventListener('submit', function(e) {
            if(!myRegex.test(text.value)) {
                e.preventDefault();
                text.focus();
            }
        });
    }
})();//------------------------------------------------------------------------------------------------------------------------
