$(function() {
    // Ce code JS permet de check le formulaire grace au pluggin "ValidationForm" ----------------------------------------------------------------------------------
    // Adresse Documentation https://jqueryvalidation.org/documentation/
    // cette méthode doit être ajoutée au pluggin pour ensuite la déclarer dans la fonction Validate()
    $.validator.addMethod('filesize', function (value, element, param) {
        return this.optional(element) || (element.files[0].size <= param)
    }, 'la taille du fichier doit être inférieure à 500 Ko');

    $("#updateForm").validate({
        rules: {
            pseudo:      { minlength: 3, required: true },
            nom:         { minlength: 3, required: true },
            firstEmail:  { email: true,  required: true },
            sndEmail:    { equalTo: "#firstEmail" },
            firstPass:   { minlength: 6, required: true },
            sndPass:     { equalTo: "#firstPass" },
            preferences: { minlength: 10 },
            photo:       { extension: "png|jpg", filesize: 500000 }
        }
    });
    //----------------------------------------------------------------------------------------------------------------------------------
});
