
    ///////////////////////////////////////
    /// Bloquer affichage date antérieur date du jour
    var today = new Date().toISOString().split('T')[0];
    document.getElementsByName("date")[0].setAttribute('min', today
)
    //////////////////////////////////////

    var pub = document.querySelectorAll("input[type=radio][name=privacy][id=public]");
    var priv = document.querySelectorAll("input[type=radio][name=privacy][id=private]");
    

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
            /*
            html += ' <tr>';
            html += ' <td><input type="text" name="stage[]" autoComplete="off" id="stage" list="stagelist" className="form-control stage"/></td>';
            html += ' <datalist id="stagelist">'
            html += ' </datalist>'
            html += ' <td><button type="button" name="remove" className="btn btn-danger btn-sm remove"><span className="glyphicon glyphicon-trash"></span></button> </td> </tr>';
*/
            html += '<tr>';
            html += '<td><input type="text" autocomplete="off" name="stage[]" list="stagelist" id="stage" class="form-control stage"></td>';
            html += '<datalist  id="stagelist"></datalist>';
            html += '<td><button type="button" name="remove" class="btn btn-danger btn-sm remove"><span class="glyphicon glyphicon-minus"></span></button></td></tr>';
            html += '</tr>';
            $('#item_table').append(html);
        });

        $(document).on('click', '.remove', function (){
        $(this).closest('tr').remove();
        });

            $(document).on('click', '.open', function () {
                console.log("--------------");
                var trajet_id = $(this).data('id-trip');
                var trajet_start = $(this).data('starting-town');
                var trajet_end = $(this).data('ending-town');
                var trajet_date = $(this).data('date-trip');
                var trajet_hour = $(this).data('hour-trip');
                var trajet_nb_seat = $(this).data('nb-seat');
                var trajet_price = $(this).data('price');
                var trajet_precision = $(this).data('rdv');
                var trajet_info = $(this).data('info');
                var trajet_stage = $(this).data('stage');

                var html = '';

                trajet_stage.forEach(ville => {
                    if(ville.id_trip == trajet_id) {
                        html += '<tr>';
                        html += '<td><input type="text" autocomplete="off" name="stage[]" list="stagelist" id="stage" class="form-control stage" value=' + ville.stage + '></td>';
                        html += '<datalist  id="stagelist"></datalist>';
                        html += '<td><button type="button" name="remove" class="btn btn-danger btn-sm remove"><span class="glyphicon glyphicon-minus"></span></button></td></tr>';
                        html += '</tr>';
                    }
                });


                $(".modal-body #id_trip").val(trajet_id);
                $(".modal-body #departure").val(trajet_start);
                $(".modal-body #final").val(trajet_end);
                $(".modal-body #date").val(trajet_date);
                $(".modal-body #time").val(trajet_hour);
                $(".modal-body #nb_passengers").val(trajet_nb_seat);
                $(".modal-body #price").val(trajet_price);
                $(".modal-body #rdv").val(trajet_precision);
                $(".modal-body #info").val(trajet_info);
                $(".modal-body #item_table").empty()
                .append(html);

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
