<?php
/**
 * tempalte des admin backends
 * 
 * @version		$Id$
 * @package		verplan
 * @author		Dominik Moritz {@link http://www.dmoritz.bplaced.net}
 * @link		http://code.google.com/p/verplan/
 * @license		GNU/GPL
 * @author      Created on 14-Sep-2009
 */

//-- No direct access
defined('_JEXEC') or die('=;)');

$document =& JFactory::getDocument();

//get version
$version = $this->settings[version]['default'];
?>

<p>Komponente zum Einstellen des Vertretungsplanes auf die Website des
MCG (http://www.marie-curie-gymnasium-dallgow.de/).</p>
<ul>
	<li>Version: <?php echo $version?></li>
	<li>Lizenz: <a href="http://www.gnu.org/licenses/gpl-2.0.html">GNU/GPL</a></li>
	<li>Autor: <a href="http://www.dmoritz.bplaced.net">Dominik Moritz,
	2010</a></li>
	<li>Code: <a href="http://code.google.com/p/verplan/">http://code.google.com/p/verplan/</a></li>
</ul>
<p>Verwendete Bibliotheken/Programme/Grafiken</p>
<ul>
	<li><a href="http://jquery.com/">jQuery</a></li>
	<li><a href="http://plugins.jquery.com/">diverse jQuery Plugins</a></li>
	<li><a href="http://jacksleight.com/old/code">JS Extractor</a></li>
	<li><a href="http://www.oxygen-icons.org/">Icons aus dem Oxygen Package</a></li>
	<li><a href="http://www.preloaders.net">Ajax Indikatoren</a></li>
</ul>
<p>Systemvoraussetzungen</p>
<ul>
	<li>PHP >= 5.3.0</li>
</ul>
