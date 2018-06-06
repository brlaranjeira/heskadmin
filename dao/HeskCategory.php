<?php
/**
 * Created by PhpStorm.
 * User: brlaranjeira
 * Date: 05/06/18
 * Time: 12:13
 */

require_once (__DIR__ . '/EntidadeAbstrata.php');
class HeskCategory extends EntidadeAbstrata {


    /**
     * @var string
     */
    private $name;
    /**
     * @var integer
     */
    private $catOrder;
    /**
     * @var integer
     */
    private $autoassign;
    /**
     * @var integer
     */
    private $type;
    /**
     * @var integer
     */
    private $priority;

    protected static $tbName = 'hesk_categories';
    protected static $dicionario = [
        'name' => 'name',
        'catOrder' => 'cat_order',
        'autoassign' => 'autoassign',
        'type' => 'type',
        'priority' => 'priority'
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

    /**
     * @return int
     */
    public function getCatOrder() {
        return $this->catOrder;
    }

    /**
     * @param int $catOrder
     */
    public function setCatOrder( $catOrder ) {
        $this->catOrder = $catOrder;
    }

    /**
     * @return int
     */
    public function getAutoassign() {
        return $this->autoassign;
    }

    /**
     * @param int $autoassign
     */
    public function setAutoassign( $autoassign ) {
        $this->autoassign = $autoassign;
    }

    /**
     * @return int
     */
    public function getType() {
        return $this->type;
    }

    /**
     * @param int $type
     */
    public function setType( $type ) {
        $this->type = $type;
    }

    /**
     * @return int
     */
    public function getPriority() {
        return $this->priority;
    }

    /**
     * @param int $priority
     */
    public function setPriority( $priority ) {
        $this->priority = $priority;
    }



}