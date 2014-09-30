<?php

class LocalMailer extends Mailer {

	function sendHTML($to, $from, $subject, $htmlContent, $attachedFiles = false, $customheaders = false, $plainContent = false, $inlineImages = false) {
		$file = ASSETS_PATH . '/_mail_'. urlencode(sprintf("%s_%s", $subject, $to));

		file_put_contents($file, $htmlContent);
	}


	function sendPlain($to, $from, $subject, $htmlContent, $attachedFiles = false, $customheaders = false, $plainContent = false, $inlineImages = false) {
		$file = ASSETS_PATH . '/_mail_'. urlencode(sprintf("%s_%s", $subject, $to));

		file_put_contents($file, $htmlContent);
	}
}