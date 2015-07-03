<?php

class Mail

{

	function sendMail($reciever_email, $sub, $msg, $sender_name, $sender_email)

	{
        
		$headers  = 'MIME-Version: 1.0' . "\r\n";

		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";	
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers .= 'From:  <admin@itechnepal.com>\r\n';
		$headers .= 'From: '.$sender_name.'<'.$sender_email.'>' . "\r\n";

		if(mail($reciever_email, $sub, $msg, $headers)) {

			return true;

		} else { 

			return false;

		}		

	}

	

	function sendMailFromSytem($reciever_email, $sub, $msg)

	{

            //$objStoreSetting = new StoreSettings();

            //$row_store_setting = $objStoreSetting->selectStoreSettings();
        $objSetting= new PDODatabase;
        $objSetting->setMasterData('set01settings',array('uin','email','name'),'set01');
        $setringData=$objSetting->getByID_v2(1);
            
        //echo $reciever_email;die();
		$sender_name = 'Itech Nepal ';//$row_store_setting['name'];

		$sender_email = '<'.$setringData['set01email'].'>';//$row_store_setting['outgoing_mail'];

		$headers  = 'MIME-Version: 1.0' . "\r\n";

		//$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";	

		$headers .= 'From: '.$sender_name.'<'.$sender_email.'>' . "\r\n";
		
		//echo $msg;
        
		if(mail($reciever_email, $sub, $msg)) {

			return true;

		} else { 

			return false;

		}		

	}

	

	

	/*function sendMail($reciever_email, $sub, $msg, $sender_name, $sender_email) 

	{

       $this->Subject = $sub;

       $this->Sender = $sender_email;

       $this->From = $sender_email;

       $this->FromName = $sender_name;

       $this->SetFrom($sender_email, $sender_name);

       $this->AddAddress($reciever_email);

       $this->MsgHTML($msg);

       if($this->Send()) {

	   	return true;

	   } else {

	   	return false;

	   }

   }*/

}