console.log(document);
const forms = document.querySelectorAll('#form-read-js');

forms.forEach(form => {
    form.addEventListener('submit', function(e){
        e.preventDefault();
        console.log("form clicked");

        const url = this.getAttribute('action');
        const token = document.querySelector('meta[name="csrf-token"]').content;
        const postId = this.querySelector('#read-id-js').value;
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
                this.parentNode.removeChild(this);
                //console.log(data);
            })
        }).catch(error => {
            console.log(error)
        });

    });
});