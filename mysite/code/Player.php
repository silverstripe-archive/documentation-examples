<?php

class Player extends DataObject {

	private static $db = array(
		'PlayerNumber' => 'Int',
		'FirstName' => 'Text',
		'LastName' => 'Text',
		'Birthday' => 'Date'
	);

	private static $has_one = array(
		'Team' => 'FootballTeam'
	);

	public function AbsoluteLink() {
		// players can be accessed at yoursite.com/players/2
		
		return Controller::join_links(
			Director::absoluteBaseUrl(),
			'players',
			$this->ID
		);
	}
}