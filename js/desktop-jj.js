/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
function disminuirCantidadFraccionado(codigoProducto, numeroFracciones, unidadFraccionamiento, valorFraccionado, valorUnidad) {
    var nro = $("#cantidad-producto-fraccion-" + codigoProducto).val();
    nro--;
    if (nro < 0) {
        var nro = $("#cantidad-producto-unidad-" + codigoProducto).val();
        nro--;
        if (nro < 0) {
            nro = 0;
        }
        $("#cantidad-producto-unidad-" + codigoProducto).val(nro);
        $("#subtotal-producto-unidad-" + codigoProducto).html("$" + format(nro * valorUnidad));
        nro = (numeroFracciones / unidadFraccionamiento - 1);
    }
    $("#subtotal-producto-fraccion-" + codigoProducto).html("$" + format(nro * valorFraccionado));
    $("#cantidad-producto-fraccion-" + codigoProducto).val(nro);
}

function aumentarCantidadFraccionado(codigoProducto, numeroFracciones, unidadFraccionamiento, valorFraccionado, valorUnidad) {
    var nro = $("#cantidad-producto-fraccion-" + codigoProducto).val();
    nro++;
    if ((nro * unidadFraccionamiento) == numeroFracciones) {
        var nro = $("#cantidad-producto-unidad-" + codigoProducto).val();
        nro++;
        $("#cantidad-producto-unidad-" + codigoProducto).val(nro);
        $("#subtotal-producto-unidad-" + codigoProducto).html("$" + format(nro * valorUnidad));
        nro = 0;
    }
    $("#subtotal-producto-fraccion-" + codigoProducto).html("$" + format(nro * valorFraccionado));
    $("#cantidad-producto-fraccion-" + codigoProducto).val(nro);
}

function validarCantidadFraccionado(codigoProducto, numeroFracciones, unidadFraccionamiento, valorFraccionado, valorUnidad) {
    var nroFracciones = $("#cantidad-producto-fraccion-" + codigoProducto).val();
    var nroUnidades = $("#cantidad-producto-unidad-" + codigoProducto).val();

    if ((nroFracciones * unidadFraccionamiento) >= numeroFracciones) {
        var nroUnidadesAdicionales = Math.floor((nroFracciones * unidadFraccionamiento) / numeroFracciones);
        nroUnidades = nroUnidades * 1 + nroUnidadesAdicionales;
        $("#cantidad-producto-unidad-" + codigoProducto).val(nroUnidades);
        $("#subtotal-producto-unidad-" + codigoProducto).html("$" + format(nroUnidades * valorUnidad));
        nroFracciones = (nroFracciones * unidadFraccionamiento) % numeroFracciones;
    }
    $("#subtotal-producto-fraccion-" + codigoProducto).html("$" + format(nroFracciones * valorFraccionado));
    $("#cantidad-producto-fraccion-" + codigoProducto).val(nroFracciones);
}



function disminuirCantidad(codigoProducto, valorUnidad) {
    var nro = $("#cantidad-producto-unidad-" + codigoProducto).val();
    nro--;
    if (nro < 0) {
        nro = 0;
    }
    $("#subtotal-producto-unidad-" + codigoProducto).html("$" + format(nro * valorUnidad));
    $("#cantidad-producto-unidad-" + codigoProducto).val(nro);
}
function aumentarCantidad(codigoProducto, valorUnidad) {
    var nro = $("#cantidad-producto-unidad-" + codigoProducto).val();
    nro++;
    if (nro < 0) {
        nro = 0;
    }
    $("#subtotal-producto-unidad-" + codigoProducto).html("$" + format(nro * valorUnidad));
    $("#cantidad-producto-unidad-" + codigoProducto).val(nro);
}

function aumentarCantidadUnidad(codigoProducto, valorUnidad) {
    var nro = $("#cantidad-producto-unidad-" + codigoProducto).val();
    if (nro < 0) {
        nro = 0;
    }
    $("#subtotal-producto-unidad-" + codigoProducto).html("$" + format(nro * valorUnidad));
    $("#cantidad-producto-unidad-" + codigoProducto).val(nro);
}


function disminuirCantidadCombo(codigoCombo, valorCombo) {
    var nro = $("#cantidad-producto-combo-" + codigoCombo).val();
    nro--;
    if (nro < 0) {
        nro = 0;
    }
    $("#subtotal-producto-combo-" + codigoCombo).html("$" + format(nro * valorCombo));
    $("#cantidad-producto-combo-" + codigoCombo).val(nro);
}

function aumentarCantidadCombo(codigoCombo, valorCombo) {
    var nro = $("#cantidad-producto-combo-" + codigoCombo).val();
    nro++;
    if (nro < 0) {
        nro = 0;
    }
    $("#subtotal-producto-combo-" + codigoCombo).html("$" + format(nro * valorCombo));
    $("#cantidad-producto-combo-" + codigoCombo).val(nro);
}

function validarCantidadCombo(codigoCombo, valorCombo) {
    var nro = $("#cantidad-producto-combo-" + codigoCombo).val();
    if (nro < 0) {
        nro = 0;
    }
    $("#subtotal-producto-combo-" + codigoCombo).html("$" + format(nro * valorCombo));
    $("#cantidad-producto-combo-" + codigoCombo).val(nro);
}

function guardarCalificacion(codigoProducto, objCalificacion, url) {

    var titulo = $('#calificacion-titulo-' + codigoProducto).val();
    var comentario = $('#calificacion-comentario-' + codigoProducto).val();
    var calificacion = $(objCalificacion).val();

    $.ajax({
        type: 'POST',
        url: url,
        data: 'codigo=' + codigoProducto + '&titulo=' + titulo + '&calificacion=' + calificacion + "&comentario=" + comentario,
        dataType: 'json',
        success: function(data) {

            $("#dialog").dialog({
                autoOpen: false,
            });

            if (data.result === 'ok') {
                $("[data-role='calificacion']").remove();
                $("#calificacion-producto").html("<div class='col-md-6'>TU COMENTARIO HA SIDO PUBLICADO, ESTE SERÁ APROBADO POR UN MODERADOR EN LAS PRÓXIMAS HORAS</div>");
                $("#dialog").html(data.response);
                $("#dialog").dialog("open");
                /*$('<div>').mdialog({
                 content: "<div data-role='main'><div class='ui-content' data-role='content' role='main'>" + data.response + "<a class='ui-btn ui-btn-r ui-corner-all ui-shadow' data-rel='back' href='#'>Aceptar</a></div></div>"
                 });*/
            } else {
                $("#dialog").html(data.response);
                $("#dialog").dialog("open");
                /*$('<div>').mdialog({
                 content: "<div data-role='main'><div class='ui-content' data-role='content' role='main'>" + data.response + "<a class='ui-btn ui-btn-r ui-corner-all ui-shadow' data-rel='back' href='#'>Aceptar</a></div></div>"
                 });*/
            }
        }
    });
}


function format(input)
{
    input = input + "";
    var num = input.replace(/\./g, '');
    if (!isNaN(num)) {
        num = num.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g, '$1.');
        num = num.split('').reverse().join('').replace(/^[\.]/, '');
        return num;
    }
    else {
        return "";
    }
}

/*
 function habilitarPopCodigo(id){
 $('#'+id).popover();
 }*/
$(document).ready(function() {
    $('.pop_codigo').popover();
    $("#rango-precios").slider({});
    $("#owl-demo").owlCarousel({
        items: 4,
        lazyLoad: true,
        navigation: true
    });
    $("#carrousel-img-productos").owlCarousel({
        items: 4,
        lazyLoad: true,
        navigation: true
    });
    $('.ad-gallery').adGallery({
        //  loader_image: '../libs/ad-gallery/loader.gif',
          width: 400, 
          height: 300,
          thumb_opacity: 0.7,
      });
      $('.ciudades').select2();
      $('#RegistroForm_profesion').select2();
})


function cambioUnidadesUbicacion(codigoProducto, valorUnidad, op) {

    var cantidadProductoUbicacion = $("#cantidad-producto-ubicacion-" + codigoProducto).val();
    var cantidadProductoBodega = $("#cantidad-producto-bodega-" + codigoProducto).val();
    if (op == 0) {
        cantidadProductoUbicacion--;
    } else {
        cantidadProductoUbicacion++;
    }
    if (cantidadProductoUbicacion < 0) {
        cantidadProductoUbicacion = 0;
    }
    $("#cantidad-producto-ubicacion-" + codigoProducto).val(cantidadProductoUbicacion);

    var subtotal = valorUnidad * cantidadProductoUbicacion;
    // colocar el subtotal
    $("#subtotal-producto-ubicacion-" + codigoProducto).html("$" + format(subtotal));

    var total = subtotal + cantidadProductoBodega * valorUnidad;
    // colocar el total
    $("#total-producto-" + codigoProducto).html("$" + format(total));
}

function cambioUnidadesBodega(codigoProducto, valorUnidad, op) {
    var cantidadProductoBodega = $("#cantidad-producto-bodega-" + codigoProducto).val();
    var cantidadProductoUbicacion = $("#cantidad-producto-ubicacion-" + codigoProducto).val();
    if (op == 0) {
        cantidadProductoBodega--;
    } else {
        cantidadProductoBodega++;
    }
    if (cantidadProductoBodega < 0) {
        cantidadProductoBodega = 0;
    }
    $("#cantidad-producto-bodega-" + codigoProducto).val(cantidadProductoBodega);

    var subtotal = valorUnidad * cantidadProductoBodega;
    // colocar el subtotal
    $("#subtotal-producto-bodega-" + codigoProducto).html("$" + format(subtotal));

    var total = subtotal + cantidadProductoUbicacion * valorUnidad;
    // colocar el total
    $("#total-producto-" + codigoProducto).html("$" + format(total));
}


function ubicacionGPSDesktop() {
    if (navigator.geolocation) {
        //     $.mobile.loading('show');
        navigator.geolocation.getCurrentPosition(obtenerPosicionDesktop, errorPosicion, {'enableHighAccuracy': true, 'timeout': 30000, 'maximumAge': 0});
    } else {
        alert("Servicio no soportado por este navegador.");
    }
}


function obtenerPosicionDesktop(pos) {
    var lat = 0;
    var lon = 0;
    if (pos) {
        lat = pos.coords.latitude;
        lon = pos.coords.longitude;
    }
    $.ajax({
        type: 'POST',
        dataType: 'json',
        async: true,
        url: requestUrl + '/sitio/gps',
        data: {lat: lat, lon: lon},
        success: function(data) {
            if (data.result == 'ok') {
                //$('[data-role= \"main\"]').html(data.response);
                //window.location.href = data.response;
                $("#modalUbicacion").html(data.response.ubicacion);
                $("#modalUbicacion").modal();
            } else {
                bootbox.alert(data.response);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            // $.mobile.loading('hide');
            alert('Error: ' + errorThrown);
        }
    });
}

function cargarCiudad() {
    var ciudad = $("#ciudadDespacho").val();
    var urlCargar = requestUrl + "/sitio/cargarUbicacion/";
    $.ajax({
        url: urlCargar,
        data: {codigoCiudad: ciudad},
        dataType: 'json'
      }).done(function(data) {
          if(data.result=='ok'){
              bootbox.alert(data.response);
              if(data.urlAnterior){
                location.href=data.urlAnterior;
              }else{
                  location.href=requestUrl;
              }
          }else{
              bootbox.alert(data.response);
          }
      });
  }



$(document).on('click', "a[data-cargar='2']", function() {
    var combo = $(this).attr('data-combo');

    var cantidad = $('#cantidad-combo-' + combo).val();
    cantidad = parseInt(cantidad);
    if (isNaN(cantidad)) {
        cantidad = 0;
    }

    $.ajax({
        type: 'POST',
        dataType: 'json',
        async: true,
        url: requestUrl + '/carro/agregarCombo',
        data: {combo: combo, cantidad: cantidad},
        beforeSend: function() {
            //$.mobile.loading('show');
            //quitarRelacionado();
        },
        complete: function() {
            //$.mobile.loading('hide');
        },
        success: function(data) {
            if (data.result === "ok") {
                $('#div-carro-canasta').html(data.response.canastaHTML);
                $('#div-carro-canasta').trigger("create");

                if (data.response.mensajeHTML) {
                    dialogoAnimado(data.response.mensajeHTML);
                    //$('#icono-combo-agregado-' + combo).addClass('active');
                }

                if (data.response.dialogoHTML) {
                    bootbox.alert(data.response.dialogoHTML);
                }
            } else {
                bootbox.alert(data.response);
            }

        },
        error: function(jqXHR, textStatus, errorThrown) {
            bootbox.alert('Error: ' + errorThrown);
        }
    });
});


$(document).on('click', "a[data-carro='1']", function() {

    var producto = $(this).attr('data-producto');
    var cantidadU = $('#cantidad-producto-unidad-' + producto).val();

    cantidadU = parseInt(cantidadU);
    if (isNaN(cantidadU)) {
        cantidadU = -1;
    }

    var cantidadF = parseInt($('#cantidad-producto-fraccion-' + producto).val());
    cantidadF = parseInt(cantidadF);
    if (isNaN(cantidadF)) {
        cantidadF = -1;
    }

    $.ajax({
        type: 'POST',
        dataType: 'json',
        async: true,
        url: requestUrl + '/carro/agregar',
        data: {producto: producto, cantidadU: cantidadU, cantidadF: cantidadF},
        beforeSend: function() {
            //   $.mobile.loading('show');
        },
        complete: function() {
            //   $.mobile.loading('hide');
        },
        success: function(data) {
            if (data.result === "ok") {
                $('#div-carro-canasta').html(data.response.canastaHTML);
                $('#div-carro-canasta').trigger("create");

                if (data.response.mensajeHTML) {
                    dialogoAnimado(data.response.mensajeHTML);
                    $('#icono-producto-agregado-' + producto).addClass('active');
                    $("#cantidad-productos").html(data.response.objetosCarro);
                }

                if (data.response.dialogoHTML) {
                    $("#modalBodegas").html(data.response.dialogoHTML);
                    $("#modalBodegas").modal();
                    // bootbox.alert(data.response.dialogoHTML);
                }
            } else {
                bootbox.alert(data.response);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            bootbox.alert('Error: ' + errorThrown);
        }
    });
});


$(document).on('click', "a[data-carro='3']", function() {
    var producto = $(this).attr('data-producto');

    var cantidadUbicacion = $('#cantidad-producto-ubicacion-' + producto).val();
    cantidadUbicacion = parseInt(cantidadUbicacion);
    if (isNaN(cantidadUbicacion)) {
        cantidadUbicacion = 0;
    }

    var cantidadBodega = parseInt($('#cantidad-producto-bodega-' + producto).val());
    cantidadBodega = parseInt(cantidadBodega);
    if (isNaN(cantidadBodega)) {
        cantidadBodega = 0;
    }

    $.ajax({
        type: 'POST',
        dataType: 'json',
        async: true,
        url: requestUrl + '/carro/agregarBodega',
        data: {producto: producto, cantidadU: cantidadUbicacion, cantidadB: cantidadBodega},
        beforeSend: function() {
            //  $.mobile.loading('show');
        },
        complete: function() {
            //   $.mobile.loading('hide');
        },
        success: function(data) {
            if (data.result === "ok") {
                $('#div-carro-canasta').html(data.response.canastaHTML);
                $('#div-carro-canasta').trigger("create");

                if (data.response.mensajeHTML) {
                    dialogoAnimado(data.response.mensajeHTML);
                    $("#cantidad-productos").html(data.response.objetosCarro);
                }
                if (data.response.dialogoHTML) {
                    bootbox.alert(data.response.dialogoHTML);
                }
            } else {
                bootbox.alert(data.response);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            bootbox.alert('Error: ' + errorThrown);
        }
    });
});



$(document).on('click', "#form-autenticar input[data-registro-desktop='autenticar']", function() {
    var form = $(this).parents("form");//"#form-autenticar"
    var boton = $(this);
   

    $.ajax({
        type: 'POST',
        async: true,
        url: requestUrl + '/usuario/ingresar',
        data: form.serialize(),
        beforeSend: function() {
    //        boton.button('disable');
   //         $.mobile.loading('show');
        },
        complete: function() {
     //       $.mobile.loading('hide');
        },
        success: function(data) {
            var obj = $.parseJSON(data);
            if (obj.result === 'ok') {
                window.location.replace(obj.response.redirect);
            } else if (obj.result === 'error') {
              /*  boton.button('enable');
                $('<div>').mdialog({
                    content: "<div data-role='main'><div class='ui-content' data-role='content' role='main'>" + obj.response + "<a class='ui-btn ui-btn-r ui-corner-all ui-shadow' data-rel='back' href='#'>Aceptar</a></div></div>"
                });*/
            } else {
              //  boton.button('enable');
                $.each(obj, function(element, error) {
                    $('#' + form.attr('id') + ' #' + element + '_em_').html(error);
                    $('#' + form.attr('id') + ' #' + element + '_em_').css('display', 'block');
                });
            } 
        },
        error: function(jqXHR, textStatus, errorThrown) {
            boton.button('enable');
            alert('Error: ' + errorThrown);
        }
    });
    return false;
});



$(document).on('click', "#form-registro input[data-registro-desktop='registro']", function() {
    var form = $(this).parents("form");//"#form-registro"
    var boton = $(this);

    $.ajax({
        type: 'POST',
        async: true,
        url: requestUrl + '/usuario/registro',
        data: form.serialize(),
        beforeSend: function() {
        //    boton.button('disable');
        //    $.mobile.loading('show');
        },
        complete: function() {
         //   $.mobile.loading('hide');
        },
        success: function(data) {
            var obj = $.parseJSON(data);

            if (obj.result === 'ok') {
                $("#main-page").html(obj.response.bienvenidaHTML);
                $("#main-page").trigger("create");
            } else if (obj.result === 'error') {
             /*   boton.button('enable');
                $('<div>').mdialog({
                    content: "<div data-role='main'><div class='ui-content' data-role='content' role='main'>" + obj.response + "<a class='ui-btn ui-btn-r ui-corner-all ui-shadow' data-rel='back' href='#'>Aceptar</a></div></div>"
                });*/
            } else {
             //   boton.button('enable');
                $.each(obj, function(element, error) {
                    $('#' + form.attr('id') + ' #' + element + '_em_').html(error);
                    $('#' + form.attr('id') + ' #' + element + '_em_').css('display', 'block');
                });
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
           // boton.button('enable');
            alert('Error: ' + errorThrown);
        }
    });
    return false;
});


$(document).on('click', "#form-registro input[data-registro-desktop='recordar']", function() {
    var form = $(this).parents("form");//"#form-registro"
    var boton = $(this);

    $.ajax({
        type: 'POST',
        async: true,
        url: requestUrl + '/usuario/registro',
        data: form.serialize(),
        beforeSend: function() {
        //    boton.button('disable');
        //    $.mobile.loading('show');
        },
        complete: function() {
         //   $.mobile.loading('hide');
        },
        success: function(data) {
            var obj = $.parseJSON(data);

            if (obj.result === 'ok') {
                $("#main-page").html(obj.response.bienvenidaHTML);
             //   $("#main-page").trigger("create");
            } else if (obj.result === 'error') {
                bootbox.alert(obj.response);
             /*   boton.button('enable');
                $('<div>').mdialog({
                    content: "<div data-role='main'><div class='ui-content' data-role='content' role='main'>" + obj.response + "<a class='ui-btn ui-btn-r ui-corner-all ui-shadow' data-rel='back' href='#'>Aceptar</a></div></div>"
                });*/
            } else {
             //   boton.button('enable');
                $.each(obj, function(element, error) {
                    $('#' + form.attr('id') + ' #' + element + '_em_').html(error);
                    $('#' + form.attr('id') + ' #' + element + '_em_').css('display', 'block');
                });
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
           // boton.button('enable');
            alert('Error: ' + errorThrown);
        }
    });
    return false;
});


$(document).on('click', "#form-recordar input[data-registro-desktop='recordar']", function() {
    var form = $(this).parents("form");//"#form-recordar"
    var boton = $(this);

    $.ajax({
        type: 'POST',
        async: true,
        url: requestUrl + '/usuario/recordar',
        data: form.serialize(),
        beforeSend: function() {
        //    boton.button('disable');
        //    $.mobile.loading('show');
        },
        complete: function() {
       //     $.mobile.loading('hide');
        },
        success: function(data) {
            var obj = $.parseJSON(data);

            if (obj.result === 'ok') {
           //     boton.button('enable');
                form.trigger("reset");
                bootbox.alert(obj.response);
             /*   $('<div>').mdialog({
                    content: "<div data-role='main'><div class='ui-content' data-role='content' role='main'>" + obj.response + "<a class='ui-btn ui-btn-r ui-corner-all ui-shadow' data-rel='back' href='#'>Aceptar</a></div></div>"
                });*/
            } else if (obj.result === 'error') {
                bootbox.alert(obj.response);
             /*   boton.button('enable');
                $('<div>').mdialog({
                    content: "<div data-role='main'><div class='ui-content' data-role='content' role='main'>" + obj.response + "<a class='ui-btn ui-btn-r ui-corner-all ui-shadow' data-rel='back' href='#'>Aceptar</a></div></div>"
                });*/
            } else {
            //    boton.button('enable');
                $.each(obj, function(element, error) {
                    $('#' + form.attr('id') + ' #' + element + '_em_').html(error);
                    $('#' + form.attr('id') + ' #' + element + '_em_').css('display', 'block');
                });
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            boton.button('enable');
            alert('Error: ' + errorThrown);
        }
    });
    return false;
});