                              TEXT FILTER SUITE
             Advanced content filtering functions for WordPress
                   by Dougal Campbell <dougal@gunters.org>
                         http://dougal.gunters.org/


WHAT IS IT?
-----------

The Text Filter Suite ("TFS", hereafter) is a WordPress plugin which
adds some new text filtering functions. In a sense, the core TFS
functions could be considered a "meta filter", because they actually
provide a framework that let you construct new filters fairly easily.
They also provide an easy way to apply filters to post content and
comments on a per-post basis.


HUH? CAN YOU REPEAT THAT IN ENGLISH?
------------------------------------

Okay, let's try a real-world example. A common feature on many web
sites is the automatic handling of acronyms. You'll often see an
acronym such as "XTML" displayed in an alternate style, and when you
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


INSTALLATION
------------

Technically, all you need to do is copy the core "tfs-core.php" file
into your "wp-content/plugins" directory, then activate the "TFS Core"
plugin from the WordPress admin interface. But, more generally, you'll
probably want some of the other filter files, as well. The easiest
thing to do will be to just copy all of the ".php" files to your
plugins directory, and only activate the ones that interest you. But
you can omit any of the "tfs-whatever.php" files (other than tfs-core)
that don't interest you.


USING THE FILTERS
-----------------

Generally, you'll probably want to activate a filter just for specific
posts. You do this by adding special "post custom fields" in the
"Advanced Editing" form (you also get the Advanced Editing options when
you edit a draft, or previously published post). 

Custom fields are composed of two parts: the "key" and the "value". The
two special keys that activate TFS are "post_filter" and
"comment_filter". In either case, the value should be the short name of
the TFS filter you wish to apply, e.g. "pirate" or "fudd" (without the
quotation marks).

Setting the "post_filter" key will apply the filter to the main post
text. Setting the "comment_filter" key will apply the filter to the
text of all comments on the post.


TECHNICAL MUMBO-JUMBO
---------------------

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

Lastly, the core functions will look for a querystring variable named
"filter", and attempt to apply the named filter to the current page
view. For example, if you browse to "http://example.com/?filter=fudd",
all content will have the "fudd" filter applied to it, regardless of
whether any TFS-related post custom fields are set. 


OTHER NOTES
-----------

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


CREDITS
-------

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

