<?php

namespace PhpPlatform\Notification;

interface SMS {
	
	/**
	 * add phone numbers
	 */
	function addPhone($phone);
	
	/**
	 * add phone numbers
	 */
	function removePhone($phone);
	
	/**
	 * set sms message
	 */
	function setMessage($message);
	
	/**
	 * set from phone
	 */
	function setFromPhone($phone);
	
	/**
	 * send sms
	 */
	function send();
}