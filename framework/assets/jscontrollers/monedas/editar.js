
function fill_origenes(id_origen){
    $('.selector_origenes').empty();
    $.ajax({
        type : "GET",
        url : "api/origenes/get",
        success : function(json) {
         
          for (var i = 0; i< json.length; i++){

            if(json[i].id_origen == id_origen){

                $('.selector_origenes').append(new Option(
                    json[i].nombre,
                    json[i].id_origen,
                    false,
                    true
                ));

            }else{

                $('.selector_origenes').append(new Option(
                    json[i].nombre,
                    json[i].id_origen,
                    false,
                    false
                ));
            }

          }
        },
        error : function(xhr, status) {
         // error_toastr('Error', 'Ha ocurrido un problema');
        }
    });


}


function editar_una_moneda(codigo,diametro,espesor,composicion,peso,id_origen) {
    $('.selector_compo').empty();
    $('#id_codigo').val(codigo);
    $('#id_diametro').val(diametro);
    $('#id_espesor').val(espesor);
    $('#id_composicion').val(composicion);
    $('#id_peso').val(peso);

    fill_origenes(id_origen);

    if(composicion == "oro"){

        $('.selector_compo').append(new Option(
            "Oro",
            "oro",
            false,
            true
        ));

        $('.selector_compo').append(new Option(
            "Plata",
            "plata",
            false,
            false
        ));


    }else{

        $('.selector_compo').append(new Option(
            "Oro",
            "oro",
            false,
            false
        ));

        $('.selector_compo').append(new Option(
            "Plata",
            "plata",
            false,
            true
        ));
       
    }



    $('#editarMoneda').modal('show');

}

/**
 * Ajax action to api rest
*/
function edit_moneda() {
    /*var l = Ladda.create(document.querySelector('#editar_moneda_0CR3ND'));
    l.start();*/
    $('#editar_moneda_0CR3ND').attr('disabled','disabled');
    $.ajax({
        type: "POST",
        url: "api/monedas/editar",
        data: $('#editar_moneda_form_0CR3ND').serialize(),
        success: function (json) {
            if(json.success == 1) {

                toastr.options = {
                    closeButton: true,
                    progressBar: true,
                    showMethod: 'slideDown',
                    timeOut: 4000
                };

                toastr.success('¡Moneda editada!','Exito!');
                
                setTimeout(function () {
                    location.reload();
                }, 1000);
                
            }else {
                toastr.error(json.message, '¡Ups!')
            }
        },
        error: function (xhr, status) {
            toastr.error("Ha ocurrido un problema", '¡ERROR!');
        },
        complete: function () {
            $('#editar_moneda_0CR3ND').removeAttr('disabled');
        }
    });
}

/**
   * Events
   *  
   * @param {*} e 
*/
$('#editar_moneda_0CR3ND').click(function (e) {
    e.defaultPrevented;
    edit_moneda();
});
$('form#editar_moneda_form_0CR3ND input').keypress(function (e) {
    e.defaultPrevented;
    if (e.which == 13) {
        edit_moneda();

        return false;
    }
});