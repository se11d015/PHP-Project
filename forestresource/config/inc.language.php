<?php
	if (!$session->isregistered('forestresource_lang'))
	{
		$session->set('forestresource_lang',1);
	}
	
	if($session->get('forestresource_lang') == 1){
		include('config/language_mn.php');
	} else if($session->get('forestresource_lang') == 2){
		include('config/language_en.php');
	}
?>