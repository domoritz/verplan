<?php
/**
 * templatedatei des frontends
 * 
 * @version		$Id$
 * @package		verplan
 * @author		Dominik Moritz {@link http://www.dmoritz.bplaced.net}
 * @link		http://code.google.com/p/verplan/
 * @license		GNU/GPL
 * @author      Created on 06-Sep-2009
 */

//-- No direct access
defined('_JEXEC') or die('=;)');

//fügt die gesamten scripts und stylesheets hinzu
require_once('inc/scripts.inc.php');

// page title
/*$document =& JFactory::getDocument();
$title = $document->getTitle();
$document->setTitle('Vertretungsplan @ '.$title);*/

?>

<div id="verplanwrapper" class="full_width">

<?php 
//version number
$version = $this->version;

$dates = $this->dates;
$which = $this->which;			
?>

<?php 
//mobile ansicht
if ($this->mobile == true) {
	//automatische weiterleitung
	echo '
	<script language ="JavaScript">
		window.location.replace("'.JURI::base().'?option=com_verplan&view=mobile&tmpl=component");
	</script>';
	}
?>


<div id="header_verplan" class="ui-helper-clearfix panel">
	<img alt="logo vertretungsplan" style="width: 152" src="<?php echo JURI::base();?>/components/com_verplan/includes/images/logo/logo_beta_32.png" id="logo_verplan"/>
	<a href="http://code.google.com/p/verplan/wiki/Benutzerhandbuch_Frontend" target="_blank" id="help_head"><img alt="Benutzerhandbuch" src="<?php echo JURI::base();?>/components/com_verplan/includes/images/help_contents_32.png"></a>
	<p>
		<?php echo $this->einltext?>
	</p>
	
	<br>
</div>

<?php 
//kein js
?>
<noscript class="panel">
	<div class="ui-widget">
		<div class="ui-state-error ui-corner-all" style="padding: 0pt 0.7em; margin-top: 2em; margin-bottom: 2em;">
			<p>
			<span class="ui-icon ui-icon-alert" style="float: left; margin-right: 0.3em; margin-top: 0.3em;"></span>
				<strong>Achtung:</strong><br>
				Du musst JavaScript aktivieren, um den Vrtretungsplan sehen zu können.<br>
				Falls du Javascript nicht aktivieren möchtest oder kannst, klicke bitte <a href="<?php echo JURI::base()?>?option=com_verplan&view=mobile">hier</a>
			</p>
		</div>
	</div>
</noscript>


<div class="panel ui-helper-clearfix">
<div id="select_rahmen" class="ui-helper-clearfix ui-widget-header ui-corner-all">
	<form id="select_form" method="get" enctype="multipart/form-data" action="#">
	<label for="select_date"></label> 
	
	<span class="ui-state-default" style="border: none;">
	<select size="1" id="select_date_verplan" name="date">
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
				"Monday"=>"Montag", "Tuesday"=>"Dienstag", "Wednesday"=>"Mittwoch", "Thursday"=>"Donnerstag", "Friday"=>"Freitag", "Saturday"=>"Samstag", "Sunday"=>"Sonntag",
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
		<table id="optionstable">
			<tbody>
				<tr>
					<td>
						<label for="filter_input" id="filter_label"><span class="ui-icon ui-icon-lightbulb"></span><span>Filter nach einer Spalte</span></label>
					</td>
					<td>
						<input id="filter_input" type="text" size="20" maxlength="20" value="" name="filter_input" /> 
						<select id="filter_this" style="width: 100px" name="filter_this">
						<?php // value="" ist wichtig, da sonst nach der spalte alle gesucht wird ?>
						<option value="">alle</option>
						<?php
						//auswahlmöglichkeiten zum sortieren aus den spalten
						$array = $this->verplanArray;
						foreach ($array['cols'] as $key => $subarray) {
							echo '<option value="';
							print empty($subarray['label'])? $subarray['name']: $subarray['label'];
							echo '">';
							print empty($subarray['label'])? $subarray['name']: $subarray['label'];
							echo '</option>';
						}
						?>
						</select>
					</td>
				</tr>
				<tr>
					<td>
						<label for="klasse" id="filter_label_klassen"><span class="ui-icon ui-icon-lightbulb"></span><span>Filter nach Klasse</span></label>
					</td>
					<td>
						<select id="klasse" style="width: 100px" name="klasse">
							<option value="">alle</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>
						<a href="<?php echo JURI::base() ?>?option=com_verplan&view=mobile&tmpl=component" id="link_mobile" ><span class="ui-icon ui-icon-lightbulb"></span><span>Zur mobilen Ansicht</span></a>
					</td>
					<td></td>
				</tr>
			</tbody>
		</table>	
		</form>
</div>
<!-- 
<img style="margin-top: 6px; margin-left: 10px;" src="<?php echo $baseurl; ?>/components/com_verplan/includes/images/ajax/ajax-loader-spin_32.gif" id ="load_new"></img>
 -->
 
<p id="expander_options" class="ui-state-default ui-corner-bottom">
	<span id="icon_options" class="ui-icon ui-icon-circle-plus" style="float: left; margin-right: 0.3em;"></span>
				erweiterte Funktionen
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
	
	$anzahl = count($array['cols']);
	for ($i = 0; $i < $anzahl; $i++) {
		echo "<col/>";
	}
	?>
	</colgroup>
	<thead class="ui-widget-header">
		<tr class="ui-state-default">
		<?php
		foreach ($array['cols'] as $colname => $subarray) {
			echo '<th filter-type="ddl"';
			print !empty($subarray['description'])? ' title="'.$subarray['description'].'"': '';
			echo '>';
			
			echo '<span class="ui-icon ui-icon-carat-2-n-s" style="float:right"></span>';
			print empty($subarray['label'])? $subarray['name']: $subarray['label'];
			echo "</th>";
		}
		?>
		</tr>
	</thead>
	<tbody>
	<?php
	//leere zellen, da es sonst fehler mit den plugins geben könnte
	/*echo "<tr>";
	for ($i = 0; $i < $anzahl; $i++) {
		echo "<td></td>";
	}
	echo "</tr>";*/
	?>
	</tbody>
</table>

<div id="no_db">

</div>

<?php //kleiner indikator ?>
<div id ="miniindi" style="display: block" class="miniloader"></div>

<div id="table_footer" class="ui-widget-header ui-corner-bottom ui-helper-clearfix">
	<span id="hpvvp" class="left_float"><a href="http://code.google.com/p/verplan/" target="_blank" id="link_project">Verplan Web Application | Version:  <?php echo $version;?></a></span>
	
	<a href="javascript:scroll(0,0)" id="up_btn" style="float: right; margin-left: 5px; margin-top: -2px;" class="ui-state-default ui-corner-all">
		<span class="ui-icon ui-icon-circle-arrow-n"></span>
	</a>
	<span id="hpvd" class="right_float">Code by <a href="http://www.dmoritz.bplaced.de/" target="_blank" id="link_homepage">Dominik Moritz, 2010</a></span>
</div>

</div>

<div id="syncFnHolder"></div>

</div>
