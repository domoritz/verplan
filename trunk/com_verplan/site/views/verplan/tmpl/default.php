<?php
/**
 * @version $Id$
 * @package    verplan
 * @subpackage _ECR_SUBPACKAGE_
 * @author     EasyJoomla {@link http://www.easy-joomla.org Easy-Joomla.org}
 * @author     Dominik Moritz {@link http://www.dmoritz.bplaced.net}
 * @author     Created on 06-Sep-2009
 */

//-- No direct access
defined('_JEXEC') or die('=;)');

$document =& JFactory::getDocument();

//jQuery hinzufügen
$document->addScript('http://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js');
$document->addScript('http://ajax.googleapis.com/ajax/libs/jqueryui/1.7/jquery-ui.min.js');
//testscript
$document->addScript($this->baseurl.'/components/com_verplan/includes/js/jquerytest.js');
?>


<h1><?php echo $this->greeting_model; ?></h1>
<h1><?php echo $this->greeting_view; ?></h1>

<?php
foreach ($this->array AS $data){
	echo $data;
}
?>
<br>
<br>

<p id="test"><?php 
$user =& JFactory::getUser();

if (!$user->guest) {
	echo 'You are logged in as:<br />';
	echo 'User name: ' . $user->username . '<br />';
	echo 'Real name: ' . $user->name . '<br />';
	echo 'User ID  : ' . $user->id . '<br />';
}

?></p>
