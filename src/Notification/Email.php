<?php

namespace PhpPlatform\Notification;

interface Email {
	
	const CC = 'CC';
	const BCC = 'BCC';
	
	/**
	 * add to-email address to the senders list
	 */
	function addAddress($address,$type=null);
	
	/**
	 * set email subject
	 */
	function setSubject($subject);
	
	/**
	 * set email message
	 */
	function setMessage($message);
	
	/**
	 * set from address
	 */
	function setFromAddress($from);
	
	/**
	 * set reply-to address
	 */
	function setReplyTo($replyTo);
	
	/**
	 * send email
	 */
	function send();
	
}