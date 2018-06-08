const fixedValuesTypes = ['select','radio','checkbox'];
const fixedMultipleValuesTypes = ['checkbox'];
const todosOperadores = [ '=' , 'possui' , '<' , '>' , '>=' , '<=' ];
function preencheValores( idCampo , selectValor , valor ) {
    selectValor.empty().append($('<option>CARREGANDO</option>'));
    $.ajax('./ajax/getValues.php', {
        data: { id: idCampo },
        method: 'get',
        success: function ( response ) {
            selectValor.empty();
            const opcoes = JSON.parse(response);
            for (let i = 0; i < opcoes.length; i++) {
                const $opt = $('<option value="'+opcoes[i]+'">'+opcoes[i]+'</option>');
                selectValor.append($opt);
            }
            if (valor !== undefined) {
                selectValor.val(valor);
            }
        }
    });
}

function preencheCampo( categoria , selectCampo, selectValor, selectOperador ) {
    selectCampo.empty().append($('<option>CARREGANDO</option>'));
    $.ajax('./ajax/getCampos.php', {
        data: {id: categoria},
        method: 'get',
        success: function ( response ) {
            selectCampo.empty();
            const campos = JSON.parse(response);
            campos.forEach( function ( x ) {
                const $opt = $('<option>'+x.name+'</option>');
                $opt.val('custom'+x.id);
                $opt.attr('tp',x.type);
                selectCampo.append($opt);
            } );
            if (fixedValuesTypes.indexOf(campos[0].type) != -1) {
                preencheValores('custom'+campos[0].id, selectValor);
                if ( selectOperador !== undefined ) {
                    selectOperador.val((fixedMultipleValuesTypes.indexOf(campos[0].type) != -1) ? 'possui' : '=');
                }
            } else {
                const $input = $('<input type="text" name="valor[]"/>');
                selectValor.replaceWith($input);
            }

        }
    });
}

function preencheResponsaveis( selectResponsaveis ) {
    selectResponsaveis.empty().append($('<option>CARREGANDO</option>'));
    $.ajax('./ajax/getResponsaveis.php', {
        method: 'get',
        success: function ( response ) {
            selectResponsaveis.empty();
            const responsaveis = JSON.parse(response);
            responsaveis.forEach( function ( x ) {
                const $opt = $('<option>'+x.name+'</option>');
                $opt.val(x.id);
                selectResponsaveis.append($opt);
            })
        }
    });
}

$(document).ready( function () {

    $('#catid').val($('input[name=categoria]').val());

    $('.div-regra').each( function () {

        const $current = $(this);
        const $campo = $current.find('[name^=campo]');
        const $operador = $current.find('[name^=operador]');
        const $valor = $current.find('[name^=valor]');
        const $responsavel = $current.find('[name^=responsavel]');

        const campoSel = $campo.attr('sel');
        const operadorSel = $current.find('[name^=operador]').attr('sel');
        const valorSel = $current.find('[name^=valor]').attr('sel');
        const responsavelSel = $current.find('[name^=responsavel]').attr('sel');

        if (campoSel.length) {
            $campo.val(campoSel);
            const type = $campo.find(':selected').attr('tp');
            $responsavel.val(responsavelSel);
            if ( fixedValuesTypes.indexOf( type ) != -1 ) {
                $operador.val( fixedMultipleValuesTypes.indexOf(type) != -1 ? 'possui' : '=');
                preencheValores(campoSel,$valor, valorSel);
            } else {
                $operador.val(operadorSel);
                const $input = $('<input type="text" name="valor[]"/>');
                $input.val(valorSel);
                $valor.replaceWith($input);
            }
        }
    });

    $('#div-regras').on('change','[name^=operador]',function () {
        const type = $(this).parent().find('[name^=campo] > :selected ').attr('tp');
        if (fixedValuesTypes.indexOf(type) != -1) {
            $(this).val( fixedMultipleValuesTypes.indexOf(type) != -1 ? 'possui' : '=');
        }
    });

    $('#div-regras').on('change','[name^=campo]',function () {
        debugger;
        const $select = $(this);
        const $opt = $select.find(':selected');
        const type = $opt.attr('tp');
        let $valor = $select.parent().find('[name^=valor]');
        const $operador = $select.parent().find('[name^=operador]');
        if (fixedValuesTypes.indexOf(type) == -1) {//campo livre
            if ($valor[0].tagName != 'INPUT') {
                const $input = $('<input type="text" name="valor[]"/>');
                $valor.replaceWith($input);
            }
        } else {
            $operador.val( fixedMultipleValuesTypes.indexOf(type) != -1 ? 'possui' : '=');
            if ($valor[0].tagName == 'INPUT') {
                const $selectValor = $('<select name="valor[]">');
                $valor.replaceWith($selectValor);
                $valor = $selectValor;
            }
            preencheValores($select.val(),$valor);
        }
    });

    $('#div-regras').on('click','.span-remove-regra',function() {
        $div = $(this).parent();
        $div.remove();
    });

    $('#div-regras').on('click','.span-sobe-regra',function() {
        const $regra = $(this).parent();
        const $anterior = $regra.prev();
        if ( $anterior.length > 0 ) {
            $regra.detach();
            $regra.insertBefore($anterior);
        }
    });

    $('#div-regras').on('click','.span-desce-regra',function() {
        const $regra = $(this).parent();
        const $proxima = $regra.next();
        if ($proxima.length) {
            $regra.detach();
            $regra.insertAfter($proxima);
        }
    });

    $('#div-regras').on('click','#span-adicionar-regra',function() {
        const $novo = $('<div class="div-regra">');
        const $campo = $('<select name="campo[]">');
        const $operador = $('<select name="operador[]">');
        const $valor = $('<select name="valor[]">');
        const $responsavel = $('<select name="responsavel[]">');
        todosOperadores.forEach( function (x) {
            $operador.append($( '<option value="' + x + '" >' + x + '</option>' ) );
        } );
        preencheCampo($('input[name=categoria]').val(),$campo,$valor, $operador);
        preencheResponsaveis($responsavel);
        $novo.append($campo);
        $novo.append($operador);
        $novo.append($valor);
        $novo.append($('<label>Atribuir para</label>'));
        $novo.append($responsavel);
        $novo.append($('<span class="span-remove-regra">|____X____|</span>'));
        $novo.append($('<p>'));


        $novo.insertBefore($('#span-adicionar-regra'));
    });

});
