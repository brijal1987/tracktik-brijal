<?php
/**
 * Command Line Interface for testing.
 * @author Brijal Savaliya <brijal.savaliya@gmail.com>
 * @created on 4th February 2021
 *
 * Colors for console
 * $black = "33[0;30m";
 * $darkgray = "33[1;30m";
 * $blue = "33[0;34m";
 * $lightblue = "33[1;34m";
 * $green = "33[0;32m";
 * $lightgreen = "33[1;32m";
 * $cyan = "33[0;36m";
 * $lightcyan = "33[1;36m";
 * $red = "33[0;31m";
 * $lightred = "33[1;31m";
 * $purple = "33[0;35m";
 * $lightpurple = "33[1;35m";
 * $brown = "33[0;33m";
 * $yellow = "33[1;33m";
 * $lightgray = "33[0;37m";
 * $white = "33[1;37m";
 */

require_once __DIR__ . '/../vendor/autoload.php';
use \Backend\Classes\Base\ElectronicItems;
use \Backend\Classes\Base\ElectronicItem;
use \Backend\Classes\Controller;
use \Backend\Classes\Console;
use \Backend\Classes\Television;
use \Backend\Classes\Microwave;

// Print bill on console
function printBill($items, $reportWidth) {
    echo printFirstQuestion($items, $reportWidth);
    echo printSecondQuestion($items, $reportWidth);
    echo "\33[1;37m";
}

// Print first question
function printFirstQuestion($items, $width = 100) {
    $rows = [
        str_pad("\n", 0, ' ', STR_PAD_RIGHT)
    ];
    $typeArray = [];

    $rows[] =  str_pad("\33[0;32mQuestion 1: Using the code given, create each type of electronic as classes. Every \33[1;33mElectronicItem\33[0;32m must have a function called \33[1;33mmaxExtras\33[0;32m that limits the number of extras an electronic item can have. The extras are a list of electronic items that are attached to another electronic item to complement it.", $width, ' ', STR_PAD_RIGHT);
    if(count($items->getSortedItemsByPrice()) > 0) {
        $rows[] = str_pad("\33[0;34mTHIS IS YOUR FINAL BILL:\n", $width, ' ', STR_PAD_RIGHT);
        foreach ($items->getSortedItemsByPrice() as $key=>$item) {
            if(!isset($typeArray[$item->getType()])) {
                $typeArray[$item->getType()] = 1;
            }
            $rows[] = str_pad("\33[0;35m" .ucfirst($item->getType()). " " .($typeArray[$item->getType()]).":" , $width-10, ' ', STR_PAD_RIGHT) . str_pad("\t\t\t$" . number_format($item->getPrice(), 2), 10, ' ', STR_PAD_LEFT);

            if($item->getExtrasCount() > 0) {
                $rows[] = str_pad("\33[1;35m\t+ ". $item->getExtrasCount() . " Extra ". ucfirst(ElectronicItem::ELECTRONIC_ITEM_EXTRA). "", $width-10, ' ', STR_PAD_RIGHT);
                foreach($item->getExtras() as $extra) {
                    if($extra->isWired()) {
                        $rows[] = str_pad( "\t". ucfirst(ElectronicItem::ELECTRONIC_ITEM_EXTRA). " (Wired)", $width-10, ' ', STR_PAD_RIGHT) . str_pad("\t$" . number_format($extra->getPrice(), 2), 10, ' ', STR_PAD_LEFT);
                    } else if ($extra->isWireless()) {
                        $rows[] = str_pad( "\t". ucfirst(ElectronicItem::ELECTRONIC_ITEM_EXTRA). " (Wireless)", $width-10, ' ', STR_PAD_RIGHT) . str_pad("\t$" . number_format($extra->getPrice(), 2), 10, ' ', STR_PAD_LEFT);
                    }
                }
            }
            $typeArray[$item->getType()]++;
        }
        $rows[] = str_repeat('-', $width + 10);
        $rows[] = str_pad("\33[1;34m"."Total Amount:", $width-10, ' ', STR_PAD_RIGHT) . str_pad("\t\t\t$" . number_format($items->getTotalPrice(), 2), 10, ' ', STR_PAD_LEFT);
    } else {
        $rows[] = str_pad("\33[0;35mNo Items Purchased yet.", $width, ' ', STR_PAD_RIGHT);
    }
    return implode("\n\n", $rows);
}

// Print second question
function printSecondQuestion($items, $width = 100) {
    $rows = [
        str_pad("\n", 0, ' ', STR_PAD_RIGHT)
    ];
    $rows[] =  str_pad("\33[0;32mQuestion 2: That person's friend saw her with her new purchase and asked her how much the console and its controllers had cost her. Give the answer.", $width-10, ' ', STR_PAD_RIGHT);
    $consoles = $items->getItemsByType(ElectronicItem::ELECTRONIC_ITEM_CONSOLE);
    if(count($consoles) > 0) {
        $rows[] =  str_pad("\33[1;34mYou have purchased total " . count($consoles). " ". ucfirst(ElectronicItem::ELECTRONIC_ITEM_CONSOLE). "", $width, ' ', STR_PAD_RIGHT);
        $total = 0;
        foreach($consoles as $key=>$console) {
            $rows[] =  str_pad("\33[0;35m". ucfirst(ElectronicItem::ELECTRONIC_ITEM_CONSOLE). " ".($key+1).":", $width - 10, ' ', STR_PAD_RIGHT) . str_pad("\t\t\t$" . $console->getPrice()."", 10, ' ', STR_PAD_LEFT);
            if($console->getExtrasCount() > 0) {
                $rows[] = str_pad("\33[1;35m\t+ ". $console->getExtrasCount() . " Extra ". ucfirst(ElectronicItem::ELECTRONIC_ITEM_EXTRA). "", $width-10, ' ', STR_PAD_RIGHT);
                foreach($console->getExtras() as $extra) {
                    if($extra->isWired()) {
                        $rows[] = str_pad( "\t". ucfirst(ElectronicItem::ELECTRONIC_ITEM_EXTRA). " (Wired)", $width-10, ' ', STR_PAD_RIGHT) . str_pad("\t$" . number_format($extra->getPrice(), 2), 10, ' ', STR_PAD_LEFT);
                    } else if ($extra->isWireless()) {
                        $rows[] = str_pad( "\t". ucfirst(ElectronicItem::ELECTRONIC_ITEM_EXTRA). " (Wireless)", $width-10, ' ', STR_PAD_RIGHT) . str_pad("\t$" . number_format($extra->getPrice(), 2), 10, ' ', STR_PAD_LEFT);
                    }
                }
            }
            $total += $console->getPrice() + $console->getExtrasPrice();
        }
        $rows[] = str_repeat('-', $width + 10);
        $rows[] =  str_pad("\33[1;34mTotal Amount:" ."", $width-10, ' ', STR_PAD_RIGHT) . str_pad("\t\t\t$" . ($total)."", 10, ' ', STR_PAD_LEFT);

    } else {
        $rows[] =  str_pad( "\33[1;34mI didn't buy any console yet.", $width-10, ' ', STR_PAD_RIGHT);
    }
    $rows[] =  str_pad("\33[1;37m", 0, ' ', STR_PAD_RIGHT);
    return implode("\n\n", $rows);
}