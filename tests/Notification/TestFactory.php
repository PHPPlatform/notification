<?php
namespace PhpPlatform\Tests\Notification;

use PhpPlatform\Errors\Exceptions\Application\ProgrammingError;
use PhpPlatform\Mock\Config\MockSettings;
use PhpPlatform\Config\SettingsCache;
use PhpPlatform\Notification\Factory;

class TestFactory extends \PHPUnit_Framework_TestCase {
	
	protected function setUp(){
		SettingsCache::getInstance()->reset();
		parent::setUp();
	}
	
	function testFactory(){
		// invoke factory without configuration
		$isException = false;
		try{
			Factory::getSMS();
		}catch (ProgrammingError $e){
			$isException = true;
			parent::assertEquals('sms implementation class is not configured or invalid', $e->getMessage());
		}
		parent::assertTrue($isException);
		
		
		// invoke factory with wrong configuration
		MockSettings::setSettings('php-platform/notification', 'sms.class', 'NonExistingClass');
		$isException = false;
		try{
			Factory::getSMS();
		}catch (ProgrammingError $e){
			$isException = true;
			parent::assertEquals('sms implementation class is not configured or invalid', $e->getMessage());
		}
		parent::assertTrue($isException);
		
		// invoke factory with class without implementing Session Interface
		MockSettings::setSettings('php-platform/notification', 'sms.class', 'PhpPlatform\Tests\Notification\SampleSMSWithoutInterface');
		$isException = false;
		try{
			Factory::getSMS();
		}catch (ProgrammingError $e){
			$isException = true;
			parent::assertEquals('PhpPlatform\Tests\Notification\SampleSMSWithoutInterface does not implement PhpPlatform\Notification\SMS', $e->getMessage());
		}
		parent::assertTrue($isException);
		
		// invoke with proper configuration
		$email = Factory::getEmail();
		parent::assertEquals('PhpPlatform\Notification\Implementation\PHPMail', get_class($email));
		
		// invoke factory with wrong configuration
		MockSettings::setSettings('php-platform/notification', 'email.class', 'NonExistingClass');
		$isException = false;
		try{
			Factory::getEmail();
		}catch (ProgrammingError $e){
			$isException = true;
			parent::assertEquals('email implementation class is not configured or invalid', $e->getMessage());
		}
		parent::assertTrue($isException);
		
		// invoke factory with class without implementing Session Interface
		MockSettings::setSettings('php-platform/notification', 'email.class', 'PhpPlatform\Tests\Notification\SampleEmailWithoutInterface');
		$isException = false;
		try{
			Factory::getEmail();
		}catch (ProgrammingError $e){
			$isException = true;
			parent::assertEquals('PhpPlatform\Tests\Notification\SampleEmailWithoutInterface does not implement PhpPlatform\Notification\Email', $e->getMessage());
		}
		parent::assertTrue($isException);
		
	}
	
}