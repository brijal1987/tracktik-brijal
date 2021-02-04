<?php
namespace Backend\Classes\Base;
use Backend\Classes\Controller;
use Exception;
/**
 * Electronic Item Class
 * @author Brijal Savaliya <brijal.savaliya@gmail.com>
 * @created on 3rd February 2021
 */
abstract class ElectronicItem
{
	/**
	 * @var float price
	 */
	protected $price = 0.0;

	/**
	 * @var string
	 */
	protected $type;

	/**
	 * @var bool
	 */
	protected $isWired = false;
	/**
	 * @var bool
	 */
	protected $isWireless = false;

	/**
	 * @var \ElectronicItem\Controller[]
	 */
	protected $extras = [];

	const ELECTRONIC_ITEM_TELEVISION = 'television';
	const ELECTRONIC_ITEM_CONSOLE = 'console';
	const ELECTRONIC_ITEM_MICROWAVE = 'microwave';
	const ELECTRONIC_ITEM_EXTRA = 'controller';

	/**
	 * Types enumeration.
	 * @var string[]
	 */
	const TYPES = [
		self::ELECTRONIC_ITEM_CONSOLE,
		self::ELECTRONIC_ITEM_MICROWAVE,
		self::ELECTRONIC_ITEM_TELEVISION,
		self::ELECTRONIC_ITEM_EXTRA
    ];

	/**
	 * Limits the number of extras an electronic item can have.
	 * @return int Max number of extras or 0 for no extra, -1 for no maximum limit
	 */
	abstract protected function maxExtras();

	/**
	 * Set the item price.
	 * @param float $price
	 */
	public function setPrice($price)
	{
		$this->price = $price;
	}

	/**
	 * Get the item price.
	 * @return float
	 */
	public function getPrice()
	{
		return $this->price;
	}

	/**
	 * Get Total price for all extra controller.
	 * @return float
	 */
	public function getExtrasPrice()
	{
		$price = 0;

		foreach ($this->extras as $extra)
		{
            $price += $extra->getPrice();
        }

		return $price;
	}

	/**
	 * Get Extras
	 */
	public function getExtras()
	{
		return $this->extras;
	}

	/**
	 * Set the item type.
	 * @param string $type
	 */
	public function setType($type)
	{
		$this->type = $type;
	}

	/**
	 * Get the item type.
	 * @return string
	 */
	public function getType()
	{
		return $this->type;
	}

	/**
	 * Check is item compatible with wired controller?
	 * @return bool
	 */
	public function isWired()
	{
		return $this->isWired;
	}

	/**
	 * Check is item compatible with wireless controller?
	 * @return bool
	 */
	public function isWireless()
	{
		return $this->isWireless;
    }

	/**
	 * Add an extra controller after checking all requirements.
	 * @param \ElectronicItem\Controller $extra
	 * @throws Exception If the limit is reached
	 */
	public function addExtra(Controller $extra)
	{
		// For Console
		if (count($this->extras) == $this->maxExtras())
		{
            throw new Exception('you cannot add more extra controller with a ' . $this->type);
        }

		if ($extra->isWired() && !$this->isWired())
		{
            throw new Exception('you cannot add a wired controller with a ' . $this->type);
        }

		if ($extra->isWireless() && !$this->isWireless())
		{
            throw new Exception('you cannot add a wireless controller with a ' . $this->type);
        }

		$this->extras[] = $extra;
	}

	public function getExtrasCount()
	{
		return count($this->extras);
	}
}