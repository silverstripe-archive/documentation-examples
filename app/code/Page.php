<?php

class Page extends SiteTree {
	
	private static $db = array(

	);

	private static $has_one = array(

	);
}

class Page_Controller extends ContentController {
	
	private static $allowed_actions = array(
		'rss',
		'players',
		'email'
	);

	public function init() {
		parent::init();

		RSSFeed::linkToFeed($this->Link() . "rss", "10 Most Recently Updated Pages");
		RSSFeed::linkToFeed($this->Link() . "players", "Players");
	}

	public function rss() {
		$rss = new RSSFeed(
			$this->LatestUpdates(), 
			$this->Link(), 
			"10 Most Recently Updated Pages", 
			"Shows a list of the 10 most recently updated pages."
		);

		return $rss->outputToBrowser();
	}

	public function players() {
		$rss = new RSSFeed(
			Player::get(),
			$this->Link("players"),
			"Players"
		);

		$rss->setTemplate('PlayersRss');

		return $rss->outputToBrowser();
	}

	public function LatestUpdates() {
		return Page::get()->sort("LastEdited", "DESC")->limit(10);
	}

	public function getWellingtonWeather() {
		$url = "https://query.yahooapis.com/v1/public/yql";

		$fetch = new RestfulService(
			'https://query.yahooapis.com/v1/public/yql'
		);
		
		$fetch->setQueryString(array(
			'q' => 'select * from weather.forecast where woeid in (select woeid from geo.places(1) where text="Wellington, NZ")'
		));
		
		$conn = $fetch->request();
		$msgs = $fetch->getValues($conn->getBody(), "results");
		$output = new ArrayList();

		if($msgs) {
			foreach($msgs as $msg) {
				$output->push(new ArrayData(array(
					'Description' => Convert::xml2raw($msg->channel_item_description)
				)));
			}
		}

		return $output;
	}

	public function email() {
		$email = new MyEmail(Member::get()->first());
		$email->send();
	}
}