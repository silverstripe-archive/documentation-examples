<?php

class PlayerCsvBulkLoader extends CsvBulkLoader {

	public $columnMap = array(
		'Number' => 'PlayerNumber',
		'Name' => '->importFirstAndLastName',
		'Geburtsdatum' => 'Birthday',
		'Gruppe' => 'Team.Title',
	);

	public $duplicateChecks = array(
		'SpielerNummer' => 'PlayerNumber'
	);

	public $relationCallbacks = array(
		'Team.Title' => array(
			'relationname' => 'Team',
			'callback' => 'getTeamByTitle'
		)
	);

	public static function importFirstAndLastName(&$obj, $val, $record) {
		$parts = explode(' ', $val);
		
		if(count($parts) != 2) return false;
			$obj->FirstName = $parts[0];
			$obj->LastName = $parts[1];
	}

	public static function getTeamByTitle(&$obj, $val, $record) {
		return FootballTeam::get()->filter(
			'Title', $val
		)->First();
	}
}