<?
/*
 * Plugin Name: TFS Acronymit
 * Version: 1.0
 * Plugin URI: http://dougal.gunters.org/blog/2004/08/30/text-filter-suite
 * Description: An acronym tagging filter. (Requires TFS Core)
 * Author: Dougal Campbell
 * Author URI: http://dougal.gunters.org/
 *
 * I'm including this mainly as an example of a more serious example
 * of filtering with TFS. But a better solution for handling acronyms
 * is probably Michel Valdrighi's "Tag, You're It" plugin:
 *
 *   http://zengun.org/weblog/archives/2004/05/tag-you-re-it
 *
 */


// This is Matt's function, with mods by Dougal
function acronymit($text) {
	$acronyms = array(
	'NDA' => 'Non-Disclosure Agreement',
	'ROTFLMAO' => 'Rolling on the floor, laughing my a** off',
	'ROTFL' => 'Rolling on the floor, laughing',
	'ROFL' => 'Rolling on the floor, laughing',
	'LOL' => 'Laughing out loud',
	'WYSIWYG' => 'What You See Is What You Get',
	'TCP/IP' => 'Transmission Control Protocol/Internet Protocol',
	'TCP' => 'Transmission Control Protocol',
	'XHTML' => 'eXtensible HyperText Markup Language',
	'AFAIK' => 'As Far As I Know',
	'IANAL' => 'I Am Not A Lawyer',
	'TLAPD' => 'Talk Like A Pirate Day',
	'IIRC' => 'If I Remember Correctly',
	'HDTV' => 'High Definition TeleVision',
	'LGPL' => 'GNU Lesser General Public License',
	'MSDN' => 'Microsoft Developer Network',
	'WCAG' => 'Web Content Accessibility Guidelines',
	'SOAP' => 'Simple Object Access Protocol',
	'OPML' => 'Outline Processor Markup Language',
	'MSIE' => 'Microsoft Internet Explorer',
	'FOAF' => 'Friend of a Friend vocabulary',
	'GFDL' => 'GNU Free Documentation License',
	'XSLT' => 'eXtensible Stylesheet Language Transformation',
	'HTML' => 'HyperText Markup Language',
	'IHOP' => 'International House of Pancakes',
	'IMAP' => 'Internet Message Access Protocol',
	'RAID' => 'Redundant Array of Independent Disks',
	'HPUG' => 'Houston Palm Users Group',
	'LAMP' => 'Linux, Apache, MySQL, PHP',
	'WAMP' => 'Microsoft, Apache, MySQL, PHP',
	'VNC' => 'Virtual Network Computing',
	'URL' => 'Uniform Resource Locator',
	'W3C' => 'World Wide Web Consortium',
	'MSN' => 'Microsoft Network',
	'USB' => 'Universal Serial Bus',
	'P2P' => 'Peer To Peer',
	'PBS' => 'Public Broadcasting System',
	'RSS' => 'Rich Site Summary',
	'SIG' => 'Special Interest Group',
	'RDF' => 'Resource Description Framework',
	'AOL' => 'American Online',
	'PHP' => 'PHP Hypertext Processor',
	'SSN' => 'Social Security Number',
	'JSP' => 'Java Server Pages',
	'DOM' => 'Document Object Model',
	'DTD' => 'Document Type Definition',
	'DVD' => 'Digital Video Disc',
	'DNS' => 'Domain Name System',
	'CSS' => 'Cascading Style Sheets',
	'CGI' => 'Common Gateway Interface',
	'CMS' => 'Content Management System',
	'FAQ' => 'Frequently Asked Questions',
	'FSF' => 'Free Software Foundation',
	'API' => 'Application Interface',
	'PDF' => 'Portable Document Format',
	'IIS' => 'Internet Infomation Server',
	'XML' => 'eXtensible Markup Language',
	'XSL' => 'eXtensible Stylesheet Language',
	'GPL' => 'GNU General Public License',
	'GNU' => "GNU's Not Unix",
	'KDE' => 'K Desktop Environment',
	'WTF' => 'What the F*',
	'OOP' => 'Object Oriented Programming',
	'JVM' => 'Java Virtual Machine',
	'JIT' => 'Just-In-Time',
	'RPC' => 'Remote Procedure Call',
	'IE' => 'Internet Explorer',
	'CD' => 'Compact Disk',
	'GB' => 'Gigabyte',
	'MB' => 'Megabyte',
	'KB' => 'Kilobyte',
	'DoS' => 'Denial of Service',
	'DDoS' => 'Distributed Denial of Service',
	'J2EE' => 'Java2 Enterprise Edition',
	'CPU' => 'Central Processing Unit',
	'Moz' => 'Mozilla',
	'IE6' => 'Internet Explorer 6',
	'IE5' => 'Internet Explorer 5',
	'IE4' => 'Internet Explorer 4',
	'IE3' => 'Internet Explorer 3',
	'NS4' => 'Netscape Navigator 4',
	'NN4' => 'Netscape Navigator 4',
	'SQL' => 'Structured Query Language',
	'JDBC' => 'Java DataBase Connectivity',
		);

	foreach ($acronyms as $acronym => $definition) {
		$newacronyms["%\b$acronym\b%"] = "<acronym title='$definition'><span class='caps'>$acronym</span></acronym>";
	}

	$text = array_apply_regexp($newacronyms,$text);

	return $text;
}

?>