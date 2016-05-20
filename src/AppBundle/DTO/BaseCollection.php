<?php

namespace AppBundle\DTO;

class BaseCollection {

    /**
     * @var array
     */
    private $items = [];

    /**
     * @var int
     */
    private $totalItems;

    /**
     * BaseCollection constructor.
     * @param array $items
     * @param int $totalItems
     */
    public function __construct(array $items = [], $totalItems = null) {
        $this->items = $items;
        $this->setTotalItems();
    }

    /**
     * @return array
     */
    public function getItems() {
        return $this->items;
    }

    /**
     * @param array $items
     */
    public function setItems($items) {
        if (!is_array($items) && !$items) {
            $items = [];
        }

        $this->items = $items;
        $this->setTotalItems();
    }

    /**
     * @param mixed $item
     */
    public function addItem($item) {
        $this->items = $item;
        $this->setTotalItems();
    }

    /**
     * @return int
     */
    public function getTotalItems() {
        return $this->totalItems;
    }

    protected function setTotalItems() {
        $this->totalItems = count($this->items);
    }
}