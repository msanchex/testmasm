function isEmptyStr(str) {
    return (!str || 0 === str.length);
}

$.fn.clearForm = function() {
    return this.each(function() {
        var type = this.type, tag = this.tagName.toLowerCase();
        if (tag == 'form')
            return $(':input', this).clearForm();
        if (type == 'text' || type == 'password' || tag == 'textarea')
            this.value = '';
        else if (type == 'checkbox' || type == 'radio')
            this.checked = false;
        else if (tag == 'select')
            this.selectedIndex = -1;
    });
};


/*
 * cotizaciones
 */

$(document).on('click', "a[data-role='crearcotizacion']", function() {
    $.ajax({
        type: 'POST',
        dataType: 'json',
        async: true,
        url: requestUrl + '/carro/crearcotizacion',
        beforeSend: function() {
            Loading.show();
        },
        complete: function() {
            Loading.hide();
        },
        success: function(data) {
            dialogoAnimado(data.response);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            bootbox.alert('Error: ' + errorThrown);
        }
    });
});

/*
 * carro de compras
 */

$(document).on('click', "a[data-role='carrovaciar']", function() {
    $.ajax({
        type: 'POST',
        dataType: 'json',
        async: true,
        url: requestUrl + '/carro/vaciar',
        beforeSend: function() {
            Loading.show();
        },
        complete: function() {
            Loading.hide();
        },
        success: function(data) {
            if (data.result == 'ok') {
                $('#div-carro').html(data.carro);
                $('#div-carro').trigger("create");
                $('#div-carro-canasta').html(data.canasta);
                $('#div-carro-canasta').trigger("create");
            } else {
                bootbox.alert(data.response);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            bootbox.alert('Error: ' + errorThrown);
        }
    });
});

$(document).on('click', "button[data-role='modificarcarro']", function() {
    var position = $(this).attr('data-position');
    var modificar = $(this).attr('data-modificar');
    var operacion = $(this).attr('data-operation');
    var cantidad = 0;
    var id = "";

    if (modificar == 1) {
        var esFraccion = $(this).attr('data-fraction') == 1;
        if (esFraccion) {
            id = '#cantidad-producto-fraccion-' + position;
        } else {
            id = '#cantidad-producto-unidad-' + position;
        }
    } else if (modificar == 2) {
        id = '#cantidad-producto-' + position;
    } else if (modificar == 3) {
        id = '#cantidad-producto-bodega-' + position;
    }

    cantidad = parseInt($(id).val());

    if (isNaN(cantidad) || cantidad < 1) {
        cantidad = 1;
    } else {
        if (operacion == "+") {
            cantidad++;
            if (cantidad < 1) {
                cantidad = 1;
            }
        } else if (operacion == "-" && cantidad > 0) {
            cantidad--;
            if (cantidad < 1) {
                cantidad = 1;
            }
        }
    }

    $(id).val(cantidad);
    modificarCarro(position, modificar);
});

$(document).on('change', "input[data-role='modificarcarro']", function() {
    var cantidad = parseInt($(this).val());
    var position = $(this).attr('data-position');
    var modificar = $(this).attr('data-modificar');

    if (isNaN(cantidad) || cantidad < 1) {
        cantidad = 1;
    }
    $(this).val(cantidad);
    modificarCarro(position, modificar);
});

function modificarCarro(position, modificar) {
    var data = {
        modificar: modificar,
        position: position
    };

    if (modificar == 1) {
        var cantidadF = parseInt($('#cantidad-producto-fraccion-' + position).val());
        if (isNaN(cantidadF)) {
            cantidadF = -1;
        } else if (cantidadF < 1) {
            cantidadF = 1;
        }

        var cantidadU = parseInt($('#cantidad-producto-unidad-' + position).val());

        if (isNaN(cantidadU) || cantidadU < 1) {
            cantidadU = 1;
        }

        if (cantidadF > 0) {
            var numeroFracciones = parseInt($('#cantidad-producto-fraccion-' + position).attr('data-nfracciones'));
            var unidadFraccionamiento = parseInt($('#cantidad-producto-fraccion-' + position).attr('data-ufraccionamiento'));
            var fraccionesMaximas = Math.floor(numeroFracciones / unidadFraccionamiento);

            if (cantidadF >= fraccionesMaximas) {
                var unidades = Math.floor(cantidadF / fraccionesMaximas);
                var fracciones = cantidadF % fraccionesMaximas;
                cantidadU += unidades;
                cantidadF = fracciones;
            }
        }

        data['cantidadU'] = cantidadU;
        data['cantidadF'] = cantidadF;
    } else if (modificar == 2) {
        var cantidad = parseInt($('#cantidad-producto-' + position).val());
        if (isNaN(cantidad) || cantidad < 1) {
            cantidad = 1;
        }
        data['cantidad'] = cantidad;
    } else if (modificar == 3) {
        var cantidad = parseInt($('#cantidad-producto-bodega-' + position).val());
        if (isNaN(cantidad) || cantidad < 1) {
            cantidad = 1;
        }
        data['cantidad'] = cantidad;
    }

    $.ajax({
        type: 'POST',
        dataType: 'json',
        async: true,
        url: requestUrl + '/carro/modificar',
        data: data,
        beforeSend: function() {
            Loading.show();
        },
        complete: function() {
            Loading.hide();
        },
        success: function(data) {
            if (data.result === "ok") {
                $('#div-carro').html(data.response.carroHTML);
                $('#div-carro').trigger("create");

                if (data.response.canastaHTML) {
                    $('#div-carro-canasta').html(data.response.canastaHTML);
                    $('#div-carro-canasta').trigger("create");
                }

                if (data.response.dialogoHTML) {
                    bootbox.alert(data.response.dialogoHTML);//modal
                }
            } else {
                $('#div-carro').html(data.response.carroHTML);
                $('#div-carro').trigger("create");
                bootbox.alert(data.response.message);
            }

        },
        error: function(jqXHR, textStatus, errorThrown) {
            bootbox.alert('Error: ' + errorThrown);
        }
    });
}

$(document).on('click', "a[data-eliminar='1'], a[data-eliminar='2'], a[data-eliminar='3']", function() {
    var position = $(this).attr('data-position');
    var eliminar = $(this).attr('data-eliminar');

    $.ajax({
        type: 'POST',
        dataType: 'json',
        async: true,
        url: requestUrl + '/carro/eliminar',
        data: {id: position, eliminar: eliminar},
        beforeSend: function() {
            Loading.show();
        },
        complete: function() {
            Loading.hide();
        },
        success: function(data) {
            if (data.result == 'ok') {
                $('#div-carro').html(data.carro);
                $('#div-carro').trigger("create");
                $('#div-carro-canasta').html(data.canasta);
                $('#div-carro-canasta').trigger("create");
            } else {
                bootbox.alert(data.response);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            bootbox.alert('Error: ' + errorThrown);
        }
    });

});

/*
 * pasos de compra
 */

$(document).on('click', "button[id='btn-carropagar-siguiente'], button[id='btn-carropagar-anterior']", function() {
    var actual = $(this).attr('data-origin');
    var siguiente = $(this).attr('data-redirect');

    if (actual === 'despacho') {
        pasoDespacho(actual, siguiente, $(this));
    } else if (actual === 'entrega') {
        pasoEntrega(actual, siguiente, $(this));
    } else if (actual === 'pago') {
        pasoPago(actual, siguiente, $(this));
    } else if (actual === 'confirmacion') {
        pasoConfirmacion(actual, siguiente, $(this));
    }

    return false;
});

function pasoDespacho(actual, siguiente, boton) {
    var data = {
        siguiente: siguiente,
        direccion: $('input[name="FormaPagoForm[idDireccionDespacho]"]:checked').val()
    };

    $.ajax({
        type: 'POST',
        //dataType: 'json',
        async: true,
        url: requestUrl + '/carro/pagar/paso/' + actual + '/post/true',
        data: $.param(data) + '&' + $('#form-direccion-pagoinvitado').serialize(),
        beforeSend: function() {
            boton.prop('disabled', true);
            $('div[id^="FormaPagoForm_"].has-error').html('');
            $('div[id^="FormaPagoForm_"].has-error').css('display', 'none');
            Loading.show();
        },
        complete: function() {
            Loading.hide();
        },
        success: function(data) {
            var obj = $.parseJSON(data);

            if (obj.result === 'ok') {
                window.location.replace(obj.redirect);
            } else if (obj.result === 'error') {
                bootbox.alert(obj.response);
                boton.prop('disabled', false);
            } else {
                $.each(obj, function(element, error) {
                    $('#' + element + '_em_').html(error);
                    $('#' + element + '_em_').css('display', 'block');
                });
                boton.prop('disabled', false);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            bootbox.alert('Error: ' + errorThrown);
            boton.prop('disabled', false);
        }
    });
}

function pasoEntrega(actual, siguiente, boton) {
    var data = {siguiente: siguiente};

    $.ajax({
        type: 'POST',
        //dataType: 'json',
        async: true,
        url: requestUrl + '/carro/pagar/paso/' + actual + '/post/true',
        data: $.param(data) + '&' + $('#form-pago-entrega').serialize(),
        beforeSend: function() {
            boton.prop('disabled', true);
            $('div[id^="FormaPagoForm_"].has-error').html('');
            $('div[id^="FormaPagoForm_"].has-error').css('display', 'none');
            $('#form-pago-entrega').trigger("create");
            Loading.show();
        },
        complete: function() {
            Loading.hide();
        },
        success: function(data) {
            var obj = $.parseJSON(data);

            if (obj.result === 'ok') {
                window.location.replace(obj.redirect);
            } else if (obj.result === 'error') {
                bootbox.alert(obj.response);
                boton.prop('disabled', false);
            } else {
                $.each(obj, function(element, error) {
                    $('#' + element + '_em_').html(error);
                    $('#' + element + '_em_').css('display', 'block');
                });
                boton.prop('disabled', false);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            bootbox.alert('Error: ' + errorThrown);
            boton.prop('disabled', false);
        }
    });
}

function pasoPago(actual, siguiente, boton) {
    var data = {siguiente: siguiente};

    $.ajax({
        type: 'POST',
        //dataType: 'json',
        async: true,
        url: requestUrl + '/carro/pagar/paso/' + actual + '/post/true',
        data: $.param(data) + '&' + $('#form-pago-pago').serialize(),
        beforeSend: function() {
            boton.prop('disabled', true);
            $('div[id^="FormaPagoForm_"].text-danger').html('');
            $('div[id^="FormaPagoForm_"].text-danger').css('display', 'none');
            Loading.show();
        },
        complete: function() {
            Loading.hide();
        },
        success: function(data) {
            var obj = $.parseJSON(data);

            if (obj.result === 'ok') {
                window.location.replace(obj.redirect);
            } else if (obj.result === 'error') {
                bootbox.alert(obj.response);
                boton.prop('disabled', false);
            } else {
                $.each(obj, function(element, error) {
                    $('#' + element + '_em_').html(error);
                    $('#' + element + '_em_').css('display', 'block');
                });
                boton.prop('disabled', false);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            bootbox.alert('Error: ' + errorThrown);
            boton.prop('disabled', false);
        }
    });
}

function pasoConfirmacion(actual, siguiente, boton) {
    var data = {siguiente: siguiente};

    $.ajax({
        type: 'POST',
        //dataType: 'json',
        async: true,
        url: requestUrl + '/carro/pagar/paso/' + actual + '/post/true',
        data: $.param(data) + '&' + $('#form-pago-confirmacion').serialize(),
        beforeSend: function() {
            boton.prop('disabled', true);
            Loading.show();
        },
        complete: function() {
            Loading.hide();
        },
        success: function(data) {
            var obj = $.parseJSON(data);

            if (obj.result === 'ok') {
                window.location.replace(obj.redirect);
            } else if (obj.result === 'error') {
                bootbox.alert(obj.response);
                boton.prop('disabled', false);
            } else {
                $.each(obj, function(element, error) {
                    $('#' + element + '_em_').html(error);
                    $('#' + element + '_em_').css('display', 'block');
                });
                boton.prop('disabled', false);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            bootbox.alert('Error: ' + errorThrown);
            boton.prop('disabled', false);
        }
    });
}

/*
 * pasarela de pago
 */

$(document).on('click', "button[data-role='pagopasarela']", function() {
    var boton = $(this);
    $.ajax({
        type: 'POST',
        dataType: 'json',
        async: true,
        url: requestUrl + '/carro/pagopasarela',
        beforeSend: function() {
            boton.prop('disabled', true);
            Loading.show();
        },
        complete: function() {
            Loading.hide();
        },
        success: function(data) {
            if (data.result == 'ok') {
                $('#div-pasarela-info form').remove();
                $('#div-pasarela-info').append(data.response);
                $('form[id="form-pasarela"]').submit();
            } else {
                boton.prop('disabled', false);
                ;
                bootbox.alert(data.response);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            boton.prop('disabled', false);
            ;
            bootbox.alert('Error: ' + errorThrown);
        }
    });
});

/*
 * FILTROS
 */

$(document).on('change', "input[id^='FiltroForm_listMarcas_']", function() {
    recalcularFiltros(1);
});

$(document).on('change', "input[id^='FiltroForm_listFiltros_']", function() {
    recalcularFiltros(2);
});

$(document).on('click', "a[data-role='filtro-listaproductos-reset']", function() {
    $('#form-filtro-listaproductos').clearForm();
    var value = [parseInt($('#FiltroForm_precio').attr('data-slider-min')), parseInt($('#FiltroForm_precio').attr('data-slider-max'))];
    setPrecioFiltroForm(value);
    $('#FiltroForm_precio').slider('setValue', value);
    $('#calificacion-filtro-listaproductos').raty('score', 0);
    $('#calificacion-filtro-listaproductos').attr('data-score', -1);

    if ($(this).attr('data-tipo') == '1') {
        recalcularFiltros(2);
    }
});

function recalcularFiltros(tipo) {
    var marcas = {};
    $("input[id^='FiltroForm_listMarcas_']").each(function() {
        if ($(this).is(":checked")) {
            marcas[$(this).val()] = parseInt($(this).val());
        }
    });
    var atributos = {};
    $("input[id^='FiltroForm_listFiltros_']").each(function() {
        if ($(this).is(":checked")) {
            atributos[$(this).val()] = parseInt($(this).attr('data-filtro'));
        }
    });

    $.ajax({
        type: 'POST',
        dataType: 'json',
        async: true,
        url: requestUrl + '/catalogo/filtro',
        data: {marcas: marcas, atributos: atributos, tipo: tipo},
        beforeSend: function() {
            Loading.show();
        },
        complete: function() {
            Loading.hide();
        },
        success: function(data) {
            if (data.hasOwnProperty('marcas')) {
                $('#div-filtro-marcas').html(data.marcas);
                $('#div-filtro-marcas').trigger("create");
            }
            if (data.hasOwnProperty('atributos')) {
                $('#div-filtro-atributos').html(data.atributos);
                $('#div-filtro-atributos').trigger("create");
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            bootbox.alert('Error: ' + errorThrown);
        }
    });
}

$(document).on('click', "a[data-role='filtro-listaproductos']", function() {
    $.ajax({
        type: 'POST',
        dataType: 'json',
        async: true,
        url: requestUrl + '/catalogo/filtrar',
        data: $('#form-filtro-listaproductos').serialize(),
        beforeSend: function() {
            //boton.button('disable');
            Loading.show();
        },
        complete: function() {
            Loading.hide();
        },
        success: function(data) {
            if (data.result === 'ok') {
                //bootbox.alert(data.response);
                $.fn.yiiListView.update('id-productos-list');
            } else {
                bootbox.alert(data.response);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            bootbox.alert('Error: ' + errorThrown);
            //boton.button('enable');
        }
    });
});

$(document).on('click', "a[data-role='orden-listaproductos']", function() {
    $.ajax({
        type: 'POST',
        dataType: 'json',
        async: true,
        url: requestUrl + '/catalogo/filtrar',
        data: $('#form-ordenamiento-listaproductos').serialize(),
        beforeSend: function() {
            //boton.button('disable');
            Loading.show();
        },
        complete: function() {
            Loading.hide();
        },
        success: function(data) {
            if (data.result === 'ok') {
                //bootbox.alert(data.response);
                $.fn.yiiListView.update('id-productos-list');
            } else {
                bootbox.alert(data.response);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            bootbox.alert('Error: ' + errorThrown);
            //boton.button('enable');
        }
    });
});

$(document).on('change', '#FiltroForm_precio', function() {
    var value = $('#FiltroForm_precio').slider('getValue');
    setPrecioFiltroForm(value);
});

function setPrecioFiltroForm(value) {
    $('#FiltroForm_precio_0_text').val("$" + format(value[0]));
    $('#FiltroForm_precio_1_text').val("$" + format(value[1]));
    $('#FiltroForm_precio_0').val(value[0]);
    $('#FiltroForm_precio_1').val(value[1]);
}

$(document).on('change', '#FiltroForm_precio_0_text', function() {
    var value = $(this).val();
    value = parseInt(value);
    if (isNaN(value)) {
        value = 0;
    }
    $('#FiltroForm_precio').slider('setValue', [value, $('#FiltroForm_precio').slider('getValue')[1]]);
    $('#FiltroForm_precio_0').val(value);
    $('#FiltroForm_precio_0_text').val("$" + format(value));
});

$(document).on('change', '#FiltroForm_precio_1_text', function() {
    var value = $(this).val();
    value = parseInt(value);
    if (isNaN(value)) {
        value = 200000;
    }
    $('#FiltroForm_precio').slider('setValue', [$('#FiltroForm_precio').slider('getValue')[0], value]);
    $('#FiltroForm_precio_1').val(value);
    $('#FiltroForm_precio_1_text').val("$" + format(value));
});

$(document).on('click', "a[id='btn-buscador-productos']", function() {
    var form = $(this).parents("form");
    var text = $("input[id='busqueda']").val().trim();
    if (!isEmptyStr(text)) {
        form.submit();
    }
});

$(document).on('click', "div[data-role='formapago']", function() {
    var tipo = $(this).attr('data-tipo');
    if (tipo == "datafono") {
        $("#modal-formapago input[type='radio']").removeAttr('checked');
        $("#modal-formapago #idFormaPago_"+$("#FormaPagoForm_idFormaPago").val()).prop('checked', true);
        $("div[data-role^='formapago-logo-']").addClass('display-none');
        $("div[data-role='formapago-logo-"+$("#FormaPagoForm_idFormaPago").val()+"']").removeClass('display-none');
        
        $("#modal-formapago").modal("show");
    } else {
        $("div[data-role='formapago']").removeClass('activo');
        $(this).addClass('activo');
        $('input[id="FormaPagoForm_idFormaPago"]').val(tipo);
        
        var logopagolinea = $(this).children("div[data-role='formapago-logo-pagoenlinea']");
        
        if (logopagolinea.length>0) {
            logopagolinea.removeClass('display-none');
        }else{
            $("div[data-role='formapago-logo-pagoenlinea']").addClass('display-none');
        }
    }
});

$(document).on('click', "#modal-formapago input[type='radio']", function() {
    if ($(this).is(':checked')) {
        $("div[data-role='formapago']").removeClass('activo');
        $('div[data-tipo="datafono"]').addClass('activo');
        $('input[id="FormaPagoForm_idFormaPago"]').val($(this).val());
        
        $("div[data-role^='formapago-logo-']").addClass('display-none');
        $("div[data-role='formapago-logo-"+$(this).val()+"']").removeClass('display-none');
        $("div[data-role='formapago-logo-pagoenlinea']").addClass('display-none');
    }
});


/*
 * contador de caracteres para textarea
 */

$(document).ready(function() {
    $(function() {
        var elementArea = $("textarea[data-countchar]");
        if (elementArea.length) {
            countChar(elementArea, elementArea.attr('data-countchar'));
        }
    });
    raty();
});

function raty() {
    $("[data-role='raty']").raty({
        starOn: requestUrl + '/libs/raty/images/star-on.png',
        starOff: requestUrl + '/libs/raty/images/star-off.png',
        starHalf: requestUrl + '/libs/raty/images/star-half.png',
        cancelOn: requestUrl + '/libs/raty/images/cancel-on.png',
        cancelOff: requestUrl + '/libs/raty/images/cancel-off.png',
        hints: ['mala', 'deficiente', 'regular', 'buena', 'excelente'],
        noRatedMsg: 'Sin calificación',
        /*round: { down: 0.25, full: 0.6, up: 0.76 },*/
        readOnly: function() {
            return $(this).attr('data-readonly') === "true";
        },
        click: function(score, evt) {
            if ($(this).attr('data-callback')) {
                var funcion = $(this).attr('data-callback');
                window[funcion](score, evt);
            }
        },
        score: function() {
            return $(this).attr('data-score');
        }
    });
}

function capturarfiltrocalificacion(score, evt) {
    var calificacion = score;
    calificacion = parseInt(calificacion);
    if (isNaN(calificacion)) {
        calificacion = -1;
    }
    $('#FiltroForm_calificacion').val(calificacion);
    $('#calificacion-filtro-listaproductos').attr('data-score', calificacion);
}

$(document).on('change', '#form-pago-entrega #FormaPagoForm_fechaEntrega', function() {
    update_clock($(this).val());
});

function update_clock(value){
    var horas = value.split(" ")[1].split(":");
    update_clock_element('#clock_id', horas[0], horas[1], horas[2]);
}

function draw_clock() {
    canvas = Raphael('clock_id', 200, 200);
    var clock = canvas.circle(100, 100, 95);
    clock.attr({"fill": "#f5f5f5", "stroke": "#444444", "stroke-width": "5"})
    var hour_sign;
    for (i = 0; i < 12; i++) {
        var start_x = 100 + Math.round(80 * Math.cos(30 * i * Math.PI / 180));
        var start_y = 100 + Math.round(80 * Math.sin(30 * i * Math.PI / 180));
        var end_x = 100 + Math.round(90 * Math.cos(30 * i * Math.PI / 180));
        var end_y = 100 + Math.round(90 * Math.sin(30 * i * Math.PI / 180));
        hour_sign = canvas.path("M" + start_x + " " + start_y + "L" + end_x + " " + end_y);
    }

    hour_hand = canvas.path("M100 100L100 50");
    hour_hand.attr({stroke: "#444444", "stroke-width": 6});
    minute_hand = canvas.path("M100 100L100 40");
    minute_hand.attr({stroke: "#444444", "stroke-width": 4});
    second_hand = canvas.path("M100 110L100 25");
    second_hand.attr({stroke: "#444444", "stroke-width": 2});
    var pin = canvas.circle(100, 100, 5);
    pin.attr("fill", "#000000");
}

function update_clock_element(element, hours, minutes, seconds) {
    $(element).html('');
    draw_clock();
    hour_hand.rotate(30 * hours + (minutes / 2.5), 100, 100);
    minute_hand.rotate(6 * minutes, 100, 100);
    second_hand.rotate(6 * seconds, 100, 100);

}
