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

$baseurl = JURI::root(true).'/components/com_verplan/';

/*
 * css
 */
$document->addStylesheet($baseurl.'includes/css/general.css');
$document->addStylesheet($baseurl.'includes/css/table.css');
$document->addStylesheet($baseurl.'includes/css/jquery.kiketable.colsizable.css');
$document->addStylesheet($baseurl.'includes/css/ui.selectmenu.css');
$document->addStylesheet($baseurl.'includes/css/prettyPhoto.css');
$document->addStylesheet($baseurl.'includes/css/jquery.clearableTextField.css');
$document->addStylesheet('http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/themes/ui-darkness/jquery-ui.css');

/*
 * scripts
 */

//jQuery hinzufügen
if ($this->load_jquery == 'true') {
	$document->addScript('http://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.js');
	//$document->addScript('http://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js');
	//$document->addScript($baseurl.'includes/js//jquery-1.3.2_patched.js');
	
}
$document->addScript('http://ajax.googleapis.com/ajax/libs/jqueryui/1.7/jquery-ui.min.js');


//no conflict mode für jQuery (http://docs.jquery.com/Using_jQuery_with_Other_Libraries)
$document->addCustomTag( '<script type="text/javascript">jQuery.noConflict();</script>' );

//plugins
$document->addScript($baseurl.'includes/js/plugins/jquery.tablesorter.min.js');
//$document->addScript($baseurl.'includes/js/plugins/jquery.columnfilters.js');
$document->addScript($baseurl.'includes/js/plugins/jquery.uitablefilter.js');
$document->addScript($baseurl.'includes/js/plugins/jquery.colorize-2.0.0.js');
$document->addScript($baseurl.'includes/js/plugins/jquery.kiketable.colsizable-1.1.js');
$document->addScript($baseurl.'includes/js/plugins/jquery.event.drag-1.4.js');
$document->addScript($baseurl.'includes/js/plugins/jquery.qtip-1.0.0-rc3.js');
$document->addScript($baseurl.'includes/js/plugins/ui.selectmenu.js');
$document->addScript($baseurl.'includes/js/plugins/jquery.history.js');
$document->addScript($baseurl.'includes/js/plugins/themeswitchertool.js');
$document->addScript($baseurl.'includes/js/plugins/jquery.prettyPhoto.js');
$document->addScript($baseurl.'includes/js/plugins/jquery.clearableTextField.js');
$document->addScript($baseurl.'includes/js/plugins/jquery.cookie.js');

//$document->addScript('http://www.google.com/jsapi');
//$document->addScript($baseurl.'includes/js/googletable.js');
//$document->addCustomTag( "<script type=\"text/javascript\">google.load('visualization', '1', {packages: ['table']});</script>" );
//$document->addScript($baseurl.'includes/dataTables-1.5/media/js/jQuery.dataTables.js');


//eigene scripts
$document->addScript($baseurl.'includes/js/filters.js');
$document->addScript($baseurl.'includes/js/tableplugins.js');
$document->addScript($baseurl.'includes/js/hide_options.js');
$document->addScript($baseurl.'includes/js/boxes.js');

$document->addScript($baseurl.'includes/js/ajax.js.php?url='.JURI::root());
$document->addScript($baseurl.'includes/js/colname.js.php?col='.$this->classname);
$document->addScript($baseurl.'includes/js/varname.js.php?var='.$this->varname);
$document->addScript($baseurl.'includes/js/debug.js.php?debug='.$this->debugmode);

$document->addScript($baseurl.'includes/js/general.js');
$document->addScript($baseurl.'includes/js/ajaxjson.js'); //ajax nach gereral, da hash
$document->addScript($baseurl.'includes/js/ajaxeffects.js');
$document->addScript($baseurl.'includes/js/ui.js'); //ui muss nach general, da select in general gesetzt
$document->addScript($baseurl.'includes/js/tooltips.js');

?>

<div id="verplanwrapper" class="full_width">

<?php 
//version number
$settingsmodel = JModel::getInstance('Settings', 'VerplanModel');
$version = $settingsmodel->getSetting('version');

$dates = $this->dates;
$which = $this->which;			
?>


<div id="header_verplan" class="ui-helper-clearfix panel">
	<img alt="logo vertretungsplan" style="width: 152" src="<?php echo $this->baseurl;?>/components/com_verplan/includes/images/logo_preview_32.png" id="logo_verplan"/>
	<a href="http://code.google.com/p/verplan/wiki/Benutzerhandbuch_Frontend" target="_blank" id="help_head"><img alt="Hilfe" src="<?php echo $this->baseurl;?>/components/com_verplan/includes/images/help_contents_32.png"></a>
	<p>
	
		Dies ist eine Vorschauversion der neuen Vertretungsplankomponente. 
		Weitere Informationen: <a href="http://code.google.com/p/verplan/" title="Projektseite">http://code.google.com/p/verplan/</a>. 
		Bitte sende dein <a id="feedy" title="Feedbackbogen" rel="prettyPhoto[iframes]" 
		href="http://spreadsheets.google.com/viewform?formkey=dGdDanZxa2k4RHhKbHJaS1RxT0Q2eWc6MA&iframe=true&width=90%&height=100%">Feedback</a>!
	</p>
	
	<br>
</div>

<?php require_once('inc/messages.inc.php');?>

<div class="panel ui-helper-clearfix">
<div id="select_rahmen" class="ui-helper-clearfix ui-widget-header ui-corner-all">
	<form id="select_form" method="get" enctype="multipart/form-data" action="#">
	<label for="select_date"></label> 
	
	<span class="ui-state-default" style="border: none;">
	<select size="1" id="select_date" name="date">
		<?php	

		//setlocale überprüfen (debug)
		if(!setlocale(LC_TIME, 'de_DE')) echo "<!--setlocale () konnte nicht ausgeführt werden-->";
		
		for ($i = 0; $i < count($dates); $i++) {				
			
			//geltungsdatum
			$date = strtotime($dates[$i]);
			$date_date = date( 'Y-m-d', $date);
			
			//falls diese option gleich die gewählte ist
			$selected = $i == $which;			
			
			echo "<option value=\"$date_date\"";
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
			setlocale(LC_TIME, 'de_DE');		
			$format="%A %d.%m.%Y";
			$label = strftime($format,$date);

			
			// Übersetzungsarray Englisch->Deutsch
			$trans = array(
				"Monday"=>"Montag", "Tuesday"=>"Dienstag", "Wednesday"=>"Mittwoch", "Thursday"=>"Donnerstag", "Friday"=>"Freitag", "Saturday"=>"Sonnabend", "Sunday"=>"Sonntag",
				"Mon"=>"Mo", "Tue"=>"Di", "Wed"=>"Mi", "Thu"=>"Do", "Fri"=>"Fr", "Sat"=>"Sa", "Sun"=>"So",
				"January"=>"Januar", "February"=>"Februar", "March"=>"März", "April"=>"April", "May"=>"Mai", "June"=>"Juni", "July"=>"Juli", "August"=>"August", "September"=>"September", "October"=>"Oktober", "November"=>"November", "December"=>"Dezember",
				"Jan"=>"Jan", "Feb"=>"Feb", "Mar"=>"März", "Apr"=>"Apr", "May"=>"Mai", "Jun"=>"Jun", "Jul"=>"Jul", "Aug"=>"Aug", "Sep"=>"Sep", "Oct"=>"Okt", "Nov"=>"Nov", "Dec"=>"Dez"
			);
			//ersetzt die englischen bezeichnungen durch Deutsche, wenn es nötig ist (falls sprache nicht installiert)
			$label = strtr($label,$trans);
			
			echo $label;
			
			echo "</option>";
			
		}
		?>
	</select>
	</span>
	
	<!-- Indikator alternativ für platzhalter: ui-widget-content-->
	<div id="loading">&nbsp;</div>
	<div id="platzhalter" class="ui-corner-all">
	</div>
	<div id="notify" class="ui-corner-all">
		<span id="text">loading...</span>
	</div>
	
	
	</form>
		
</div>


<div id="options_panel" class="ui-helper-clearfix ui-widget-content ui-corner-bottom">
	<form id="verplan_form" method="get" enctype="multipart/form-data" action="#">
		<!-- nur den neuesten stand --> 
		<label for="input_stand" id="stand_label">Stand<span class="ui-icon ui-icon-lightbulb"></span></label>
		<input id="input_stand" type="text" name="stand" value="<?php print $this->stand;?>" />
		
		<label for="input_options" id="options_label">Options [model,view]<span class="ui-icon ui-icon-lightbulb"></span></label>
		<!-- view optionen nur für ajax interessant -->
		<input id="input_options" type="text" name="options" value="<?php echo $this->options;?>" />
		<!-- format wird nuir angezeigt, wenn  -->		    
		
		<label for="filter_input" id="filter_label">Filter nach einer Spalte<span class="ui-icon ui-icon-lightbulb"></span></label>
		<input id="filter_input" type="text" size="20" maxlength="20" value="" name="filter_input"/>
		<select id="filter_this" style="width: 100px" name="filter_this">
			<!-- value="" ist wichtig, da sonst nach der spalte alle gesucht wird -->
			<option value="">alle</option>
		<?php 
		//auswahlmöglichkeiten zum sortieren aus den spalten
		$array = $this->verplanArray;
		foreach ($array[cols] as $key => $subarray) {
			echo '<option value="';
			print empty($subarray[label])? $subarray[name]: $subarray[label];
			echo '">';
			print empty($subarray[label])? $subarray[name]: $subarray[label];			
			echo '</option>';
		}
		?>
		</select>
		
		<label for="klasse" id="filter_label_klassen">Filter nach Klasse<span class="ui-icon ui-icon-lightbulb"></span></label>
		<select id="klasse" style="width: 100px" name="klasse">
			<option value="">alle</option>
		</select>
	
	</form>
</div>
<!-- 
<img style="margin-top: 6px; margin-left: 10px;" src="<?php echo $baseurl; ?>/components/com_verplan/includes/images/ajax/ajax-loader-spin_32.gif" id ="load_new"></img>
 -->
 
<p id="expander_options" class="ui-state-default ui-corner-bottom">
	<span id="icon_options" class="ui-icon ui-icon-circle-plus" style="float: left; margin-right: 0.3em;"></span>
				erweiterte Optionen
</p>
</div>


<div id="loader_overlay"><span>Laden...</span></div>



<div id="ajaxdiv" class="ui-helper-clearfix">
<div id ="table_header" class="ui-widget-header ui-corner-top ui-helper-clearfix">
	<div id="table_header_text" class="left_float">Vertretungsplan</div>
	<div id="ui_themeswitcher"></div>
</div>

<table id="jquerytable" class="ui-widget full_width">
	<colgroup>
	<?php
	$array = $this->verplanArray;
	
	/*debug
	var_dump($array);
	//*/
	
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
			echo '<th filter-type="ddl"';
			print !empty($subarray[description])? ' title="'.$subarray[description].'"': '';
			echo '>';
			
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

<?php 
	//falls der typ nicht db ist, wird heir ein link angezeigt oder ein text
	$last = count($array[infos])-1;
?>
<div id="no_db" <?php print $array[infos][$last][type] != 'db' ? 'style="display: block;"' : ''?>>
	<?php 
	//nur, wenn auch ein Datun gewählt wurde
	if (is_array($array[infos])) {
		//falls no_db oder kein plan
		if ($array[infos][$last][type] != 'db') {
			if ($array[infos][$last][type] == 'none') {
				echo "Hurra, es gibt keine Vertretungen!<br>Stand: ".$array[infos][0][Stand];
			} else {
				echo '<a href="'.$array[infos][$last][url].'">zum Vertretungsplan</a><br>Stand: '.$array[infos][0][Stand];
			}
		}
	} else {
		echo "Bitte warten oder ein Datum wählen!";
	}
	
	?>
</div>

<div id="table_footer" class="ui-widget-header ui-corner-bottom ui-helper-clearfix">
	<span id="hpvvp" class="left_float"><a href="http://code.google.com/p/verplan/" target="_blank">Verplan Web Application | Version:  <?php echo $version;?></a></span>
	
	<a href="javascript:scroll(0,0)" id="up_btn" style="float: right; margin-left: 5px; margin-top: -2px;" class="ui-state-default ui-corner-all">
		<span class="ui-icon ui-icon-circle-arrow-n"></span>
	</a>
	<span id="hpvd" class="right_float">Code by <a href="http://www.dmoritz.bplaced.net/" target="_blank">Dominik Moritz, 2009</a></span>
</div>

</div>

<div id="syncFnHolder"></div>

</div>
