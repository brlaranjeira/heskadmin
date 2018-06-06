<?php
/**
 * Created by PhpStorm.
 * User: brlaranjeira
 * Date: 05/06/18
 * Time: 15:08
 */

require_once (__DIR__ . '/EntidadeAbstrata.php');
class HeskUser extends EntidadeAbstrata {

    /**
     * @var string
     */
    private $name;

    protected static $tbName = 'hesk_users';
    protected static $dicionario = [
        'name' => 'name'
    ];

    /**
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName( $name ) {
        $this->name = $name;
    }



}