<?php


namespace GildedRose;


class UpdaterFactory
{
    public static function getUpdater(Item $item) : Updater
    {
        if ($item->name == 'Aged Brie') {
            return UpdaterAgedBrie::getInstance();
        } elseif ($item->name == 'Sulfuras, Hand of Ragnaros'){
            return UpdaterSulfuras::getInstance();
        } elseif(strpos($item->name, 'Backstage passes') !== false) {
            return UpdaterBackstage::getInstance();
        } elseif(strpos($item->name, 'Conjured') !== false) {
            return UpdaterConjured::getInstance();
        } else {
            return Updater::getInstance();
        }
    }
}