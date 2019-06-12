<?php

require_once '../form/ContactForm.php';

if ($_SERVER['REQUEST_METHOD'] != 'POST'){
			
			$json = json_encode(array(
							'success' 	=>	false,
							'mail'		=>	'Not Post',
							'error'		=> 'error'
										));
			exit;
										
		}else{
			
				$errors			=	array();
				$data			=	array();
				$arr			=	$_POST;

				$forma			=	new ContactForm();
				
				$data			=	$forma->validateFilter($arr);
				$errors 		=	$forma->isValid($data);
				
				
				
				if (!$errors) {	
						
				$senderName = htmlspecialchars($data['name']);
				$senderName = strip_tags($senderName);
				$senderName = mb_substr($senderName,0,200,'UTF-8');
				
				$senderEmail = htmlspecialchars($data['email']);
				$senderEmail = strip_tags($senderEmail);
				$senderEmail = mb_substr($senderEmail,0,200,'UTF-8');
				
				$senderMessage = htmlspecialchars($data['message']);
				$senderMessage = strip_tags($senderMessage);		
				$senderMessage = mb_substr($senderMessage,0,600,'UTF-8');
				
				$to  = "sipkevich@inbox.lv"; 
				//$to  = "olegoznov@inbox.lv";
				//$to  = "sipkevica@gmail.com";
				$subject  = "Message from a visitor of site"; 
				$message  = "Name:    	".$senderName." <br>";
				$message .= "Contact:  	".$senderEmail."<br>";
				$message .= "Message:   ".$senderMessage."<br>";
				
				$headers  = "Content-type: text/html; charset=utf-8 \r\n";
				//$headers .= "Bcc: sipkevich@inbox.lv\r\n";		
				$headers .= "From: <no-replay@inbox.lv>\r\n"; 
				$headers .= "Reply-To: no-replay@inbox.lv\r\n"; 
		
				$mail = mail($to, $subject, $message, $headers); 
		
				echo json_encode(array(
					'success'=> true,
					'message'=> $mail,
					'error' => 'no errors'
				));		
				exit;		
		}
		
		if ($errors) {
			echo json_encode(array(
					'success'=>false,
					'message'=> 'Не все поля заполненны правильно!',
					'error' => $errors
				));	

		}
			
}













?>