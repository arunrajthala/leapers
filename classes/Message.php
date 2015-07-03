<?php

//if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Message
{

	private $messageDetail;
	private $messageType;

	public function __construct()
	{

	}

	public function DisplayMsg()
	{
		if (!isset($_SESSION['sys_message'])) {
			return false;
			$_SESSION['sys_message'] = '';
			$_SESSION['sys_messagetype'] = 0;
		}
		$this->messageDetail = $_SESSION['sys_message'];
		$this->messageType = $_SESSION['sys_messagetype'];
		$_SESSION['sys_message'] = '';
		$_SESSION['sys_messagetype'] = 0;
		return array($this->messageDetail, $this->messageType);
	}

	public function set($msg, $msgtype = 0)
	{
		$_SESSION['sys_message'].=$msg . "\t";
		$_SESSION['sys_messagetype'] = $msgtype;
	}

	public function setMastterdata($msg)
	{
		$_SESSION['sys_data'] = $msg;
	}

	public function sendMailFromSystem($to, $title, $body, $attachment = '')
	{


		$email = APP_EMAIL; //'hanchyguy@yahoo.com';
		$author = APP_NAME;
		$mail = new PHPMailer();
		$mail->AddAddress($to);
		$mail->Subject = $title;
		if ($attachment != '') {
			$mail->AddAttachment($attachment);
		}
		//$mail->SetFrom=$author.'[ '.$email.' ]';
		$mail->SetFrom($email, $author);
		$mail->Body = $body;
		return($mail->Send());
	}

	public function sendMailToSystem($author, $title, $body, $attachment = '')
	{


		$to = APP_EMAIL; //'hanchyguy@yahoo.com';
		//$author=APP_NAME;
		$mail = new PHPMailer();
		$mail->AddAddress($to);
		$mail->Subject = $title;
		if ($attachment != '') {
			$mail->AddAttachment($attachment);
		}
		//$mail->SetFrom=$author.'[ '.$email.' ]';
		$mail->SetFrom($author);
		$mail->Body = $body;
		return($mail->Send());
	}

}
