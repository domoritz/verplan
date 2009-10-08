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

//css
$document->addStylesheet('components/com_verplan/includes/css/general.css');

//no conflict mode für jQuery (http://docs.jquery.com/Using_jQuery_with_Other_Libraries)
$document->addCustomTag( '<script type="text/javascript">var jQuery = jQuery.noConflict();</script>' );

//scripts
$document->addScript($this->baseurl.'/components/com_verplan/includes/js/ajax.js');
?>

<!-- -->
<form
	name="upload" method="post" enctype="multipart/form-data"
	action="index.php?option=com_verplan">
	
	Geltungsdatum
	<br>
	<select size="1" id="date" name="date" class="select">
		<?php 
		$dates = $this->dates;
		foreach ($dates as $key => $value) {
			
			//morgiges datum autom auswählen
			$timestamp = strtotime($value[Geltungsdatum]);
			if ($timestamp = time()) {
				$selected = "selected";
			}
			
			echo '<option value="'.$value[Geltungsdatum].'" $selected="'.$selected.'">';	
			
			/*
			 * richtiges datumsformat
			 * %A - wochentag
			 * %d - tag
			 * %m - monat
			 * %Y - jahr, 4stellig
			 * %H - stunde
			 * %M - minute
			 */						
			setlocale(LC_TIME, "de_DE");		
			$format="<b>%A</b> %d.%m.%Y";
			$date = strftime($format,$timestamp);		
			echo $date;
			echo '</option>';
		}	
		?>
	</select>
	
	<!-- nur den neuesten stand --> 
	<input type="hidden" name="stand" value="newest" /> 
	
	<input type="submit" name="submit" class="submitbutton" value="Anzeigen" />

	<!-- anzeige ohne template (praktisch für ajax) --> 
	<!--<input type="hidden" name="tmpl" value="component" />-->

	<!-- damit die Komponente wieder aufgerufen wird --> 
	<input type="hidden" name="option" value="com_verplan" /> 
	<input type="hidden" name="task" value="" />
	<!-- direkte anzeige der JSON daten--> 
	<input type="hidden" name="format" value="js" /> 
	<input type="hidden" name="boxchecked" value="0" /> 
	<!-- richtiger Controller --> 
	<input type="hidden" name="controller" value="" /> 
	<!-- die user ID --> 
	<input	type="hidden" name="id" value="<?php echo $this->user->id; ?>" />
</form>

<table></table>
