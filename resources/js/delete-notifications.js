console.log(document);
const forms = document.querySelectorAll('#form-delete-js');

forms.forEach(form => {
    form.addEventListener('submit', function(e){
        e.preventDefault();
        console.log("form clicked");

        const url = this.getAttribute('action');
        const token = document.querySelector('meta[name="csrf-token"]').content;
        const postId = this.querySelector('#delete-id-js').value;
        const divToRemove = document.querySelector('#row_'+postId);

        fetch(url, {
            headers:{
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token
            },
            method: 'post',
            body: JSON.stringify({
                id:postId
            })
        }).then(response => {
            response.json().then(data => {
                divToRemove.parentNode.removeChild(divToRemove);
                //console.log(data);
            })
        }).catch(error => {
            console.log(error)
        });

    });
});


