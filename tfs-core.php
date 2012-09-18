<?php
/*
 * Plugin Name: TFS Core (Text Filter Suite)
 * Plugin URI: http://dougal.gunters.org/plugins/text-filter-suite
 * Description: Adds advanced text filtering functions which can mangle text in amusing ways.
 * Author: Dougal Campbell
 * Author URI: http://dougal.gunters.org/
 * Version: 1.3
 * License: GPL2, GPL3
 *
 * Text Filters Suite
 *
 * This was originally released as a "hack", but this is an updated
 * version in "plugin" format. I have broken up the actual text 
 * filtering functions from the various implementations. I've also
 * added some PostMeta (AKA "custom fields") support, which provides
 * the ability to apply specific filters to post and/or comment text
 * on a per-post basis.
 *
 * Released under the GPL.
 *
 * BACKGROUND:
 *
 * This started when I added a pirate filter to my blog for Talk Like
 * a Pirate Day (talklikeapirate.com). My first version was easier
 * than I expected it to be (though it had flaws), which inspired me
 * to locate and convert some of Kalsey's MovableJive filters.
 * 
 * The earliest version had a flaw, in that it would filter text inside of
 * HTML tags, causing it to mangle links and such. I fixed this by borrowing
 * an idea from Simon Willison. Simon's use of a callback function to only
 * match text that was not part of a tag was good, but it included the '>'
 * and '<' brackets from surrounding tags, requiring you to hack them back
 * in at the end of your content filter.  
 * 
 * After an afternoon studying the pcre pattern syntax and wrestling regexps
 * with the help of the Regex Coach (http://weitz.de/regex-coach/) I came up
 * with an improved pattern, which doesn't require us to tack the '>' and
 * '<' back on manually. Cool, huh?
 *
 * NOTE:
 *   These filters are very CPU intensive. It's breaking up your HTML into
 *   smaller chunks, and filtering each of those chunks individually, using
 *   regular expressions, which themselves are CPU-greedy. If you use this
 *   heavily on a site with a lot of traffic, caching might be a good idea.
 */

// An idea from Simon Willison (http://simon.incutio.com/)
// This tries to make sure that we only filter text *between*
// any HTML tags, and not *within* them.
function filter_cdata_content($content, $filter='none') {
	if (function_exists($filter)) {
		$content = preg_replace_callback('/(?(?<=>)|\A)([^<>]+)(?(?=<)|\Z)/s', $filter, $content);
	}

	return $content;
}

// This function takes an array of ('/pattern/' => 'replacement') pairs
// and applies them all to $content.
function array_apply_regexp($patterns,$content) {
	// Extract the values:
	$keys = array_keys($patterns);
	$values = array_values($patterns);
	
	// Replace the words:
	$content = preg_replace($keys,$values,$content);

	return $content;
}

// Per-post filtering support. This is added as a filter hook
// on 'the_content', so it gets called during The Loop for
// each post displayed. We check for a post custom field
// named 'post_filter', and apply any filters named there.
function tfs_content_filter($content) {
	$filters = get_post_custom_values('post_filter');
	if (!is_feed() && is_array($filters)) {
		foreach ($filters as $filter) {
			$filter = trim($filter);
			if (function_exists($filter)) {
				$content = call_user_func($filter,$content);
			}
		}
	}
	
	return $content;
}

// The same as above, but for comments. Uses a post custom field
// named 'comment_filter', and hooks into the 'comment_text' filter.
function tfs_comment_filter($content) {
	$filters = get_post_custom_values('comment_filter');
	if (!is_feed() && is_array($filters)) {
		foreach ($filters as $filter) {
			$filter = trim($filter);
			if (function_exists($filter)) {
				$content = call_user_func($filter,$content);
			}
		}
	}
	
	return $content;
}

function tfs_init() {
	// Don't filter feeds, it causes headaches.
	if ( is_feed() ) {
		return;
	}

	// Add handlers for per-post filtering:
	add_filter('the_content','tfs_content_filter');
	add_filter('the_title','tfs_content_filter');
	add_filter('comment_text','tfs_comment_filter');

/*
	// Using REQUEST so that you could set the filter in
	// a cookie, for persistence, if you wanted.
	$filtname = $_REQUEST['filter'];

	if (function_exists($filtname)) {
		add_filter('category_description',$filtname);
		add_filter('comment_author',$filtname);
		add_filter('comment_text',$filtname);
		add_filter('single_post_title',$filtname);
		add_filter('the_title',$filtname);
		add_filter('the_content',$filtname);
		add_filter('the_excerpt',$filtname);
		add_filter('comment_excerpt',$filtname);
		add_filter('list_cats',$filtname);
	}
*/
}

// initialize
add_action('init','tfs_init');

