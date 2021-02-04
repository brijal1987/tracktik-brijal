<?php
namespace Backend\Classes\Base;

/**
 * Electronic Items Class
 * @author Brijal Savaliya <brijal.savaliya@gmail.com>
 * @created on 3rd February 2021
 */
class ElectronicItems
{
	/**
	 * @var ElectronicItems[]
	 */
	private $items = array();

	/**
	 * Get Items count.
	 */
	public function getItemCount()
	{
		return count((array) $this->items);
	}

	/**
	 * Add ElectronicItem.
	 * @param \ElectronicItem\ElectronicItem $item
	 */
	public function addItem(ElectronicItem $item)
	{
		$this->items[] = $item;
	}

	/**
	 * Returns the items based on the sorting type passed.
	 * @param bool by default it is ascending order, if $order= desc then descending order
	 * @return array
	 */
	public function getSortedItemsByPrice($order = 'asc')
	{
        $sorted = array();
        foreach ( $this->items as $item ) {
            $sorted[($item->getPrice() * 100)] = $item;
        }
        ksort($sorted, SORT_NUMERIC);
		return ($order == 'asc') ? $sorted : array_reverse($sorted);
    }

	/**
	 * Returns specific type of items.
	 * @param string $type
	 * @return \ElectronicItem\ElectronicItem[] | false
	 */
	public function getItemsByType($type)
	{
		if (in_array($type, ElectronicItem::TYPES))
		{
			return array_filter($this->items, function($item) use ($type)
			{
				return $item->getType() == $type;
			});
		}

		return false;
	}

	/**
	 * Get total price of all the items
	 * @return float
	 */
	public function getTotalPrice()
	{
		$total = 0.0;

		foreach ($this->items as $item)
		{
            $total += $item->getPrice() + $item->getExtrasPrice();
        }

		return $total;
	}

	/**
	 * Get default items
	 * @return array
	 */
	public static function getDefaultItems() {
		return [
			[
				'type' => ElectronicItem::ELECTRONIC_ITEM_CONSOLE,
				'price' => 99.99,
				'wired' => true,
				'extras' => [
					[
						'type' => ElectronicItem::ELECTRONIC_ITEM_EXTRA,
						'price' => 5.99,
						'wired' => false
					],
					[
						'type' => ElectronicItem::ELECTRONIC_ITEM_EXTRA,
						'price' => 5.99,
						'wired' => false
					],
					[
						'type' => ElectronicItem::ELECTRONIC_ITEM_EXTRA,
						'price' => 3.99,
						'wired' => true
					],
					[
						'type' => ElectronicItem::ELECTRONIC_ITEM_EXTRA,
						'price' => 3.99,
						'wired' => true
					]
				]
			],
			[
				'type' => ElectronicItem::ELECTRONIC_ITEM_TELEVISION,
				'price' => 89.99,
				'wired' => true,
				'extras' => [
					[
						'type' => ElectronicItem::ELECTRONIC_ITEM_EXTRA,
						'price' => 4.99,
						'wired' => false
					],
					[
						'type' => ElectronicItem::ELECTRONIC_ITEM_EXTRA,
						'price' => 4.99,
						'wired' => false
					]
				]
			],
			[
				'type' => ElectronicItem::ELECTRONIC_ITEM_TELEVISION,
				'price' => 150.99,
				'wired' => true,
				'extras' => [
					[
						'type' => ElectronicItem::ELECTRONIC_ITEM_EXTRA,
						'price' => 8.99,
						'wired' => false
					]
				]
			],
			[
				'type' => ElectronicItem::ELECTRONIC_ITEM_MICROWAVE,
				'price' => 199.99,
				'wired' => true
			]
		];
	}

	/**
	 * Setup defalut items
	 */
	public static function setUpDefaultItems() {
		$items = new ElectronicItems();
		foreach(self::getDefaultItems() as $item) {
			switch($item['type']){
				case ElectronicItem::ELECTRONIC_ITEM_CONSOLE:
					$console = new \Backend\Classes\Console();
					$console->setPrice($item['price']);
					foreach($item['extras'] as $extras) {
						$extra = new \Backend\Classes\Controller();
						$extra->setPrice($extras['price']);
						$extra->setWired($extras['wired']);
						$console->addExtra($extra);
					}
					$items->addItem($console);
				break;
				case ElectronicItem::ELECTRONIC_ITEM_TELEVISION:
					$tv = new \Backend\Classes\Television();
					$tv->setPrice($item['price']);
					foreach($item['extras'] as $extras) {
						$extra = new \Backend\Classes\Controller();
						$extra->setPrice($extras['price']);  // Random price
						$extra->setWired($extras['wired']);
						$tv->addExtra($extra);
					}
					$items->addItem($tv);
				break;
				case ElectronicItem::ELECTRONIC_ITEM_MICROWAVE:
					$microwave = new \Backend\Classes\Microwave();
					$microwave->setPrice($item['price']);
					$items->addItem($microwave);
				break;
				default:
			}
		}
		return $items;
	}

}