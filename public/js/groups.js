$(document).ready(function() {
//gestion dynamique de la fenêtre modale de "+ détails" des groupes créées

    $(document).on('click', '.open', function () {
        var group_id = $(this).data('id-group');
        var user = $(this).data('user');
        var group_name = $(this).data('name');
        var html='';

        user.forEach(utilisateur => {

            if (utilisateur.id_group == group_id) {
                console.log(utilisateur.username);
                html += '<tr>';
                html += '<td>' + utilisateur.id + '</td>';
                html += '<td>' + utilisateur.name + '</td>';
                html += '<td>' + utilisateur.surname + '</td>';
                html += '<td><button data-toggle="modal" data-target="#modal_suppr_utilisateur" type="button" name="remove" class="btn btn-danger btn-sm remove"><span class="glyphicon "></span></button></td></tr>';
                html += '</tr>';
            }
        });

        $(".modal-body #id_group").val(group_id);
        $(".modal-body #item_table").empty().append(html);
        $(".modal-body #group_name").empty().append(group_name);

    });

    /////////////////////////////////////////////
    //Modifier le nom d'un groupe
    $(document).on('click', '.change', function (){
        console.log(document.getElementById('form_change_group_name'));
        $id =document.getElementById('id_group').value;
        document.getElementById('form_change_group_name').action= 'group/change_name/'+$id;
        return confirm('Êtes-vous sûr de modifier le nom du group');
    });
    ////////////////////////////////////////////


    /////////////////////////////////////////////
    //Retirer un utilisateur d'un groupe
    $(document).on('click', '.remove', function (){
        console.log($(this).closest('tr').find('td:first-child').text());
        console.log(document.getElementById('id_group').value);
        document.getElementById('link_suppr_user').href= '/group/delete_user/'+$(this).closest('tr').find('td:first-child').text()+'/'+document.getElementById('id_group').value;
    });
    ////////////////////////////////////////////

    //gestion dynamique de la fenêtre modale de "Supprimer" des groupes créées
    /////////////////////////////////////////////
    //Supprimer un groupe
    $(document).on('click', '.suppr_group', function (){
        console.log(document.getElementById('id_group').value);
        $id=document.getElementById('id_group').value;
        document.getElementById('link_suppr_group').href= '/group/delete_group/'+$id;
    });
    ////////////////////////////////////////////

    $(document).on('click', '.open-suppr', function () {
        var group_name = $(this).data('group-name');
        var group_id = $(this).data('id');
        console.log(document.getElementById('id_group').value);
        $(".modal-body #group_name_suppr").empty().append(group_name);
        document.getElementById('link_suppr_group').href= '/group/delete_group/'+group_id;

    });


});
