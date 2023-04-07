<?php

	# get correct id for plugin
	$thisfile=basename(__FILE__, ".php");
	
	# add in this plugin's language file
	i18n_merge('seoGPT') || i18n_merge('seoGPT', 'en_US');
 
	# register plugin
	register_plugin(
		$thisfile, //Plugin id
		'seoGPT', 	//Plugin name
		'1.1', 		//Plugin version
		'Multicolor',  //Plugin author
		'http://www.paypal.me/multicol0r', //author website
		i18n_r('seoGPT/LANG_Description'), //Plugin description
		'pages', //page type - on which admin tab to display
		'seoGPT'  //main function (administration)
	);

	# add a link in the admin tab 'theme'
	add_action('pages-sidebar','createSideMenu',array($thisfile, i18n_r('seoGPT/LANG_Settings')));
 
	# functions
	function seoGPT() {

		global $SITEURL;
		global $GSADMIN;

		$dbfile = GSPLUGINPATH.'seoGPT/db/db.json';
		$dbfileJSON = json_decode(@file_get_contents($dbfile));
		$apiKey =  @$dbfileJSON->apiKey;

		echo '
		<h3 style="margin:0;padding:0">'. i18n_r('seoGPT/LANG_Title') .'</h3>
		<p style="margin:0;padding:0;">'. i18n_r('seoGPT/LANG_Plugin_based_on') .': <a href="https://openai.com/" target="_blank" style="text-decoration:none;">https://openai.com/</a></p>';

		if(isset($_GET['form'])){
			include(GSPLUGINPATH.'seoGPT/form.inc.php');
		}elseif(isset($_GET['formwindow'])){
			include(GSPLUGINPATH.'seoGPT/formWindow.inc.php');	
		}else{
			include(GSPLUGINPATH.'seoGPT/settings.inc.php');
		};

		echo '
		<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank" style="box-sizing:border-box; display:grid; width:100%; grid-template-columns:1fr auto; border-radius:5px; padding:10px; background:#fafafa; border:solid 1px #ddd; margin-top:20px;">
			<p style="margin:0;padding:0;">'. i18n_r('seoGPT/LANG_Paypal') .'</p>
			<input type="hidden" name="cmd" value="_s-xclick">
			<input type="hidden" name="hosted_button_id" value="KFZ9MCBUKB7GL">
			<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_SM.gif" name="submit" title="PayPal - The safer, easier way to pay online!" alt="Donate with PayPal button" border="0">
			<img alt="" src="https://www.paypal.com/en_PL/i/scr/pixel.gif" width="1" height="1" border="0" sjeufj9v4="">
		</form>';

		if(isset($_POST['SeoGPT'])){

			$db = file_get_contents($dbfile);

			$dTemperature = 0.9;
			$iMaxTokens = 4000;
			$top_p = 1;
			$frequency_penalty = 0.0;
			$presence_penalty = 0.0;
			$OPENAI_API_KEY = $apiKey;
			$sModel = "text-davinci-003";
			$prompt = @$_POST['question'];
			$ch = curl_init();
			if ($_SERVER['HTTP_HOST'] == 'localhost') {
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			}
			$headers  = [
				'Accept: application/json',
				'Content-Type: application/json',
				'Authorization: Bearer ' . $OPENAI_API_KEY . ''
			];

			$postData = [
				'model' => $sModel,
				'prompt' => str_replace('"', '', $prompt),
				'temperature' => $dTemperature,
				'max_tokens' => $iMaxTokens,
				'top_p' => $top_p,
				'frequency_penalty' => $frequency_penalty,
				'presence_penalty' => $presence_penalty,
				'stop' => '[" Human:", " AI:"]',
			];

			curl_setopt($ch, CURLOPT_URL, 'https://api.openai.com/v1/completions');
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));

			$result = curl_exec($ch);

			$decoded_json = json_decode($result, true);

			echo '
			<b style="margin:10px 0; font-size:1.2rem; margin-top:20px; display:block;">'. i18n_r('seoGPT/LANG_Bots_Answer') .':</b>
			<div class="returnbot" style="width:100%; background:#fafafa; border:solid 1px #ddd; padding:10px; box-sizing:border-box;">
				<p>'.($decoded_json['choices'][0]['text'] !== null ? $decoded_json['choices'][0]['text']  : 'error database').'</p>
			</div>';

		}

	}

	add_action('edit-extras','getOnCKE');

	function getOnCKE(){
		include(GSPLUGINPATH.'seoGPT/formEdit.inc.php');
	}
