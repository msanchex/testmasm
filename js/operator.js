$(document).on('change', 'input[id=check-pedido-seguimiento]', function() {
    $.ajax({
        type: 'POST',
        dataType: 'json',
        async: true,
        url: requestUrl + '/callcenter/pedido/seguimiento',
        data: {seguimiento: $('input[id=check-pedido-seguimiento]:checked').is(':checked') ? 1 : 0, compra: $(this).attr('data-compra')},
        beforeSend: function() {
            Loading.show();
        },
        complete: function() {
            Loading.hide();
        },
        success: function(data) {
            if (data.result == 'error') {
                bootbox.alert(data.response);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            Loading.hide();
            bootbox.alert('Error: ' + errorThrown);
        }
    });
});

/*
 $(document).on('change', 'input[data-role="adminpedido"]', function() {
 var accion = $(this).attr('data-action');
 
 if (accion === 'pedido-pdv') {
 gestionPedido('/callcenter/admin/pedidopdv', {compra: $(this).attr('data-compra')});
 } else if (accion === 'pedido-pedido') {
 gestionPedido('/callcenter/admin/pedidoadmin', {compra: $(this).attr('data-compra')});
 } else if (accion === 'pedido-cliente') {
 gestionPedido('/callcenter/admin/clientedespacho', {compra: $(this).attr('data-compra'), usuario: $(this).attr('data-usuario')});
 } else if (accion === 'pedido-observaciones') {
 gestionPedido('/callcenter/admin/observacionpedido', {compra: $(this).attr('data-compra'), render: true});
 }
 });
 */

function gestionPedido(url, data) {
    $.ajax({
        type: 'POST',
        //dataType: 'json',
        async: true,
        url: requestUrl + url,
        data: data,
        beforeSend: function() {
            Loading.show();
        },
        complete: function() {
            Loading.hide();
        },
        success: function(data) {
            $('#div-detalle-pedido').html(data);
            /*if (data.result == 'ok') {
             bootbox.alert(data.response);
             }else {
             bootbox.alert(data.response);
             }*/
        },
        error: function(jqXHR, textStatus, errorThrown) {
            Loading.hide();
            bootbox.alert('Error: ' + errorThrown);
        }
    });
}


function buscarProductos(text, obj, request) {
    $.ajax({
        type: 'POST',
        async: true,
        url: request + '/callcenter/pedido/buscar',
        data: {busqueda: text, compra: $(obj).attr('data-pedido')},
        beforeSend: function() {
            $('#modal-productos-busqueda').remove();
            Loading.show();
        },
        success: function(data) {
            $('#container').append(data);
            $('#modal-productos-busqueda').modal('show');
        },
        complete: function() {
            Loading.hide();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            Loading.hide();
            bootbox.alert('Error: ' + jqXHR.responseText);
        }
    });
}


$(document).on('click', 'button[data-action="asignar-pdv"]', function() {
    $.ajax({
        type: 'POST',
        dataType: 'json',
        async: true,
        url: requestUrl + '/callcenter/pedido/asignarpdv',
        data: {compra: $(this).attr('data-compra'), pdv: $('#select-pdv-asignar').val()},
        beforeSend: function() {
            Loading.show();
        },
        complete: function() {
            Loading.hide();
        },
        success: function(data) {
            if (data.result == 'ok') {
                $('#div-encabezado-pedido').html(data.response.htmlEncabezado);
            } else {
                bootbox.alert(data.response);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            Loading.hide();
            bootbox.alert('Error: ' + errorThrown);
        }
    });

});

$(document).on('click', 'button[data-action="saldo-pdv"]', function() {
    $.ajax({
        type: 'POST',
        dataType: 'json',
        async: true,
        url: requestUrl + '/callcenter/pedido/buscarsaldo',
        data: {idCompra: $(this).attr('data-compra'), pdv: $('#select-pdv-saldo').val()},
        beforeSend: function() {
            Loading.show();
        },
        complete: function() {
            Loading.hide();
        },
        success: function(data) {
            if (data.result == '1') {
                $('#div-saldos-pdv').html(data.response.htmlSaldo);
            } else {
                bootbox.alert(data.response.descripcion);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            Loading.hide();
            bootbox.alert('Error: ' + errorThrown);
        }
    });

});

$(document).on('click', 'button[data-action="remitir"]', function() {
    $.ajax({
        type: 'POST',
        dataType: 'json',
        async: true,
        url: requestUrl + '/callcenter/pedido/remitir',
        data: {idCompra: $(this).attr('data-compra')},
        beforeSend: function() {
            Loading.show();
        },
        complete: function() {
            Loading.hide();
        },
        success: function(data) {
            if (data.result == 1) {
                $('#div-encabezado-pedido').html(data.encabezado);
                $('#div-pedido-observaciones').html(data.htmlObservaciones);
            }
            bootbox.alert(data.response);

        },
        error: function(jqXHR, textStatus, errorThrown) {
            Loading.hide();
            bootbox.alert('Error: ' + errorThrown);
        }
    });
});

$(document).on('click', 'button[data-action="remitirborrar"]', function() {
    $.ajax({
        type: 'POST',
        dataType: 'json',
        async: true,
        url: requestUrl + '/callcenter/pedido/remitirBorrar',
        data: {idCompra: $(this).attr('data-compra')},
        beforeSend: function() {
            Loading.show();
        },
        complete: function() {
            Loading.hide();
        },
        success: function(data) {
            if (data.result == 1) {
                $('#div-encabezado-pedido').html(data.encabezado);
                $('#div-pedido-observaciones').html(data.htmlObservaciones);
            }
            bootbox.alert(data.response);

        },
        error: function(jqXHR, textStatus, errorThrown) {
            Loading.hide();
            bootbox.alert('Error: ' + errorThrown);
        }
    });

});

$(document).on('click', "button[data-role='modificarpedido']", function() {
    var action = $(this).attr('data-action');
    var data = {accion: action};

    if (action == 11) {
        var item = $(this).attr('data-item');
        var cantidadU = parseInt($('#cantidad-item-unidad-' + item).val());
        if (isNaN(cantidadU)) {
            cantidadU = -1;
        } else if (cantidadU < 0) {
            // cantidadU = 0;
        }
        data['cantidad'] = cantidadU;
        data['item'] = item;
    } else if (action == 12) {
        var item = $(this).attr('data-item');
        var cantidadF = parseInt($('#cantidad-item-fraccion-' + item).val());
        if (isNaN(cantidadF)) {
            cantidadF = -1;
        } else if (cantidadF < 0) {
            //   cantidadF = 0;
        }
        data['cantidad'] = cantidadF;
        data['item'] = item;
    } else if (action == 13) {
        var item = $(this).attr('data-item');
        var cantidadB = parseInt($('#cantidad-item-bodega-' + item).val());
        if (isNaN(cantidadB)) {
            cantidadB = -1;
        } else if (cantidadB < 0) {
            cantidadB = 0;
        }
        data['cantidad'] = cantidadB;
        data['item'] = item;
    } else if (action == 2) {
        var compra = $(this).attr('data-compra');
        var combo = $(this).attr('data-combo');
        var cantidad = parseInt($('#cantidad-item-unidad-' + compra).val());
        if (isNaN(cantidad)) {
            cantidad = -1;
        } else if (cantidad < 0) {
            cantidad = 0;
        }
        data['compra'] = compra;
        data['combo'] = combo;
        data['cantidad'] = cantidad;
    }

    $.ajax({
        type: 'POST',
        dataType: 'json',
        async: true,
        url: requestUrl + '/callcenter/pedido/modificar',
        data: data,
        beforeSend: function() {
            Loading.show();
        },
        success: function(data) {
            if (data.result === "ok") {
                $('#div-detalle-pedido').html(data.response.htmlDetalle);
                $('#div-encabezado-pedido').html(data.response.htmlEncabezado);
                Loading.hide();
            } else {
                Loading.hide();
                bootbox.alert(data.response);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            Loading.hide();
            bootbox.alert('Error: ' + errorThrown);
        }
    });
});

$(document).on('change', "#notificacion-form #NotificacionForm_tipoObservacion", function() {
    var tipo = $(this).val();

    if (tipo) {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            async: true,
            url: requestUrl + '/callcenter/admin/observacionmensaje',
            data: {tipo: tipo, compra: $(this).attr('data-compra')},
            beforeSend: function() {
                Loading.show();
            },
            success: function(data) {
                if (data.result === "ok") {
                    $('#notificacion-form #NotificacionForm_observacion').val(data.response);
                    Loading.hide();
                } else {
                    Loading.hide();
                    bootbox.alert(data.response);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                Loading.hide();
                bootbox.alert('Error: ' + errorThrown);
            }
        });
    } else {
        $('#notificacion-form #NotificacionForm_observacion').val("");
    }
});

$("#busqueda-buscar").keypress(function(event) {
    if (event.which == 13) {

        var text = $.trim($('#busqueda-buscar').val());
        if (!text) {
            bootbox.alert('Búsqueda no puede estar vacío');
        } else {
            buscarProductos(text, this, requestUrl);

        }
        return false;
    }
});




$(document).on('click', "button[data-role='busquedapedido']", function() {
    var text = $.trim($('#busqueda-buscar').val());
    if (!text) {
        bootbox.alert('Búsqueda no puede estar vacío');
    } else {
        buscarProductos(text, this, requestUrl);
    }
});

$(document).on('click', "a[data-role='beneficiositem']", function() {
    $.ajax({
        type: 'POST',
        async: true,
        url: requestUrl + '/callcenter/pedido/beneficios',
        data: {item: $(this).attr('data-item')},
        beforeSend: function() {
            $('#modal-beneficios-compra').remove();
            Loading.show();
        },
        success: function(data) {
            $('#container').append(data);
            $('#modal-beneficios-compra').modal('show');
        },
        complete: function() {
            Loading.hide();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            Loading.hide();
            bootbox.alert('Error: ' + jqXHR.responseText);
        }
    });
});

$(document).on('click', "button[data-role='disponibilidaditem']", function() {
    var data = {};
    if ($(this).attr('data-item')) {
        data['item'] = $(this).attr('data-item');
    } else if ($(this).attr('data-combo')) {
        data['combo'] = $(this).attr('data-combo');
        data['compra'] = $(this).attr('data-compra');
    }

    $.ajax({
        type: 'POST',
        dataType: 'json',
        async: true,
        url: requestUrl + '/callcenter/pedido/disponibilidad',
        data: data,
        beforeSend: function() {
            Loading.show();
        },
        success: function(data) {
            if (data.result === "ok") {
                $('#div-detalle-pedido').html(data.response.htmlDetalle);
                Loading.hide();
            } else {
                Loading.hide();
                alert(data.response);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            Loading.hide();
            alert('Error: ' + jqXHR.responseText);
        }
    });
});

$(document).on('click', "a[data-cargar='1'], a[data-cargar='2']", function() {
    var tipo = $(this).attr('data-cargar');
    var pedido = $('#btn-pedido-buscar').attr('data-pedido');
    var data = {tipo: tipo, compra: pedido};

    if (tipo == 1) {
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
        data['producto'] = producto;
        data['cantidadU'] = cantidadU;
        data['cantidadF'] = cantidadF;
    } else if (tipo == 2) {
        var combo = $(this).attr('data-combo');
        var cantidad = $('#cantidad-combo-' + combo).val();
        cantidad = parseInt(cantidad);
        if (isNaN(cantidad)) {
            cantidad = 0;
        }
        data['combo'] = combo;
        data['cantidad'] = cantidad;
    }

    $.ajax({
        type: 'POST',
        dataType: 'json',
        async: true,
        url: requestUrl + '/callcenter/pedido/agregar',
        data: data,
        beforeSend: function() {
            Loading.show();
        },
        success: function(data) {
            if (data.result === "ok") {
                $('#div-detalle-pedido').html(data.response.htmlDetalle);
                $('#div-encabezado-pedido').html(data.response.htmlEncabezado);
                Loading.hide();
            } else {
                Loading.hide();
                bootbox.alert(data.response);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            Loading.hide();
            bootbox.alert('Error: ' + errorThrown);
        }
    });
});

function dialogoAnimado(texto) {
    var id = 'dialogo-carro-' + uniqueId();
    $("<div class='dialogo-animado' id='" + id + "'>" + texto + "</div>").appendTo('body');

    $("#" + id).animate({
        opacity: 1,
        bottom: '+=2%'
    }, 400, function() {
        setTimeout(function() {
            $("#" + id).animate({
                opacity: 0,
                bottom: '-=2%'
            }, 400, function() {
                $("#" + id).remove();
            });
        }, 3000);
    });
}

$(document).on('click', "button[data-role='pdvgeodireccion']", function() {
    $.ajax({
        type: 'POST',
        dataType: 'json',
        async: true,
        url: requestUrl + '/callcenter/admin/geodireccion',
        data: {ciudad: $('#select-ciudad-direccion').val(), direccion: $('#input-pedido-direccion').val()},
        beforeSend: function() {
            $('#div-pedido-georeferencia-direcion').html('');
            Loading.show();
        },
        success: function(data) {
            if (data.result === "ok") {
                $('#div-pedido-georeferencia-direcion').html(data.response);
                Loading.hide();
            } else {
                Loading.hide();
                bootbox.alert(data.response);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            Loading.hide();
            bootbox.alert('Error: ' + jqXHR.responseText);
        }
    });
});

$(document).on('click', "button[data-role='pdvgeobarrio']", function() {
    $.ajax({
        type: 'POST',
        dataType: 'json',
        async: true,
        url: requestUrl + '/callcenter/admin/geobarrio',
        data: {ciudad: $('#select-ciudad-barrio').val(), barrio: $('#input-pedido-barrio').val()},
        beforeSend: function() {
            $('#div-pedido-georeferencia-barrio').html('');
            Loading.show();
        },
        success: function(data) {
            if (data.result === "ok") {
                $('#div-pedido-georeferencia-barrio').html(data.response);
                Loading.hide();
            } else {
                Loading.hide();
                bootbox.alert(data.response);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            Loading.hide();
            bootbox.alert('Error: ' + jqXHR.responseText);
        }
    });
});

$(document).on('click', "button[data-role='trazapasarela']", function() {
    $.ajax({
        type: 'POST',
        async: true,
        url: requestUrl + '/callcenter/pedido/trazapasarela',
        data: {compra: $(this).attr('data-pedido')},
        beforeSend: function() {
            $('#modal-trazapasarela').remove();
            Loading.show();
        },
        success: function(data) {
            $('#container').append(data);
            $('#modal-trazapasarela').modal('show');
        },
        complete: function() {
            Loading.hide();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            Loading.hide();
            bootbox.alert('Error: ' + jqXHR.responseText);
        }
    });
});

function uniqueId() {
    var time = new Date().getTime();
    while (time == new Date().getTime())
        ;
    return new Date().getTime();
}