<?php
/**
 * Command Line Interface for testing.
 * @author Brijal Savaliya <brijal.savaliya@gmail.com>
 * @created on 4th February 2021
 */
require_once __DIR__ . '/../vendor/autoload.php';
use \Backend\Classes\Base\ElectronicItems;
use \Backend\Classes\Base\ElectronicItem;
use \Backend\Classes\Controller;
use \Backend\Classes\Console;
use \Backend\Classes\Television;
use \Backend\Classes\Microwave;

$items = new ElectronicItems();
$reportWidth = 50;
echo "\n\33[0;32m WELCOME TO THE TRACKTIC ELECTRONIC STORE\n";

// Here we can add maximun 10 items for testing purpose, we can do it better if needed by config/.env
for ($i=0; $i < 10; ++$i)
{
	$item = null;

    echo "\n\33[1;33m",
        "Please choose the items you would like to buy?:\n",
        "\33[0;36m",
        "\n1. ". ucfirst(ElectronicItem::ELECTRONIC_ITEM_CONSOLE). "\n",
		"2. ". ucfirst(ElectronicItem::ELECTRONIC_ITEM_TELEVISION). "\n",
        "3. ". ucfirst(ElectronicItem::ELECTRONIC_ITEM_MICROWAVE). "\n";
    if($items->getItemCount() <= 0) {
        echo "4. Generate your old bill\n";
    }

    echo  "0. I have completed shopping, Let's go to the final amount\n";
    echo "\n\33[1;31m";
	switch (readline('Type a number: '))
	{
        case '1':
            $item = new Console();
        break;
        case '2':
            $item = new Television();
        break;
        case '3':
            $item = new Microwave();
        break;
        case '4':
            return printBill($items->setUpDefaultItems(), $reportWidth);
        default:
        break 2;
    }

    // Random price
	$item->setPrice(round(rand(500, 1000) / rand(1, 10), 2));

	for ($j = $item->maxExtras(); $j != 0; --$j)
	{
        echo "\n\33[1;33m",
            "Do you want to add an extra to your purchase?\n",
			"\33[0;36m\n",
			"1. Yes, add one remote ". ucfirst(ElectronicItem::ELECTRONIC_ITEM_EXTRA). "\n",
            "2. Yes, add one wired ". ucfirst(ElectronicItem::ELECTRONIC_ITEM_EXTRA). "\n",
            "0. Go Back to items\n";

		$extra = new Controller();
		$extra->setPrice(round(rand(10, 50) / rand(1, 10), 2));  // Random price
        echo "\n\33[1;31m";
		switch (readline('Type a number: '))
		{
            case '1':
                $extra->setWired(false);
            break;
            case '2':
                $extra->setWired(true);
            break;
            default:
            break 2;
		}

		try
		{
            $item->addExtra($extra);
        }
		catch (Exception $e)
		{
            echo "\n\33[0;31mError:  " . $e->getMessage(), "!\n";
        }
	}

	$items->addItem($item);
}

echo printBill($items, $reportWidth);
