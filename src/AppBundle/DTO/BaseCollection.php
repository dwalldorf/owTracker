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
    private $totalItems = 0;

    /**
     * @var bool
     */
    private $hasMore = false;

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
     * @param int $limit
     */
    public function setItems($items, $limit = 0) {
        if (!is_array($items) && !$items) {
            $items = [];
        }

        if ($limit > 0 && count($items) > $limit) {
            while (count($items) > $limit) {
                array_pop($items);
            }

            $this->setHasMore();
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

    /**
     * @return boolean
     */
    public function getHasMore() {
        return $this->hasMore;
    }

    /**
     * @param boolean $hasMore
     */
    public function setHasMore($hasMore = true) {
        $this->hasMore = $hasMore;
    }
}