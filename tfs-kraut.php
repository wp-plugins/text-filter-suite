<?php
/*
 * Plugin Name: TFS Kraut
 * Version: 1.4
 * Plugin URI: http://dougal.gunters.org/blog/2004/08/30/text-filter-suite
 * Description: Ein Kraut Filter. (Really bad pseudo-German) (Requires TFS Core)
 * Author: Dougal Campbell
 * Author URI: http://dougal.gunters.org/
 */


// Borrowed fudd, jive, kraut, and chef from Kalsey's MovableJive filter
//   http://kalsey.com/blog/2003/02/movablejive/

// These filters (particularly 'kraut' and 'jive' might contain something
// that could offend you or your readers. Edit and/or use at your own risk.

function kraut($content) {
	return filter_cdata_content($content,'kraut_filter');
}

function kraut_filter($content) {
	$content = $content[1];

	$patterns = array(
	'%ing%' => 'ingkt',
	'% the %' => ' ze ',
	'%The %' => 'Ze ',
	'% with %' => ' mitt ',
	'%With %' => 'Mitt ',
	'% is%' => ' iss',
	'% Is%' => ' Iss',
	'%wr%' => 'w-r-r',
	'%Wr%' => 'W-r-r',
	'%R%' => 'R-r-r',
	'% r%' => ' r-r-r',
	'%Yes( |\.|!)%' => 'Jawohl$1',
	'%YES!%' => 'JAWOHL!',
	'% yes( |.|!)%' => ' ja$1',
	'%No( |!|\?) %' => 'Nein$1',
	'% no( |\.|!|\?)%' => ' nein$1',
	'% not%' => ' nicht',
	'%Not%' => 'Nicht',
	'%[Mm]r.%' => 'Herr',
	'%[Mm]rs.%' => 'Frau',
	'%Miss%' => 'Fraulein',
	'% of %' => ' uff ',
	'%Of %' => 'Uff ',
	'%my%' => 'mein',
	'%My%' => 'Mein',
	'% and %' => ' undt ',
	'%And %' => 'Undt ',
	'%and%' => 'ent',
	'%One %' => 'Ein ',
	'% one%' => ' ein',
	'%Is %' => 'Ist ',
	'% is %' => ' ist ',
	'%ow %' => 'ow ',
	'%w %' => 'w ',
	'% sc%' => ' shc',
	'%Sc%' => 'Shc',
	'% st%' => ' sht',
	'%St%' => 'Sht',
	'%sh%' => 'sch',
	'%Sh%' => 'Sch',
	'%ch%' => 'ch',
	'%Ch%' => 'Ch',
	'% c%' => ' k',
	'% C%' => ' K',
	'% for %' => ' fur ',
	'%Have%' => 'Haf',
	'%have%' => 'haf',
	'%j%' => 'ch',
	'%J%' => 'Ch',
	'%Qu%' => 'Qv',
	'%qu%' => 'qv',
	'%rd%' => 'rt',
	'%v%' => 'f',
	'%V%' => 'F',
	'% w%' => ' v',
	'%W%' => 'V',
	'%ward%' => 'verrt',
	'%wh%' => 'v',
	'%Wh%' => 'V',
	'% th%' => ' z',
	'%Th%' => 'Z',
	'%th%' => 'zz',
	'%[Cc]offee%' => 'Kafe',
	'%[Tt]hank[s]*%' => 'Danke',
	'%[Jj]ohn%' => 'Johann',
	'%[Ww]illiam%' => 'Wilhelm',
	'%[Bb]rad%' => 'Wilhelm',
	'%[Gg]ary%' => 'Gerhardt',
	'%[Jj]on%' => 'Hansel',
	'%[a-f]!%' => '$1 Naturlich!',
	'%[p-z]!%' => '$1 Seig Heil!'
	);

	$content = array_apply_regexp($patterns,$content);

	return $content;
}

