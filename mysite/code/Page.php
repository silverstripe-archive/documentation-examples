<?php

class Page extends SiteTree {
	
	private static $db = array(

	);

	private static $has_one = array(

	);

	private static $casting = array(
		'LastParagraph' => 'HTMLText'
	);

	public function getCMSFields() {
		$fields = parent::getCMSFields();
		$fields->addFieldToTab('Root.Main', 
			new GridField('Pages', 'All pages', SiteTree::get())
		); 

		return $fields;
	}
}

class Page_Controller extends ContentController {
	
	private static $allowed_actions = array(
		'rss',
		'players',
		'email',
		'iwantmyajax',
		'HelloForm'
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
		$form = new Form($this, 'players', new FieldList(), new FieldList());

		echo $form->forTemplate();
		die();

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

	public function TodaysDate() {
		return new SS_Datetime();
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
		$output = new ArrayList();

		if($conn->getStatusCode() == 200) {
			$msgs = $fetch->getValues($conn->getBody(), "results");
		

			if($msgs) {
				foreach($msgs as $msg) {
					$output->push(new ArrayData(array(
						'Description' => Convert::xml2raw($msg->channel_item_description)
					)));
				}
			}
		}

		return $output;
	}

	public function email() {
		$email = new MyEmail(Member::get()->first());
		$email->send();
	}

	public function UsersIpAddress() {
		return $this->request->getIP();
	}

	public function iwantmyajax() {
		if(Director::is_ajax()) {
			return $this->renderWith("myAjaxTemplate");
		} else {
			return $this->httpError(404);
		}
	}

	public function Dishes() {
		$dishes = array(
			'Steak and Chips',
			'Fish and Chips',
			'Chicken and Chips'
		);

		$output = new ArrayList();

		foreach($dishes as $dish) {
			$m1 = new Money();
			$m1->setAmount(9.65);
			$m1->setCurrency('USD');

			$output->push(new ArrayData(array(
				'Title' => $dish,
				'Price' => $m1
			)));
		}

		return $output;
	}

	public function HelloForm() {
		$fields = new FieldList(
			TextField::create('Name', 'Your Name')
		);

		$actions = new FieldList(
			FormAction::create("doSayHello")->setTitle("Say hello")
		);

		$form = new Form($this, 'HelloForm', $fields, $actions);
	
		$form->loadDataFrom($this->request->postVars());
	
		return $form;
	}
	
	public function doSayHello($data, Form $form) {
		$form->sessionMessage('Hello '. $data['Name'], 'success');

		return $this->redirectBack();
	}

	public function SearchForm() {
		$fields = new FieldList(
			HeaderField::create('Header', 'Step 1. Basics'),
			OptionsetField::create('Type', '', array(
				'foo' => 'Search Foo',
				'bar' => 'Search Bar',
				'baz' => 'Search Baz'
			)),

			CompositeField::create(
				HeaderField::create('Header2', 'Step 2. Advanced '),
				CheckboxSetField::create('Foo', 'Select Option', array(
					'qux' => 'Search Qux'
				)),

				CheckboxSetField::create('Category', 'Category', array(
					'Foo' => 'Foo',
					'Bar' => 'Bar'
				)),

				NumericField::create('Minimum', 'Minimum'),
				NumericField::create('Maximum', 'Maximum')
			)
		);
		
		$actions = new FieldList(
			FormAction::create('doSearchForm', 'Search')
		);
	
		$required = new RequiredFields(array(
			'Type'
		));

		$form = new Form($this, 'SearchForm', $fields, $actions, $required);

		$form->setFormMethod('GET');
		
		$form->addExtraClass('no-action-styles');
		$form->disableSecurityToken();
		$form->loadDataFrom($_REQUEST);
	
		return $form;
	}
}