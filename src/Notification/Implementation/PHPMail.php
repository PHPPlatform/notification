<?php

namespace PhpPlatform\Notification\Implementation;

use PhpPlatform\Notification\Email;

class PHPMail implements Email {
	protected $to = array();
	protected $cc = array();
	protected $bcc = array();
	protected $headers = array();
	protected $subject = "";
	protected $message = "";
	
	public function setSubject($subject) {
		$this->subject = $subject;
		return $this;
	}
	
	public function setFromAddress($from) {
		$this->headers['From'] = $from;
		return $this;
	}
	
	public function addAddress($address, $type = null) {
		switch ($type){
			case self::CC : 
				$this->cc[] = $address;
				break;
			case self::BCC : 
				$this->bcc[] = $address;
				break;
			default:
				$this->to[] = $address;
		}
		return $this;
	}
	
	public function setReplyTo($replyTo) {
		$this->headers['Reply-To'] = $replyTo;
		return $this;
	}
	
	public function setMessage($message) {
		$this->message = $message;
	}
	
	public function send() {
		$to = implode(", ", $this->to);
		$cc = implode(", ", $this->cc);
		$bcc = implode(", ", $this->cc);
		
		$headers = array_map(function($name,$value){return $name.": ".$value;},$this->headers);
		if(trim($cc) !== ""){
			$headers[] = "Cc: $cc";
		}
		if(trim($bcc) !== ""){
			$headers[] = "Bcc: $bcc";
		}
		
		$header = implode("\r\n", $headers);
		
		return mail($to,$this->subject,$this->message,$header);
	}
}