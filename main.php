<?php
/**
 * Created by PhpStorm.
 * User: brlaranjeira
 * Date: 05/06/18
 * Time: 11:28
 */



require_once (__DIR__ . '/dao/Usuario.php');

$usr = Usuario::restoreFromSession();
if (!isset($usr) || !$usr->hasGroup(Usuario::GRUPO_SSI)) {
    header('Location: ./login.php');
}


require_once (__DIR__ . '/dao/HeskCategory.php');
require_once (__DIR__ . '/dao/HeskCustomField.php');
require_once (__DIR__ . '/dao/HeskUser.php');


?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>HESKAdmin - principal </title>
        <link rel="stylesheet" type="text/css" href="./css/main.css"/>
    </head>
    <form action="" method="get">
        <label>Selecionar </label>
        <select name="catid" id="catid">
            <?
            $categorias = HeskCategory::getAll();
            foreach ($categorias as $categoria) {
                ?><option value="<?=$categoria->getId()?>"><?=$categoria->getName()?></option><?
            }
            ?>
        </select>
        <input type="submit" value="Selecionar">
    </form>

    <form action="salvaregras.php" method="post">
<?
if (isset($_GET) && isset($_GET['catid'])) {
    ?><input type="hidden" name="categoria" value="<?=$_GET['catid']?>"><?
    $categoria = HeskCategory::getById($_GET['catid']);
    echo 'Alterando atribuições dos tickets de ' . $categoria->getName(). '<br/>';

    $campos = array_filter ( HeskCustomField::getAll(), function( $param ) use (&$categoria) {
        return $param->getName() != null && in_array($categoria->getId(),$param->getCategory());
    });


    $regras = json_decode(file_get_contents('./regras.json'))->conjuntos;
    for ( $i = 0; $i < sizeof( $regras ); $i++ ) {
        if ($regras[$i]->categoria == $categoria->getId()) {
            $regras = $regras[$i]->regras;
            break;
        }
    }
    /*$regras = array_filter( $regras , function ( $param ) use ( &$categoria ) {
        return $param->categoria == $categoria->getId();
    } );*/
    echo '';
    ?><div id="div-regras"><?
        foreach ($regras as $regra) { ?>
            <?
            $selCampo = '';
            $selOperador = '';
            $selValor = '';
            $selResponsavel = '';
            if (!empty ( (array) $regra ) ) {
                $selCampo = $regra->condicao->campo;
                $selOperador = $regra->condicao->operador;
                $selValor = $regra->condicao->valor;
                $selResponsavel = $regra->responsavel;
            }
            ?>
            <div class="div-regra">
                <select sel="<?=$selCampo?>" name="campo[]"><?
                    foreach ($campos as $campo) {
                        echo '<option tp="' . $campo->getType() . '" value="custom' . $campo->getId() . '">'. $campo->getName() . '</option>';
                    }
                ?></select>
                <select sel="<?=$selOperador?>" name="operador[]">
                    <?
                    foreach ( [ '=' , 'possui' , '<' , '>' , '>=' , '<=' ] as $op ) {
                        echo "<option value=\"$op\">$op</option>";
                    }
                    ?>
                </select>
                <select sel="<?=$selValor?>" name="valor[]"></select>
                <label>Atribuir para</label>
                <select sel="<?=$selResponsavel?>" name="responsavel[]">
                    <? foreach (HeskUser::getAll() as $user ) {
                        $id = $user->getId();
                        $name = $user->getName();
                        echo "<option value=\"$id\">$name</option>";
                    }
                    ?>
                </select>
                <span class="span-sobe-regra">|____/\____|</span>
                <span class="span-desce-regra">|____\/____|</span>
                <span class="span-remove-regra">|____X____|</span>
            <p/> </div>
        <? }
    ?>
        <span id="span-adicionar-regra">|____+____|</span></div>
        <p/><input type="submit" value="Salvar regras para <?=$categoria->getName()?>">
    </form>
<? } ?>
</body>
<script language="ecmascript" type="application/ecmascript" src="./js/vendor/jquery.min.js"></script>
<script language="ecmascript" type="application/ecmascript" src="./js/main.js"></script>
</html>


