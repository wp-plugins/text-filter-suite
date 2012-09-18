<?php
/*
 * Plugin Name: TFS Pirate
 * Version: 1.2
 * Plugin URI: http://dougal.gunters.org/blog/2004/08/30/text-filter-suite
 * Description: Pirate filter, me matey! Arrrr! (Requires TFS Core)
 * Author: Dougal Campbell
 * Author URI: http://dougal.gunters.org/
 *
 * History:
 * 1.0 Initial version
 * 1.1 Can't add_filter('all','pirate'), because it breaks stuff. Doh.
 */

// If you don't want this filter to automatically engage every year
// on September 19, set this to false:
$talk_like_a_pirate = true;

function pirate($content) {
	return filter_cdata_content($content,'pirate_filter');
}

function pirate_filter($content) {
	$content = $content[1];

	$patterns = array( 
			'%\bmy\b%' => 'me',
			'%\bboss\b%' => 'admiral',
			'%\bmanager\b%' => 'admiral',
			'%\b[Cc]aptain\b%' => "Cap'n",
			'%\bmyself\b%' => 'meself',
			'%\byour\b%' => 'yer',
			'%\byou\b%' => 'ye',
			'%\bfriend\b%' => 'matey',
			'%\bfriends\b%' => 'maties',
			'%\bco[-]?worker\b%' => 'shipmate',
			'%\bco[-]?workers\b%' => 'shipmates',
			'%\bearlier\b%' => 'afore',
			'%\bold\b%' => 'auld',
			'%\bthe\b%' => "th'",
			'%\bof\b%' =>  "o'",
			"%\bdon't\b%" => "dern't",
			'%\bdo not\b%' => "dern't",
			'%\bnever\b%' => "ne'er",
			'%\bever\b%' => "e'er",
			'%\bover\b%' => "o'er",
			'%\bYes\b%' => 'Aye',
			'%\bNo\b%' => 'Nay',
			"%\bdon't know\b%" => "dinna",
			"%\bhadn't\b%" => "ha'nae",
			"%\bdidn't\b%"=>  "di'nae",
			"%\bwasn't\b%" => "weren't",
			"%\bhaven't\b%" => "ha'nae",
			'%\bfor\b%' => 'fer',
			'%\bbetween\b%' => 'betwixt',
			'%\baround\b%' => "aroun'",
			'%\bto\b%' => "t'",
			"%\bit's\b%" => "'tis",
			'%\bwoman\b%' => 'wench',
			'%\blady\b%' => 'wench',
			'%\bwife\b%' => 'lady',
			'%\bgirl\b%' => 'lass',
			'%\bgirls\b%' => 'lassies',
			'%\bguy\b%' => 'lubber',
			'%\bman\b%' => 'lubber',
			'%\bfellow\b%' => 'lubber',
			'%\bdude\b%' => 'lubber',
			'%\bboy\b%' => 'lad',
			'%\bboys\b%' => 'laddies',
			'%\bchildren\b%' => 'little sandcrabs',
			'%\bkids\b%' => 'minnows',
			'%\bhim\b%' => 'that scurvey dog',
			'%\bher\b%' => 'that comely wench',
			'%\bhim\.\b%' => 'that drunken sailor',
			'%\bHe\b%' => 'The ornery cuss',
			'%\bShe\b%' => 'The winsome lass',
			"%\bhe's\b%" => 'he be',
			"%\bshe's\b%" => 'she be',
			'%\bwas\b%' => "were bein'",
			'%\bHey\b%' => 'Avast',
			'%\bher\.\b%' => 'that lovely lass',
			'%\bfood\b%' => 'chow',
			'%\broad\b%' => 'sea',
			'%\broads\b%' => 'seas',
			'%\bstreet\b%' => 'river',
			'%\bstreets\b%' => 'rivers',
			'%\bhighway\b%' => 'ocean',
			'%\bhighways\b%' => 'oceans',
			'%\bcar\b%' => 'boat',
			'%\bcars\b%' => 'boats',
			'%\btruck\b%' => 'schooner',
			'%\btrucks\b%' => 'schooners',
			'%\bSUV\b%' => 'ship',
			'%\bairplane\b%' => 'flying machine',
			'%\bjet\b%' => 'flying machine',
			'%\bmachine\b%' => 'contraption',
			'%\bdriving\b%' => 'sailing',
			'%\bdrive\b%' => 'sail',
			'/ing\b/' => "in'",
			'/ings\b/' => "in's",
			// These next two do cool random substitutions
			'/(\.\s)/e' => 'avast("$0",3)',
			'/([!\?]\s)/e' => 'avast("$0",2)', // Greater chance after exclamation
			);

	// Replace the words:
	$content = array_apply_regexp($patterns,$content);
	
	return $content;
}

// support function for pirate()
// this could probably be refactored to make it more generic, allowing
// different filters to pass their own patterns in.
function avast($stub = '',$chance = 5) {
	$shouts = array(
				", avast$stub",
				"$stub Ahoy!",
				", and a bottle of rum!",
				", by Blackbeard's sword$stub",
				", by Davy Jones' locker$stub",
				"$stub Walk the plank!",
				"$stub Aarrr!",
				"$stub Yaaarrrrr!",
				", pass the grog!",
				", and dinna spare the whip!",
				", with a chest full of booty$stub",
				", and a bucket o' chum$stub",
				", we'll keel-haul ye!",
				"$stub Shiver me timbers!",
				"$stub And hoist the mainsail!",
				"$stub And swab the deck!",
				", ye scurvey dog$stub",
				"$stub Fire the cannons!",
				", to be sure$stub",
				", I'll warrant ye$stub",
				);
				
	shuffle($shouts);
	
	return (((1 == rand(1,$chance))?array_shift($shouts):$stub) . ' ');
}

// Use the pirate filter on September 19.
if ($talk_like_a_pirate && '0919' == date('md') && !$_GET['filter']) {
	add_filter('the_content','pirate');
	add_filter('comment_text','pirate');
}

?>