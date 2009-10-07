<?php
/**
 * @version		$Id$
 * @package		verplan
 * @author		Dominik Moritz {@link http://www.dmoritz.bplaced.net}
 * @link		http://code.google.com/p/verplan/
 * @license		GNU/GPL
 * @author      Created on 06-Sep-2009
 */

//-- No direct access
defined('_JEXEC') or die('=;)');

$document =& JFactory::getDocument();

//jQuery hinzufügen
$document->addScript('http://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js');
$document->addScript('http://ajax.googleapis.com/ajax/libs/jqueryui/1.7/jquery-ui.min.js');

//no conflict mode für jQuery (http://docs.jquery.com/Using_jQuery_with_Other_Libraries)
$document->addCustomTag( '<script type="text/javascript">var jQuery = jQuery.noConflict();</script>' );

//testscript
$document->addScript($this->baseurl.'/components/com_verplan/includes/js/jquerytest.js');
?>


<h1><?php echo $this->greeting_model; ?></h1>
<h1><?php echo $this->greeting_view; ?></h1>
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


<!-- bitte auf post lassen, da es sonst probleme mit doppelten "option" werten gibt-->
<form name="upload" method="post" enctype="multipart/form-data"	action="index.php?option=com_verplan">
	
	<input size="40" type="text" id="stand" name="stand" />
	<input size="40" type="text" id="date" name="date" />
	<input type="submit" name="submit" class="submitbutton" value="OK" />
	
	<!-- anzeige ohne template (praktisch für ajax) -->
	<!--<input type="hidden" name="tmpl" value="component" />-->

	<!-- damit die Komponente wieder aufgerufen wird --> 
	<input type="hidden" name="option" value="com_verplan" /> 
	<!-- task laden (in verplanControllrupload -->
	<input type="hidden" name="task" value="get" /> 
	<input type="hidden" name="boxchecked" value="0" /> 
	<!-- richtiger Controller --> 
	<input type="hidden" name="controller" value="data" /> 
	<!-- die user ID (unnötig) -->
	<input type="hidden" name="id" value="<?php echo $this->user->id; ?>" />

</form>
