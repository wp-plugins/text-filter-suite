<?php
/*
Plugin Name: TFS Swedish Chef
Version: 1.3
Plugin URI: http://dougal.gunters.org/blog/2004/08/30/text-filter-suite
Description: E Svedish Chef Vilter, Bork Bork Bork! (Requires TFS Core)
Author: Dougal Campbell
Author URI: http://dougal.gunters.org/
*/

// Borrowed fudd, jive, kraut, and chef from Kalsey's MovableJive filter
//   http://kalsey.com/blog/2003/02/movablejive/

// These filters (particularly 'kraut' and 'jive' might contain something
// that could offend you or your readers. Edit and/or use at your own risk.

function chef($content) {
	return filter_cdata_content($content,'chef_filter');
}

function chef_filter($content) {
	$content = $content[1];

	$patterns = array(

    '%an%' => 'un',
    '%An%' => 'Un',

    '%au%' => 'oo',
    '%Au%' => 'Oo',
    '%(\w)ew%' => '$1oo',
    '%(\w)ow%' => '$1oo',
    '%(\W)o%' => '$1oo',
    '%(\W)O%' => '$1Oo',
    '%(\w)u%' => '$1oo',
    '%(\w)U%' => '$1Oo',

    '%a(\w)%' => 'e$1',
    '%A(\w)%' => 'E$1',
    '%en(\W)%' => 'ee$1',

    '%(\w)e(\W)%' => '$1e-a$2',
    '%(\W)e%' => '$1i',
    '%(\W)E%' => '$1I',

    '%(\w)f%' => '$1ff',

    '%(\w)ir%' => '$1ur',

    '%([a-m])i%' => '$1ee',
    '%([A-M])i%' => '$1EE',

    '%(\w)o%' => '$1u',
    '%the%' => 'zee',
    '%The%' => 'Zee',
    '%th(\W)%' => 't$1',
    '%(\w)tion%' => '$1shun',
    '%v%' => 'f',
    '%V%' => 'F',
    '%w%' => 'v',
    '%W%' => 'V',


    '%f{2,}%' => 'ff',
    '%o{2,}%' => 'oo',
    '%e{2,}%' => 'ee',

    '%([\.!\?])\s*(</[^>]+>)?\s*$%' => '$1 Bork Bork Bork!$2',

	);

	$content = array_apply_regexp($patterns,$content);

	return $content;
}

