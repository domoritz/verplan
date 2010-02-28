<?php
/**
 * tempalte des admin backends
 * 
 * @version		$Id$
 * @package		verplan
 * @author		Dominik Moritz {@link http://www.dmoritz.bplaced.de}
 * @link		http://code.google.com/p/verplan/
 * @license		GNU/GPL
 * @author      Created on 14-Sep-2009
 */

//-- No direct access
defined('_JEXEC') or die('=;)');

$document =& JFactory::getDocument();

$baseurl = JURI::base().'components/com_verplan/';

//get version
$version = $this->settings[version]['default'];
?>

<p>Joomla Komponente zum Einstellen des Vertretungsplanes.</p>
<ul>
	<li>Version: <?php echo $version?></li>
	<li>Lizenz: <a href="http://www.gnu.org/licenses/gpl-2.0.html">GNU/GPL</a></li>
	<li>Autor: <a href="http://www.dmoritz.bplaced.de">Dominik Moritz,2010</a></li>
	<li>Code: <a href="http://code.google.com/p/verplan/">http://code.google.com/p/verplan/</a></li>
</ul>

<br>
<a href="http://code.google.com/p/verplan/wiki/About">Mehr auf der Projektseite</a>
<br>
