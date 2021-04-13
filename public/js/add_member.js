function main(){
    const forms = document.querySelectorAll('#add-member-form');

    //On submit sur les formulaire pour ajouter un nouveau Membre à un groupe privé
    forms.forEach(form => {
        form.addEventListener('submit', function(e){
            e.preventDefault();
            console.log("form clicked");

            const url = this.getAttribute('action');
            const token = document.querySelector('meta[name="csrf-token"]').content;
            const postMemberId = this.querySelector('#member-id-js').value;
            const postGroupId = this.querySelector('#group-id-js').value;

            //Envoi du message POST
            fetch(url, {
                headers:{
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token
                },
                method: 'post',
                body: JSON.stringify({
                    idGroup:postGroupId,
                    idMember:postMemberId
                })
            }).then(response => {
                response.json().then(data => {

                    
                    $(this).closest('form').remove();
                 
                    //Supression du bouton pour ajouter au groupe privé une fois ajouté à la base de donnée
                    if($('#Modal-body-'+postMemberId).children().length == 0)
                    {
                        $('#Modal-body-'+postMemberId).text('Cet utilisateur est déjà membre de tous vos groupes privés')
                    }

                })
            }).catch(error => {
                console.log(error)
            });

        });
    });  
}