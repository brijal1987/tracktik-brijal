<?php
namespace Backend\Classes;

/**
 * Controller Class
 * @author Brijal Savaliya <brijal.savaliya@gmail.com>
 * @created on 3rd February 2021
 */
class Controller extends Base\ElectronicItem
{
	public function __construct()
	{
		$this->type = parent::ELECTRONIC_ITEM_EXTRA;
	}

	/**
	 * Limits the number of extras an Controller item can have.
	 * @return int Max number of extras or 0 for no extra
	 */
	public function maxExtras()
	{
        // The controller can't have any extras
		return 0;
	}

	/**
	 * Set accessor to define if the controller is wired or wireless.
	 * @param bool $isWired
	 */
	public function setWired($isWired)
	{
		$this->isWired = (bool)$isWired;
		$this->isWireless = !$this->isWired;
	}
}