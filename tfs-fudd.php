<?php
/*
 * Plugin Name: TFS Fudd
 * Version: 1.4
 * Plugin URI: http://dougal.gunters.org/blog/2004/08/30/text-filter-suite
 * Description: Elmer Fudd filter. (Requires TFS Core)
 * Author: Dougal Campbell
 * Author URI: http://dougal.gunters.org/
*/

// Borrowed fudd, jive, kraut, and chef from Kalsey's MovableJive filter
//   http://kalsey.com/blog/2003/02/movablejive/

// These filters (particularly 'kraut' and 'jive' might contain something
// that could offend you or your readers. Edit and/or use at your own risk.

function fudd($content) {
	return filter_cdata_content($content,'fudd_filter');
}

function fudd_filter($content) {
	$content = $content[1];

	$patterns = array(
			'%(r|l)%' => 'w',
			'%qu%' => 'qw',
			'%th(\s)%' => 'f$1',
			'%th%' => 'd',
			'%n\.%' => 'n, uh-hah-ha-ha.',
			'%(R|L)%' => 'W',
			'%(Qu|QW)%' => 'QW',
			'%TH(\s)%' => 'F$1',
			'%Th%' => 'D',
			'%N\.%' => 'N, uh-hah-hah-hah.'
			);

	$content = array_apply_regexp($patterns,$content);

	return $content;
}

