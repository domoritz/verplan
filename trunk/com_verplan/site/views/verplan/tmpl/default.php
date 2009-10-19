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
$document->addStylesheet('components/com_verplan/includes/css/table.css');
$document->addStylesheet('components/com_verplan/includes/css/jquery.kiketable.colsizable.css');


/*
 * scripts
 */

//jQuery hinzufügen
//$document->addScript('http://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js');
//$document->addScript($this->baseurl.'/components/com_verplan/includes/js//jquery-1.3.2_patched.js');
$document->addScript($this->baseurl.'/components/com_verplan/includes/js//jquery-1.3.2.min.js');
$document->addScript('http://ajax.googleapis.com/ajax/libs/jqueryui/1.7/jquery-ui.min.js');

//no conflict mode für jQuery (http://docs.jquery.com/Using_jQuery_with_Other_Libraries)
$document->addCustomTag( '<script type="text/javascript">jQuery.noConflict();</script>' );

//eigene scripts
$document->addScript($this->baseurl.'/components/com_verplan/includes/js/ajax.js');
$document->addScript($this->baseurl.'/components/com_verplan/includes/js/jquery.table.js');
$document->addScript($this->baseurl.'/components/com_verplan/includes/js/hide_options.js');
$document->addScript($this->baseurl.'/components/com_verplan/includes/js/jquery.tooltips.js');

//plugins
$document->addScript($this->baseurl.'/components/com_verplan/includes/js/plugins/jquery.tablesorter.min.js');
$document->addScript($this->baseurl.'/components/com_verplan/includes/js/plugins/jquery.columnfilters.js');
$document->addScript($this->baseurl.'/components/com_verplan/includes/js/plugins/jquery.colorize-2.0.0.js');
$document->addScript($this->baseurl.'/components/com_verplan/includes/js/plugins/jquery.kiketable.colsizable-1.1.js');
$document->addScript($this->baseurl.'/components/com_verplan/includes/js/plugins/jquery.event.drag-1.4.js');
$document->addScript($this->baseurl.'/components/com_verplan/includes/js/plugins/jquery.qtip-1.0.0-rc3.min.js');


//$document->addScript('http://www.google.com/jsapi');
//$document->addScript($this->baseurl.'/components/com_verplan/includes/js/googletable.js');
//$document->addCustomTag( "<script type=\"text/javascript\">google.load('visualization', '1', {packages: ['table']});</script>" );
//$document->addScript($this->baseurl.'/components/com_verplan/includes/dataTables-1.5/media/js/jQuery.dataTables.js');
?>

<!-- -->
<form id="verplan_form" class="full_width" name="upload" method="get" enctype="multipart/form-data"	action="index.php">

	<div id="selectrahmen" class="corner-all borders">
	<label for="select_date"></label>  
	<select size="1" id="select_date" name="date">
		<?php
		$dates = $this->dates;
		foreach ($dates as $key => $value) {
			
			//timestamp des geltungsdatums
			$timestamp = strtotime($value[Geltungsdatum]);
			
			//datums value, die zeit ist egal
			$date_value = date( 'Y-m-d', $timestamp);
			
			$selected = false;
			
			/*
			 * falls nicht ein datum über dei url gewählt wurde, soll 
			 * das datum des folgetages angezeigt werden
			 */
			if ($this->date == 'none'){
				//morgiges datum autom auswählen
				$date_of_timestamp = mktime(0, 0, 0, date("m",$timestamp)  , date("d",$timestamp), date("Y",$timestamp));
				$now = time();
				$tomorrow  = mktime(0, 0, 0, date("m",$now)  , date("d",$now)+1, date("Y",$now));
				//wenn das geltungsdatum morgen ist
				$selected = ($tomorrow == $date_of_timestamp);
			} elseif ($date_value == $this->date){
				//falls das ausgewählte datum der url mit dem geltungsdatum übereinstimmt
				$selected = true;
			}
			
			echo '<option value="'.$date_value.'"';
			//php Ternary Operator
			print ($selected ? ' selected="selected" id="selected">' : '>');	
			
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
	
	<noscript>
		<!-- falls js nicht unterstürtz, ist es möglich, ohne ajax die seite zu benutzen -->
		<input type="submit" name="submit" class="submitbutton" value="Anzeigen" />
	</noscript>
	
	<!-- Indikator -->
	<div id="load_platzhalter">
		<div id="loading"></div>
	</div>
	
	</div>
	
	<!-- schwebendes loading div -->
	<div id="loading_schweben" class="corner-bottom">
	Loading...
	</div>	
	
	<h4 id="options_header" class="expander plus">Optionen</h4>
	<div id="options_div">
		<!-- nur den neuesten stand --> 
		<span>Stand</span>
		<input type="text" name="stand" value="<?php print $this->stand;?>" /><br>
		<span>Options [model,view]</span>
		<!-- view optionen nur für ajax interessant -->
		<input type="text" name="options" value="<?php echo $this->options;?>" /><br>
		<!-- format wird nuir angezeigt, wenn  -->
		<noscript>
			<span>Format</span>
			<input type="text" name="format" value="<?php echo $this->format;?>" /><br>
	    </noscript>
	    
		<!-- damit die Komponente wieder aufgerufen wird --> 
		<input type="hidden" name="option" value="com_verplan" /> 
		<input type="hidden" name="task" value="" />		
		<input type="hidden" name="Itemid" value="<?php echo JRequest::getVar('Itemid');?>" /> 
		<input type="hidden" name="controller" value="" /> 
		<!-- die user ID --> 
		<input	type="hidden" name="id" value="<?php echo $this->user->id; ?>" />
	</div>
</form>

<noscript class="full_width">
	<div class="corner-all error_message">
	<?php echo $this->nojs;?>	
	</div>
</noscript>

<div id="ajaxdiv" class="corner-all-small borders full_width">
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
			print empty($array[cols][$i][label])? $array[cols][$i][name]: $array[cols][$i][label];
			echo "</th>";
		}
		?>
		</tr>
	</thead>
	<tbody>
	<?php
	if (!empty($array[rows])){
		foreach ($array[rows] as $row) {
			echo "<tr>";
			foreach ($row as $value) {
				echo "<td>";
				echo $value;
				echo "</td>";
			}
			echo "</tr>";
		}
	} else {
		//leere zellen, da es sonst fehler mit den plugins geben könnte
		echo "<tr>";
		for ($i = 0; $i < $anzahl; $i++) {
			echo "<td></td>";
		}
		echo "</tr>";
	}
	?>
	</tbody>
</table>
</div>