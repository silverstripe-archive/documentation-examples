<?php

global $project;
$project = 'mysite';

require_once("conf/ConfigureFromEnv.php");

if(!Director::isDev()) {
	SS_Log::add_writer(
		new SS_LogEmailWriter(Email::getAdminEmail()), 
		SS_Log::NOTICE, 
		'<='
	);
}

if(Director::isDev()) {
	Email::set_mailer(new LocalMailer());
}