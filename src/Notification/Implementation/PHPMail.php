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
		return mail($this->getTo(),$this->getSubject(),$this->getMessage(),$this->getHeaders());
	}
	
	protected function getTo(){
		return implode(", ", $this->to);
	}
	
	protected function getSubject(){
		return $this->subject;
	}
	
	protected function getMessage(){
		return $this->message;
	}
	
	protected function getHeaders(){
		$cc = implode(", ", $this->cc);
		$bcc = implode(", ", $this->cc);
		
		$headers = array();
		foreach ($this->headers as $name=>$value){
			$headers[] = "$name: $value";
		}
		
		if(trim($cc) !== ""){
			$headers[] = "Cc: $cc";
		}
		if(trim($bcc) !== ""){
			$headers[] = "Bcc: $bcc";
		}
		
		return implode("\r\n", $headers);
	}
}