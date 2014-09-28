<?php

class FootballTeam extends DataObject {

	private static $db = array(
		'Title' => 'Text'
	);

	private static $has_many = array(
		'Players' => 'Player'
	);
}