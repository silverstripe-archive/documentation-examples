<?php

class MyEmail extends Email {
	
	protected $ss_template = "MyEmail";

	public function __construct($member) {
		$from = 'no-reply@mysite.com';
		$to = $member->Email;
		$subject = "Welcome to our site.";
		$link = Director::absoluteBaseUrl();
		
		parent::__construct($from, $to, $subject);

		$this->populateTemplate(new ArrayData(array(
			'Member' => $member->Email,
			'Link' => $link
		)));
	}
}