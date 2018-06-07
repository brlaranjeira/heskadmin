<?php
/**
 * Created by PhpStorm.
 * User: brlaranjeira
 * Date: 05/06/18
 * Time: 15:04
 */

function getNewOwner( $ticket ) {
    require_once (__DIR__ . '/dao/HeskCustomField.php');
    $regras = json_decode(file_get_contents(__DIR__ .'/./regras.json'))->conjuntos;
    $achou = false;
    for ( $i = 0; $i < sizeof($regras); $i ++) {
        if ($regras[$i]->categoria == $ticket['category']) {
            $regras = $regras[$i]->regras;
            $achou = true;
            break;
        }
    }
    if ( $achou ) {
        foreach ($regras as $regra) {
            $lhs = strtolower($ticket[$regra->condicao->campo]);
            $rhs = strtolower($regra->condicao->valor);
            $operador = $regra->condicao->operador;
            $campo = HeskCustomField::getById(str_replace('custom','',$regra->condicao->campo));
            $tipo = $campo->getType();
            if ($tipo == 'date') {
                $lhs = DateTime::createFromFormat('d/m/Y',$_REQUEST['custom'.$campo->getId()])->setTime(0,0);
                $lhs = $lhs->getTimestamp();

                $rhs = DateTime::createFromFormat('d/m/Y',$rhs)->setTime(0,0);
                $rhs = $rhs->getTimestamp();
            }
            switch ($operador) {
                case '=':
                    if ($lhs == $rhs) {
                        return $regra->responsavel;
                    }
                    break;
                case '>':
                    if ($tipo == 'date' && intval($lhs) > intval($rhs)) {
                        return $regra->responsavel;
                    }
                    break;
                case '>=':
                    if ($tipo == 'date' && intval($lhs) > intval($rhs)) {
                        return $regra->responsavel;
                    }
                    break;
                case '<':
                    if ($tipo == 'date' && intval($lhs) > intval($rhs)) {
                        return $regra->responsavel;
                    }
                    break;
                case '<=':
                    if ($tipo == 'date' && intval($lhs) > intval($rhs)) {
                        return $regra->responsavel;
                    }
                    break;
                case 'possui':
                    if ( $tipo == 'text' ) {
                        return strstr($lhs,$rhs);
                    }
                    if ($tipo == 'checkbox') {
                        $lhs = explode('<br />',$lhs);
                        if (in_array($rhs,$lhs)) {
                            return $regra->responsavel;
                        }
                    }
                    break;
            }
        }
    }
    return 0;
}

