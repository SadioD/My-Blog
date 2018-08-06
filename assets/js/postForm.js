// FORMULAIRE CONTROLE AJOUT POST ------------------------------------------------------------------------------------------
(function() {
    var checkField,
    titre    = document.querySelector('#titre'),
    text     = document.querySelector('#texte'),
    myRegex  = /[a-z0-9]+/i;

    // On définit les fonctions qui permettent d'éviter de dupliquer le code
     function checkString(element) {
         if(myRegex.test(element.value)) {
            element.nextElementSibling.innerHTML = '';
            element.className = 'form-control is-valid';
         }
         else {
            element.nextElementSibling.innerHTML = 'Le champ est requis!';
            element.className = 'form-control is-invalid';
         }
     }

    // On définit la fonction qui vérifie le formulaire
    var load = {
        inputsRules: function() {
            titre.addEventListener('focus', function() {
                checkString(titre);
            });
            titre.addEventListener('keyup', function() {
                checkString(titre);
            });
            text.addEventListener('focus', function() {
                checkString(text);
            });
            text.addEventListener('keyup', function() {
                checkString(text);
            });
        },
        // Fichier Joint
        uploadRules: function() {
            document.querySelector('#fichier').addEventListener('change', function() {
                var error    = document.querySelector('#errorUpload'),
                allowedTypes = ['pdf', 'doc'],
                uploadedFile = this.files[0].name.split('.');
                uploadedFile = uploadedFile[uploadedFile.length - 1].toLowerCase();

                if(this.files[0].size >= 100000) {
                    error.innerHTML = 'le fichier choisit est trop lourd - Taille max 100Ko';
                    error.className = 'errorUpload';
                }
                else if(allowedTypes.indexOf(uploadedFile) == -1) {
                    error.innerHTML = "l'extension du fichier n'est pas autorisée - doc|pdf";
                    error.className = 'errorUpload';
                }
            });
        },
        // On définit les règles de soumission du formulaire
        submitRules: function(element) {
            if(!myRegex.test(element.value)) {
                element.focus();
            }
        },
        // On met en place l'évenement SUBMIT
        submitCheck: function() {
            document.querySelector('#myForm').addEventListener('submit', function(e) {
                if(!myRegex.test(titre.value) || !myRegex.test(text.value)) {
                    e.preventDefault();
                    load.submitRules(titre);
                    load.submitRules(text);
                }
                else if(document.querySelector('#errorUpload').className == 'errorUpload') {
                    e.preventDefault();
                    load.uploadRules();
                }
            });
        },
        // on initialise le contrôle du formulaire
        checkFields: function() {
            load.inputsRules();
            load.uploadRules();
            load.submitCheck();

       }
    };
    load.checkFields();
})();//------------------------------------------------------------------------------------------------------------------------
