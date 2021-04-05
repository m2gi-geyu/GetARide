
    ///////////////////////////////////////
    /// Bloquer affichage date antérieur date du jour
    var today = new Date().toISOString().split('T')[0];
    document.getElementsByName("date")[0].setAttribute('min', today
)
    //////////////////////////////////////

    var pub = document.querySelectorAll("input[type=radio][name=privacy][id=public]");
    var priv = document.querySelectorAll("input[type=radio][name=privacy][id=private]");
    ///////////////////////////////////////
    /// Hauteur de la textarea automatique
    $('textarea').each(function (){
    this.setAttribute('style', 'height:' + (this.scrollHeight) + 'px;overflow-y:hidden;');
        }).on('input', function (){
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight) + 'px';
        })
    ///////////////////////////////////////

    ///////////////////////////////////////
    /// Affichage des groupes en fonction de la confidentialité
    for (var i = 0, iLen = pub.length; i < iLen; i++) {
        pub[i].onclick = function() {
            showResult('group',true);
        }
    }

    for (var i = 0, iLen = priv.length; i < iLen; i++) {
        priv[i].onclick = function() {
            showResult(' group',false);
        }
    }

    function showResult(name,bool) {
        var x = document.getElementsByName(name);
        for (var i = 0; i < x.length; i++) {
            x[i].hidden = bool;
        }
        if(bool)
            $("div[name=' groups_choice']").hide();
        else
            $("div[name=' groups_choice']").show();
    }

    /////////////////////////////////////////////

    $(document).ready(function(){

        $(document).on(' click', '.add', function(){
            var html = '';
            html += ' <tr>';
            html += ' <td><input type="text" name="stage[]" autoComplete="off" id="stage" list="stagelist" className="form-control stage"/></td>';
            html += ' <datalist id="stagelist">'
            html += ' </datalist>'
            html += ' <td><button type="button" name="remove" className="btn btn-danger btn-sm remove"><span className="glyphicon glyphicon-trash"></span></button> </td> </tr>';

            $('#item_table').append(html);
        });

        $(document).on('click', '.remove', function (){
        $(this).closest('tr').remove();
        });

        //////////////////////////////
        /// Proposition ville départ
        $('#departure').on('input', function (){
            var vil =$(this).val();
            fetch("https://geo.api.gouv.fr/communes?nom="+vil+"&fields=departement&boost=population&limit=5")
            .then((response) =>response.json())
            .then((data) => traitement(data));
            function traitement(data){
                $('#departurelist option').remove();
                var html ='';
                data.forEach(ville => {
                    html += '<option value=\"'+ville.nom+'\" />';
                });
                $('#departurelist').append(html);
            }
        });
        //////////////////////////////

        //////////////////////////////
        /// Proposition ville finale
        $('#final').on('input', function (){
            var vil =$(this).val();
            fetch("https://geo.api.gouv.fr/communes?nom="+vil+"&fields=departement&boost=population&limit=5")
            .then((response) =>response.json())
            .then((data) => traitement(data));
            function traitement(data){
                $('#finallist option').remove();
                var html ='';
                data.forEach(ville => {
                    html += '<option value=\"'+ville.nom+'\" />';
                });
                $('#finallist').append(html);
            }
        });
        //////////////////////////////

        //////////////////////////////
        /// Proposition villes étapes
        $(document).on('input', '.stage', function (){
            var vil =$(this).val();
            fetch("https://geo.api.gouv.fr/communes?nom="+vil+"&fields=departement&boost=population&limit=5")
            .then((response) =>response.json())
            .then((data) => traitement(data));
            function traitement(data){
                $('#stagelist option').remove();
                var html ='';
                data.forEach(ville => {
                    html += '<option value=\"'+ville.nom+'\" />';
                });
                $('#stagelist').append(html);
            }
        });
        /////////////////////////////////

        /////////////////////////////////
        /// Vérification existence ville
        var inputs = document.querySelectorAll('input[list]');
        for (var i = 0; i <inputs.length;i++){
        inputs[i].addEventListener('change',function (){
                var optionFound = false,
                datalist = this.list;

                for(var j =0; j<datalist.options.length;j++){
                    if(this.value == datalist.options[j].value){
                        optionFound=true;
                        break;
                    }
                }
                if(optionFound){
                    this.setCustomValidity("");
                }else{
                    this.setCustomValidity('Entrez une valeur valide');
                }
            });
        }
        //////////////////////////////////
    });
