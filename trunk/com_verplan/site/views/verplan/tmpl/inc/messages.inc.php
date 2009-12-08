<?php
/**
 * @version		$Id$
 * @package		verplan
 * @author		Dominik Moritz {@link http://www.dmoritz.bplaced.net}
 * @link		http://code.google.com/p/verplan/
 * @license		GNU/GPL
 * @author      Created on 17-Nov-2009
 */

//-- No direct access
defined('_JEXEC') or die('=;)');

?>

<?php 
//falls js nicht unterstützt wird oder abgeschaltet ist, wird dies angezeigt
?>
<noscript class="panel">

	<div class="ui-widget">
		<div class="ui-state-error ui-corner-all" style="padding: 0pt 0.7em; margin-top: 2em; margin-bottom: 2em;">
			<p>
			<span class="ui-icon ui-icon-alert" style="float: left; margin-right: 0.3em; margin-top: 0.3em;"></span>
				<?php echo $this->nojs;?> 
			</p>
		</div>
	</div>
	
	<!-- falls js nicht unterstürtz, ist es möglich, ohne ajax die seite zu benutzen  -->
	
	<form id="verplan_form" method="get" enctype="multipart/form-data" action="#">
	
		<select size="1" id="select_nojs" name="date">
		<?php		
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
			setlocale(LC_TIME, "de_DE");		
			$format="%A %d.%m.%Y";
			$label= strftime($format,$date);		
			echo $label;
			
			echo "</option>";
			
			}
			?>
		</select>
		
		<!-- damit die Komponente wieder aufgerufen wird --> 
		<input type="hidden" name="option" value="com_verplan" /> 
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="Itemid" value="<?php echo JRequest::getVar('Itemid');?>" /> 
		<input type="hidden" name="controller" value="" /> 
		<!-- die user ID --> 
		<input	type="hidden" name="id" value="<?php echo $this->user->id; ?>" />
		
		<input type="submit" name="submit" id="submitbutton" value="Vertretungsplan anzeigen" />
		
	</form>

</noscript>