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
$document->addStylesheet('components/com_verplan/includes/css/ui.selectmenu.css');
$document->addStylesheet('http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/themes/ui-darkness/jquery-ui.css');

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
$document->addScript($this->baseurl.'/components/com_verplan/includes/js/ui.js');

//plugins
$document->addScript($this->baseurl.'/components/com_verplan/includes/js/plugins/jquery.tablesorter.min.js');
$document->addScript($this->baseurl.'/components/com_verplan/includes/js/plugins/jquery.columnfilters.js');
$document->addScript($this->baseurl.'/components/com_verplan/includes/js/plugins/jquery.colorize-2.0.0.js');
$document->addScript($this->baseurl.'/components/com_verplan/includes/js/plugins/jquery.kiketable.colsizable-1.1.js');
$document->addScript($this->baseurl.'/components/com_verplan/includes/js/plugins/jquery.event.drag-1.4.js');
$document->addScript($this->baseurl.'/components/com_verplan/includes/js/plugins/jquery.qtip-1.0.0-rc3.min.js');
$document->addScript($this->baseurl.'/components/com_verplan/includes/js/plugins/ui.selectmenu.js');
$document->addScript($this->baseurl.'/components/com_verplan/includes/js/plugins/themeswitchertool.js');

//$document->addScript('http://www.google.com/jsapi');
//$document->addScript($this->baseurl.'/components/com_verplan/includes/js/googletable.js');
//$document->addCustomTag( "<script type=\"text/javascript\">google.load('visualization', '1', {packages: ['table']});</script>" );
//$document->addScript($this->baseurl.'/components/com_verplan/includes/dataTables-1.5/media/js/jQuery.dataTables.js');
?>

<!-- -->
<form id="verplan_form" class="full_width ui-helper-clearfix" name="upload" method="get" enctype="multipart/form-data"	action="index.php">

	<div id="selectrahmen" class="ui-helper-clearfix ui-widget-header ui-corner-all">
		<span class="ui-state-default" style="border: none;">
		<label for="select_date"></label> 
		<select size="1" id="select_date" name="date">
			<?php
			$dates = $this->dates;
			foreach ($dates as $key => $value) {
				
				//timestamp des geltungsdatums
				$timestamp = strtotime($value);
				
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
		</span>
		
		<!-- Indikator alternativ für platzhalter: ui-widget-content-->
		<span id="load_platzhalter" class="ui-corner-all">
			<span id="loading">&nbsp;</span>
		</span>	

	
	</div>
	
	<div id="hidden" style="overflow:hidden;">
	<div id="options_div" class="ui-helper-clearfix ui-widget-content ui-corner-bl ui-corner-br">
		<!-- nur den neuesten stand --> 
		<span>Stand</span>
		<input type="text" name="stand" value="<?php print $this->stand;?>" />
		<span>Options [model,view]</span>
		<!-- view optionen nur für ajax interessant -->
		<input type="text" name="options" value="<?php echo $this->options;?>" />
		<!-- format wird nuir angezeigt, wenn  -->
		<noscript>
			<span>Format</span>
			<input type="text" name="format" value="<?php echo $this->format;?>" />
	    </noscript>
	    
		<!-- damit die Komponente wieder aufgerufen wird --> 
		<input type="hidden" name="option" value="com_verplan" /> 
		<input type="hidden" name="task" value="" />		
		<input type="hidden" name="Itemid" value="<?php echo JRequest::getVar('Itemid');?>" /> 
		<input type="hidden" name="controller" value="" /> 
		<!-- die user ID --> 
		<input	type="hidden" name="id" value="<?php echo $this->user->id; ?>" />
		
		<noscript>
			<!-- falls js nicht unterstürtz, ist es möglich, ohne ajax die seite zu benutzen  -->
			<input type="submit" name="submit" class="submitbutton ui-helper-clearfix" value="Anzeigen" />
		</noscript>
		
	</div>
	</div>

	<div id="expander_options" class="ui-state-default ui-corner-bl ui-corner-br">
				<span id="icon_options" class="ui-icon ui-icon-circle-plus" style="float: left; margin-right: 0.3em;"></span>
				Advanced
	</div>
	
</form>



<noscript class="full_width">

<div class="ui-widget">
	<div class="ui-state-error ui-corner-all" style="padding: 0pt 0.7em; margin-top: 2em;">
		<p>
		<span class="ui-icon ui-icon-alert" style="float: left; margin-right: 0.3em; margin-top: 0.3em;"></span>
			<?php echo $this->nojs;?> 
		</p>
	</div>
</div>
	
</noscript>



<div id="ajaxdiv" class=" ">
<div class="table_header ui-widget-header ui-corner-tl ui-corner-tr ui-helper-clearfix">
	<div class="left">Vertretungsplan</div>
	<div id="ui_themeswitcher"></div>
</div>
<table id="jquerytable" class="ui-widget full_width">
	<colgroup>
		<?php
	$array = $this->verplanArray;
	$anzahl = count($array[cols]);
	for ($i = 0; $i < $anzahl; $i++) {
		echo "<col/>";
	}
	?>
	</colgroup>
	<thead class="ui-widget-header">
		<tr class="ui-state-default">
		<?php
		foreach ($array[cols] as $colname => $subarray) {
			echo "<th>";
			echo '<span class="ui-icon ui-icon-carat-2-n-s" style="float:right"></span>';
			print empty($subarray[label])? $subarray[name]: $subarray[label];
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

<div class="table_footer ui-widget-header ui-corner-bl ui-corner-br ui-helper-clearfix">
	Dominik Moritz, 2009
</div>

</div>
