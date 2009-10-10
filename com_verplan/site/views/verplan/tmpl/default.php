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

/*
 * css
 */
$document->addStylesheet('components/com_verplan/includes/css/general.css');


/*
 * scripts
 */

//jQuery hinzufügen
$document->addScript('http://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js');
$document->addScript('http://ajax.googleapis.com/ajax/libs/jqueryui/1.7/jquery-ui.min.js');

//no conflict mode für jQuery (http://docs.jquery.com/Using_jQuery_with_Other_Libraries)
$document->addCustomTag( '<script type="text/javascript">var jQuery = jQuery.noConflict();</script>' );

//eigene scripts
$document->addScript($this->baseurl.'/components/com_verplan/includes/js/ajax.js');
$document->addScript($this->baseurl.'/components/com_verplan/includes/js/jquery.table.js');

//plugins
$document->addScript($this->baseurl.'/components/com_verplan/includes/js/plugins/jquery.tablesorter.js');
$document->addScript($this->baseurl.'/components/com_verplan/includes/js/plugins/jquery.columnfilters.js');
$document->addScript($this->baseurl.'/components/com_verplan/includes/js/plugins/jquery.colorize-2.0.0.js');



//$document->addScript('http://www.google.com/jsapi');
//$document->addScript($this->baseurl.'/components/com_verplan/includes/js/googletable.js');
//$document->addCustomTag( "<script type=\"text/javascript\">google.load('visualization', '1', {packages: ['table']});</script>" );
//$document->addScript($this->baseurl.'/components/com_verplan/includes/dataTables-1.5/media/js/jQuery.dataTables.js');
?>

<!-- -->
<form id="verplan_form" name="upload" method="post" enctype="multipart/form-data"	action="">

	<div id="selectrahmen" class="corner-all">
	<label for="select_date"></label>  
	<select size="1" id="select_date" name="date">
		<?php 
		$dates = $this->dates;
		foreach ($dates as $key => $value) {
			
			//morgiges datum autom auswählen
			$timestamp = strtotime($value[Geltungsdatum]);
			if ($timestamp_now = time()) {
				$selected = "selected";
			}
			
			//datums value, die zeit ist egal
			$date_value = date( 'Y-m-d', $timestamp);
			
			echo '<option value="'.$date_value.'" $selected="'.$selected.'">';	
			
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
			$label= strftime($format,$timestamp);		
			echo $label;
			echo '</option>';
		}	
		?>
	</select>
	<div id="load_platzhalter">
	<div id="loading"></div>
	</div>
	</div>
	
	<!-- nur den neuesten stand --> 
	<input type="hidden" name="stand" value="latest" /> 
	<input type="hidden" name="options" value="" />
	
	<!-- <input type="submit" name="submit" class="submitbutton" value="Anzeigen" />-->

	<!-- damit die Komponente wieder aufgerufen wird --> 
	<input type="hidden" name="option" value="com_verplan" /> 
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="format" value="js" /> 
	<input type="hidden" name="boxchecked" value="0" /> 
	<input type="hidden" name="controller" value="" /> 
	<!-- die user ID --> 
	<input	type="hidden" name="id" value="<?php echo $this->user->id; ?>" />
</form>

<noscript>
	<div class="corner-all error">
	<?php echo $this->nojs;?>	
	</div>
</noscript>

<div id="ajaxdiv">
<table id="jquerytable" class="display">
	<colgroup>
	<?php
	$array = $this->verplanArray;
	$anzahl = count($array[cols]);
	for ($i = 0; $i < $anzahl; $i++) {
		echo "<col/>";
	}
	?>
	</colgroup>
	<thead>
		<tr>
		<?php
		for ($i = 0; $i < $anzahl; $i++) {
			echo "<th>";
			echo $array[cols][$i][name];
			echo "</th>";
		}
		?>
		</tr>
	</thead>
	<tbody>
		<tr>
		<?php
		for ($i = 0; $i < $anzahl; $i++) {
			echo "<td></td>";
		}
		?>
		</tr>
	</tbody>
</table>
</div>
