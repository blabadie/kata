<?php


namespace GildedRose;


class Updater implements UpdaterInterface
{

    protected static UpdaterInterface $instance;
    /**
     * Updater constructor.
     */
    protected function __construct()
    {

    }

    public static function getInstance()
    {
        if(empty(static::$instance)) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    final public function update(Item $item)
    {
        $this->updateAge($item);
        $this->updateQuality($item);
        if($item->quality < 0) {
            $item->quality=0;
        }
    }

    protected function updateQuality(Item $item)
    {
        if ($item->quality > 0) {
            $item->quality = $item->quality - ($item->sellIn >= 0 ? 1 : 2);
        }
    }

    protected function updateAge(Item $item)
    {
        $item->sellIn--;
    }
}