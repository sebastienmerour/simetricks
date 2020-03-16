// Script pour ajouter des champs "Liens"
$(document).ready(function() {
    var max_fields = 5; // Nombre Maximum de Liens autorisés
    var wrapper    = $(".wrapper"); // Input fields wrapper
    var add_button = $(".add_fields"); // Ajout d'une classe ou d'un ID
    var x = 1; // Le premier input field est configuré sur 1

 // Quand le User clique sur le bouton d'ajout de champ dynamique
 $(add_button).click(function(e){
        e.preventDefault();
 // On vérifie le nombre maximum de input fields
        if(x < max_fields){
            x++;
 // OK On peut ajouter un input field :

//            $(wrapper).append($("#template").html());
//        }
//    });


                $(wrapper).append('<div><div class="row"><div class="col-4"><input class="form-control" id="linkname" name="linkname[]" placeholder="Nom du site" type="text"><br></div><div class="col-4"><input class="form-control" id="linkurl" name="linkurl[]" placeholder="http://" type="url"><br></div><div class="col-4"><button href="javascript:void(0);" class="btn btn-md btn-danger remove_field">-</button></div></div></div>');
            }
        });



    // Quand l'utilisateur ajoute sur le bouton de suppression de l'input filed :
    $(wrapper).on("click",".remove_field", function(e){
        e.preventDefault();
 $(this).parents().eq(2).remove();
 x--;
    })
});
