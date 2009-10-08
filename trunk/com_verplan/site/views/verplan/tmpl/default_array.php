<?php
/**
 * testtemplate mit anzeige als array
 * 
 * @version		$Id$
 * @package		verplan
 * @author		Dominik Moritz {@link http://www.dmoritz.bplaced.net}
 * @link		http://code.google.com/p/verplan/
 * @license		GNU/GPL
 * @author      Created on 07-Okt-2009
 */

//-- No direct access
defined('_JEXEC') or die('=;)');
?>

<?php
//holt das array
$arr = $this->verplanarray;

//array anzeigen
echo "<pre>";
print_r($arr);
echo "</pre>";
?>
