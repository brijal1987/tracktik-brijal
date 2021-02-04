<?php
namespace Backend\Classes;

/**
 * Television Class
 * @author Brijal Savaliya <brijal.savaliya@gmail.com>
 * @created on 3rd February 2021
 */
class Television extends Base\ElectronicItem
{
	public function __construct()
	{
		$this->type = parent::ELECTRONIC_ITEM_TELEVISION;
		$this->isWired = false;
		$this->isWireless = true;
	}

	/**
	 * Limits the number of extras an Television can have.
	 * @return int Max number of extras or 0 for no extra
	 */
	public function maxExtras()
	{
        // The television has no maximum extras
		return -1;
	}
}