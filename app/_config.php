<?php

global $project;
$project = 'app';

require_once("conf/ConfigureFromEnv.php");

if(!Director::isDev()) {
	SS_Log::add_writer(
		new SS_LogEmailWriter(Email::getAdminEmail()), 
		SS_Log::NOTICE, 
		'<='
	);
}

if(isset($_REQUEST['flush'])) {
	SS_Cache::set_cache_lifetime('any', -1, 100);
}

if(Director::isDev()) {
	Email::set_mailer(new LocalMailer());
}