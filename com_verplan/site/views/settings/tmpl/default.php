<?php
/**
 * Template für die js datei, die die einstellungen enthält
 * 
 * @version		$Id$
 * @package		verplan
 * @author		Dominik Moritz {@link http://www.dmoritz.bplaced.de}
 * @link		http://code.google.com/p/verplan/
 * @license		GNU/GPL
 * @author      Created on 30-Jan-2010
 */

//-- No direct access
defined('_JEXEC') or die('=;)');
?>

<?php
//http header setzen, nicht notwendig, aber besser

/*header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-type: application/json');*/

// Get the document object.
$document =& JFactory::getDocument();
 
// Set the MIME type for JSON output.
$document->setMimeEncoding( 'application/javascript' );

?>

<?php 
//einstellungen
?>
var settings = <?php echo json_encode($this->settings); ?>;

<?php 
//rooturl der joomlainstallation
?>
var rooturl = "<?php echo JURI::root()?>";
