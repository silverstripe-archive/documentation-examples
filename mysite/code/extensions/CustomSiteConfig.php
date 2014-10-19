<?php
	
class CustomSiteConfig extends DataExtension {
	
	private static $db = array(
		'FooterContent' => 'HTMLText'
	);

	public function updateCMSFields(FieldList $fields) {
		$fields->addFieldToTab("Root.Main", 
			new HTMLEditorField("FooterContent", "Footer Content")
		);
	}
}