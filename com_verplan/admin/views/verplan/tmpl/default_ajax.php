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
?>

<?php 
	//variable holen
	$msg = $this->msg;
?>

Ajax response: <?php echo $msg;?>

<?php 
/*anzeige ohne template (praktisch für ajax)
$mainframe =& JFactory::getApplication('site'); 
$mainframe->close();
//*/
?>