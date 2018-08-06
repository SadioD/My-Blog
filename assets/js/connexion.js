$(function() {
    // Ce code JS est venu avec le Formulaire --------------------------------------------------------------------------------------------
    $('.form').find('input, textarea').on('keyup blur focus', function (e) {

      var $this = $(this),
          label = $this.prev('label');

    	  if (e.type === 'keyup') {
    			if ($this.val() === '') {
              label.removeClass('active highlight');
            } else {
              label.addClass('active highlight');
            }
        } else if (e.type === 'blur') {
        	if( $this.val() === '' ) {
        		label.removeClass('active highlight');
    			} else {
    		    label.removeClass('highlight');
    			}
        } else if (e.type === 'focus') {

          if( $this.val() === '' ) {
        		label.removeClass('highlight');
    			}
          else if( $this.val() !== '' ) {
    		    label.addClass('highlight');
    			}
        }

    });

    $('.tab a').on('click', function (e) {

      e.preventDefault();

      $(this).parent().addClass('active');
      //$(this).parent().siblings().removeClass('active');
      $(this).parent().parent().css('background', 'rgb(0, 133, 161)');
      $(this).css('color', 'white');
      $(this).parent().parent().siblings().css('background', 'rgba(255, 255, 255, 0.6)');
      $(this).parent().parent().siblings().children().children().css('color', 'black');

      target = $(this).attr('href');

      $('.tab-content > div').not(target).hide();

      $(target).fadeIn(600);

    }); //----------------------------------------------------------------------------------------------------------------------------------

    //La partie ci-dessous gère les champs --------------------------------------------------------------------------------------------------
    (function() {
        var myRegex = /[a-z0-9]+/i,
        emailReg    = /[a-z0-9._-]+@[a-z0-9._-]{2,}.[a-z]{2,4}/,
        passReg     = /[a-z0-9._-]{6,}/;

        // Valide les champs
        function setValid(element) {
            element.attr('class', 'form-control is-valid');
            element.next().html('');
            return true;
        }
        // Invalide les champs
        function setInvalid(element, message) {
            element.attr({class: 'form-control is-invalid', placeholder: ''});
            element.next().html(message);
            return false;
        }
        // vérifie que les champs prenom, nom, email et passwod sont conformes aux Regex
        function checkString(element) {
            if(element.attr('id') == 'prenom' || element.attr('id') == 'nom') {
                return myRegex.test(element.val())  ? setValid(element) : setInvalid(element, 'Les champs "Prénom" et "Nom" sont requis!');
            }
            else if(element.attr('id') == 'firstEmail'){
                return emailReg.test(element.val()) ? setValid(element) : setInvalid(element, 'Le champ "Email" n\'est pas valide!');
            }
            else if($(element).attr('id') == 'firstPass') {
                return passReg.test(element.val()) ? setValid(element) : setInvalid(element, 'Le champ "Password" n\'est pas valide!');
            }
         }
        // Compare les deux emails et les deux password
        function checkMatch(firstElement, sndElement) {
            if(firstElement.val() === sndElement.val()) {
                return setValid(sndElement);
            }
            else {
                if(sndElement.attr('id') == 'sndEmail') {
                    return setInvalid(sndElement, 'Les deux adresses email ne sont pas identiques!');
                }
                else if(sndElement.attr('id') == 'sndPass') {
                    return setInvalid(sndElement, 'Les deux passwords ne sont pas identiques!');
                }
            }
        }
        // Met en place les évènements
        function checkSignUpForm() {
            // Vérification ONBLUR
            $('#nom, #prenom, #firstEmail, #firstPass').on('blur', function(e) {
                checkString($(e.target));
            });
            $('#sndEmail').blur(function() {
                checkMatch($('#firstEmail'), $('#sndEmail'));
            });
            $('#sndPass').blur(function() {
                checkMatch($('#firstPass'), $('#sndPass'));
            });

            // Vérification à l'envoi du formulaire
            $('#signUpForm').submit(function(e) {
                $('input').not('#search, #sndEmail, #sndPass, #email, #password').each(function() {
                    if(!checkString($(this))) {
                        e.preventDefault();
                        return false;
                    }
                });
                $('#sndPass, #sndEmail').each(function() {
                    if(!checkMatch($($(this).parent().prev('.field-wrap').find('input')[0]), $(this))) {
                        e.preventDefault();
                        return false;
                    }
                });
            });
        }
        checkSignUpForm();
    })();//---------------------------------------------------------------------------------------------------------------------------------------
});
