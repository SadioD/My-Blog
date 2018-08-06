$(function() {
    // Ce code permet de réinitialiser le Password ----------------------------------------------------------------------------------
    // Crée un event SUBMIT , supprime le message déjà affiché et appelle la fonction AJAX
    $('#resetForm').submit(function(e) {
        typeof($('#ajaxResponse').get()[0]) !== 'undefined' ? $('#ajaxResponse').remove() : '';
        $('<img id = "myGif" src = "http://homework:800/Projects/Blog/CodeIgniter/assets/images/ajax-loader.gif" /><span id = "space"> </span>').prependTo('button')[0];
        e.preventDefault();
        resetPassword();
    });
    // Envoi la requete Ajax
    function resetPassword() {
        var formData = new FormData($('#resetForm').get()[0]);
        $.ajax({
            method: 'POST',
            url: 'http://homework:800/Projects/Blog/CodeIgniter/ajaxing/resetPass',
            processData: false,
            contentType: false,
            data: formData,
            dataType: 'json',
            error: function(xhr) {
                displayResponse(xhr);
            },
            success: function(response) {
                displayResponse(response);
                //console.log(response)
            }
        });
    }
    // Affiche la réponse du serveur
    function displayResponse(data) {
        if(data.keyWord == 'userNotFound' || data.keyWord == 'emailNotSent') {
            $('<span id = "ajaxResponse"><i class="fa fa-times"></i> ' + data.response + '</span>').prependTo($('.flashMessage'));
            $('#ajaxResponse').css({color: 'red', fontStyle: 'italic'});
        }
        else if(data.keyWord == 'emailSent') {
            $('<span id = "ajaxResponse"><i class="fa fa-check"></i>' + data.response + '</span>').prependTo($('.flashMessage'));
            $('#ajaxResponse').css({color: 'green', fontStyle: 'italic'});
        }
        else {
            $('<span id = "ajaxResponse"><i class="fa fa-times"></i> Oups.. Une erreur est survenue - ' + data.statusText + '</span>').prependTo($('.flashMessage'));
            $('#ajaxResponse').css({color: 'red', fontStyle: 'italic'});
        }
        $('#myGif, #space').remove();
        //console.log(data)
    }
    //----------------------------------------------------------------------------------------------------------------------------------
});
