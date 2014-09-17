=== Text Filter Suite ===
Contributors: dougal
Donate link: http://dougal.gunters.org/donate
Tags: content, comments, filters, fun, funny, humor, pirates, talklikeapirate, talk like a pirate, pirate day
Requires at least: 1.5
Tested up to: 4.0
Stable tag: 1.3

Advanced filtering functions for WordPress, including the Talk Like a
Pirate Day filters.

== Description ==

The Text Filter Suite ("TFS", hereafter) is a WordPress plugin which
adds some new text filtering functions. In a sense, the core TFS
functions could be considered a "meta filter", because they actually
provide a framework that let you construct new filters fairly easily.
They also provide an easy way to apply filters to post content and
comments on a per-post basis.


= Huh? Can you repeat that in English? = 

Okay, let's try a real-world example. A common feature on many web
sites is the automatic handling of acronyms. You'll often see an
acronym such as "XHTML" displayed in an alternate style, and when you
hover your mouse pointer over it, you get a tool-tip which displays the
definition ("eXtended HyperText Markup Language", in this case). You
don't want to have to type in the markup for this every time you post
something, and automation is what computers are for, right? So, there
are several plugins available to handle this sort of automated text
subsitution.

TFS comes with the "TFS Acronymit" plugin to perform this function.
It's based on Matt Mullenweg's original "Acronymit" function, but with
a couple of improvements. In Matt's original function, you had to keep
the acronym list sorted, longest-to-shortest, and it could get confused
by recursive acronyms like 'PHP' ("PHP Hyptertext Processor") or GNU
("GNU's Not Unix"). TFS Acronymit does not have those restrictions.

For those who think that expansion of technical acronyms is "teh sux0r"
(i.e. "boring"), TFS comes with a variety of more entertaining filters.
The current set includes "chef", "fudd", "jive", "kraut", "pirate", and
of course, the aforementioned "acronymit". As a word of caution, the
"jive" and "kraut" filters are not what you would call "politically
correct".


== Installation ==

Technically, all you need to do is copy the "text-filter-suite" folder
into your "wp-content/plugins" directory, then activate the "TFS Core"
plugin from the WordPress admin interface. But, more generally, you'll
probably want some of the other filter files, as well. The easiest
thing to do will be to just copy all of the ".php" files to your
plugins directory, and only activate the ones that interest you. But
you can omit any of the "tfs-whatever.php" files (other than tfs-core)
that don't interest you.


= Using the filters =

Generally, you'll probably want to activate a filter just for specific
posts. You do this by adding special "post custom fields" in the
"Write Post" form.

Custom fields are composed of two parts: the "key" and the "value". The
two special keys that activate TFS are "post_filter" and
"comment_filter". In either case, the value should be the short name of
the TFS filter you wish to apply, e.g. "pirate" or "fudd" (without the
quotation marks).

Setting the "post_filter" key will apply the filter to the main post
text. Setting the "comment_filter" key will apply the filter to the
text of all comments on the post.


= Technical mumbo-jumbo =

There are only two core TFS functions, plus two more to support the
per-post content and comment filtering based on post custom fields. The
main entry point is the "filter_cdata_content" function. A TFS filter
will call filter_cdata_content, passing the content and the name of a
second function. The magic of filter_cdata_content() is that it will
only mangle regular text, leaving HTML tags alone. It will
automatically call out to the named function, passing it each chunk of
non-HTML-tag text (AKA "CDATA", or "Character Data", in XML parlance)
in turn.

The other core function is "array_apply_regexp". This support function
isn't required for every filter, but it is at the core of the included
TFS filters, such as the "pirate" filter. It accepts an associative
array of regular expressions and replacements, and the content to be
filtered. Examine the source of the "chef" and "fudd" filters for some
simple examples.

The per-post support functions are "tfs_content_filter" and
"tfs_comment_filter". These functions are automatically applied to each
post and its contents. They look for the "content_filter" and
"comment_filter" post custom fields, and apply the appropriate filter
functions if they are found.

== Changelog ==
= 1.3 - 2012-09-18 =
* Fixed PHP opening shorttag in tfs-acroymit.php
* Eliminated PHP warnings in debug mode
* Removed all closing ?> php tags per WP standards
* Killed generic 'filter' $_REQUEST variable checking

= 1.2 - 2010-12-10 =
* Added this changelog to the readme
* Moved the is_feed() handling into the init, to avoid breaking in
  WordPress 3.1.
* Added notes about the filters being CPU intensive.

== Other notes ==

By default, if the "TFS Pirate" filter is active, it will automatically
apply itself to all content on Talk Like a Pirate Day (September 19).
If you do not want this filter to automatically activate, set the value
of the "$talk_like_a_pirate" variable at the top of the plugin source
to "false".

The "TFS Acronymit" filter is automatically applied to all posts
whenever it is active. You do not need to set special post custom
fields in order to use it. Just activate the plugin, and you're ready.
To modify which acronyms are defined, see the list at the beginning of
the plugin, and modify it as you like, following the format you see
there.

It is possible to use the TFS core without activating any additional
plugins. You can do this with any built-in PHP function accepts a
single string as a parameter and returns a string. For example, you
could set a post custom "content_filter" with the value "strrev", and
the contents of the post would be displayed backwards, or with a value
of "strtoupper" to convert the content to all uppercase text. 

You can only specify a single function in each post custom field.
However, you can chain multiple functions together by using the key
more than once. For instance, if you wanted all comments for a post to
display in uppercase Elmer Fudd text, you would set two post custom
fields:

  comment_filter = strtoupper
  comment_filter = fudd

HOWEVER, note that using PHP built-in functions in this way will bypass
the power of the filter_cdata_content() function, which means that it
can and will mangle your HTML tags, possibly rendering them useless.
For example, applying the strrev function to the string "<p>" will
transform it into ">p<", which will confuse your browser in new and
wonderful ways.

NOTE: These filters can be very CPU intensive. For one thing, they make
extensive use of regular expressions, which can be expensive on their own. 
And for another, they break your content into many small chunks, in order to
separate the filterable text from the HTML code, and the filters run
separately on each text chunk found.  This probably won't be a problem in
most cases.  But if you have long posts being filtered, and you get a lot of
traffic, it could start to add up.  A caching plugin (e.g., WP Super Cache,
or W3 Total Cache) would probably help in that case.

== The Future ==

I will one day release a version 2.0 of this plugin which will be completely
refactored. You can probably expect to see:
* Consolidate the code so that it is not a collection of separately-enabled
  mini-plugins.
* PHP5 OOP architecture to encapsulate everything.
* An actual admin interface to select which filters are enabled, which 
  bits of content you will allow to be filtered (post titles, post content, comments,
  blog title, widget titles, etc), whether to auto-activate the Pirate
  filter on Talk Like a Pirate Day, etc.

Eventually, there may also be a way to edit the string substitutions so that
you can tailor it to your tastes.

== Credits ==

I created TFS on my own, but I borrowed ideas from several sources. Here are
some links you might also want to check out:

    PhotoMatt's original Acronymit code:
      http://photomatt.net/scripts/acronymit

    Simon Willison and I traded some ideas when I started my original hack
    for Talk Like a Pirate Day, in 2003:
      http://simon.incutio.com/archive/2003/09/19/aaar

    I borrowed, modified, and mangled a ton of stuff from Adam Kalsey's
    "MovableJive" plugin for Movable Type. See tfs-jive, tfs-chef, tfs-fudd,
    and tfs-kraut.
      http://kalsey.com/2003/02/movablejive/

    If all you want to do is stuff like the acronym definitions (or similar
    "turn this shorthand into a tag" substitions), then Michel Valdrighi's
    "Tag, You're It" plugin is really a better solution:
      http://zengun.org/weblog/archives/2004/05/tag-you-re-it

    The original inspiration that led to TFS was my desire to apply a
    "pirate" filter on my blog for "Talk Like a Pirate Day", which is on
    September 19 of each year:
      http://talklikeapirate.com/

