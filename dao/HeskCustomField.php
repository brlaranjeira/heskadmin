<?php
/**
 * Created by PhpStorm.
 * User: brlaranjeira
 * Date: 05/06/18
 * Time: 12:01
 */

require_once ( __DIR__ . '/EntidadeAbstrata.php' );
class HeskCustomField extends EntidadeAbstrata {

    /**
     * @var integer
     */
    private $use;

    /**
     * @var integer
     */
    private $place;

    /**
     * @var string
     */
    private $type;

    /**
     * @var integer
     */
    private $req;

    /**
     * @var integer[]
     */
    private $category;

    /**
     * @var string
     */
    private $name;

    /**
     * @var stdClass
     */
    private $value;

    /**
     * @var integer
     */
    private $order;

    protected static $tbName = 'hesk_custom_fields';
    protected static $dicionario = [
        'use' => 'use',
        'place' => 'place',
        'type' => 'type',
        'req' => 'req',
        'category' => 'category',
        'name' => 'name',
        'value' => 'value',
        'order' => 'order'
    ];

    /**
     * @return int
     */
    public function getUse() {
        return $this->use;
    }

    /**
     * @param int $use
     */
    public function setUse( $use ) {
        $this->use = $use;
    }

    /**
     * @return int
     */
    public function getPlace() {
        return $this->place;
    }

    /**
     * @param int $place
     */
    public function setPlace( $place ) {
        $this->place = $place;
    }

    /**
     * @return string
     */
    public function getType() {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType( $type ) {
        $this->type = $type;
    }

    /**
     * @return int
     */
    public function getReq() {
        return $this->req;
    }

    /**
     * @param int $req
     */
    public function setReq( $req ) {
        $this->req = $req;
    }

    /**
     * @return integer[]
     */
    public function getCategory() {
        return $this->category;
    }

    /**
     * @param integer[] $category
     */
    public function setCategory($category) {
        $this->category = json_decode($category);
    }

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
        $obj = json_decode($name);
        foreach ($obj as $k => $v) {
            $this->name = $v;
            return;
        }
    }

    /**
     * @return stdClass
     */
    public function getValue() {
        return $this->value;
    }

    /**
     * @param stdClass $value
     */
    public function setValue( $value ) {
        $obj = json_decode($value);
        $this->value = $obj;
    }

    /**
     * @return int
     */
    public function getOrder() {
        return $this->order;
    }

    /**
     * @param int $order
     */
    public function setOrder( $order ) {
        $this->order = $order;
    }




}