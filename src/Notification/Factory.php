<?php

namespace PhpPlatform\Notification;

use PhpPlatform\Config\Settings;
use PhpPlatform\Errors\Exceptions\Application\ProgrammingError;

class Factory {
	
	/**
	 * This method returns Email object
	 * @throws ProgrammingError
	 * @return Email
	 */
	static function getEmail(){
		$emailImplClassName = Settings::getSettings('php-platform/notification',"email.class");
		try{
			$emailImplReflectionClass = new \ReflectionClass($emailImplClassName);
		}catch (\ReflectionException $re){
			throw new ProgrammingError("email implementation class is not configured or invalid");
		}
		$emailInterfaceName = 'PhpPlatform\Notification\Email';
		if(!$emailImplReflectionClass->implementsInterface($emailInterfaceName)){
			throw new ProgrammingError("$emailImplClassName does not implement $emailInterfaceName");
		}
		
		return $emailImplReflectionClass->newInstance();
	}
	
	/**
	 * This method returns SMS object
	 * @throws ProgrammingError
	 * @return SMS
	 */
	static function getSMS(){
		$smsImplClassName = Settings::getSettings('php-platform/notification',"sms.class");
		try{
			$smsImplReflectionClass = new \ReflectionClass($smsImplClassName);
		}catch (\ReflectionException $re){
			throw new ProgrammingError("sms implementation class is not configured or invalid");
		}
		$smsInterfaceName = 'PhpPlatform\Notification\SMS';
		if(!$smsImplReflectionClass->implementsInterface($smsInterfaceName)){
			throw new ProgrammingError("$smsImplClassName does not implement $smsInterfaceName");
		}
		
		return $smsImplReflectionClass->newInstance();
	}
	
	
}