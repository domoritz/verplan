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

?>

<?php 
$document =& JFactory::getDocument();

$baseurl = JURI::base().'components/com_verplan/';
$document->addStylesheet($baseurl.'includes/css/mobile.css');


//version number
$version = $this->version;

$dates = $this->dates;
$which = $this->which;			
?>


<div id="header_verplan">
	<img alt="logo vertretungsplan" style="width: 152" src="<?php echo $this->baseurl;?>/components/com_verplan/includes/images/logo_preview_32.png" id="logo_verplan"/>
	<p>
		Anzeige des Vertretungsplanes für mobile Geräte, wie Handys, Smartphones oder Subnotebooks. 
		<a href="<?php echo JURI::base(); ?>?option=com_verplan&mobile=false">Zur normalen Ansicht.</a><br>
		<a href="http://code.google.com/p/verplan/wiki/Benutzerhandbuch_Frontend" >Hilfe</a>
	</p>
	
	<br>
</div>


<div id="select_rahmen">
	<form id="select_form" method="get" enctype="multipart/form-data" action="">
	<label for="select_date">Datum wählen</label> 
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
	
	<input type="hidden" name="option" value="com_verplan" />
	<input type="hidden" name="view" value="mobile" />
	<?php //nur componente anzeigen?>
	<?php 
	if ($this->tmpl) {
		echo '<input type="hidden" name="tmpl" value="'.$this->tmpl.'">';
	}
	?>
	
	
	
	<input type="submit" value="Anzeigen">
	</form>	
</div>

<br>

<div id="verplan">
<table id="verplantable">
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
	<thead>
		<tr>
		<?php
		if (!empty($array['rows'])){
			foreach ($array['cols'] as $colname => $subarray) {
				echo '<th filter-type="ddl"';
				print !empty($subarray['description'])? ' title="'.$subarray['description'].'"': '';
				echo '>';
				
				echo '<span class="ui-icon ui-icon-carat-2-n-s" style="float:right"></span>';
				print empty($subarray['label'])? $subarray['name']: $subarray['label'];
				echo "</th>";
			}
		}
		?>
		</tr>
	</thead>
	<tbody>
	<?php
	if (!empty($array['rows'])){
		for ($i = 0; $i < count($array['rows']); $i++) {
			print(($i%2 == 0)? '<tr class="even">' : '<tr class="odd">');
			//echo "<tr>";
			foreach ($array['rows'][$i] as $value) {
				echo "<td>";
				echo $value;
				echo "</td>";
			}
			echo "</tr>";
		}
		
	}
	?>
	</tbody>
</table>

<?php 
	//falls der typ nicht db ist, wird heir ein link angezeigt oder ein text
	$last = count($array['infos'])-1;
?>
<div id="no_db" <?php print $array['infos'][$last]['type'] != 'db' ? 'style="display: block;"' : ''?>>
	<?php 
	//nur, wenn auch ein Datun gewählt wurde
	if (!empty($array['infos'])) {
		//falls no_db oder kein plan
		if ($array['infos'][$last]['type'] != 'db') {
			if ($array['infos'][$last]['type'] == 'none') {
				echo "<p>Hurra, es gibt keine Vertretungen!</p>(Stand: ".$array['infos'][0]['Stand'].')';
			} else {
				echo '<p><a href="'.$array['infos'][$last]['url'].'">zum Vertretungsplan</a></p>(Stand: '.$array['infos'][0]['Stand'].')';
			}
		}
	} else {
		echo 'Bitte ein Datum wählen und "Abschicken" klicken!';
	}
	
	?>
</div>
</div>
<br><br>
<span id="hpvd" class="right_float">Code by <a href="http://www.dmoritz.bplaced.net/" target="_blank">Dominik Moritz, 2010</a></span>

