<?php
	
class TeamController extends Controller {
		
	private static $allowed_actions = array(
		'players',
		'index'
	);
	
	public function index(SS_HTTPRequest $request) {
		// ..
	}

	public function players(SS_HTTPRequest $request) {
		print_r($request->allParams());
	}

	public function Link($action = null) {
		return Controller::join_links('teams', $action);
	}
}
