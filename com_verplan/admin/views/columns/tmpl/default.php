<?php
/**
 * tempalte des admin backends
 * 
 * @version		$Id$
 * @package		verplan
 * @author		Dominik Moritz {@link http://www.dmoritz.bplaced.net}
 * @link		http://code.google.com/p/verplan/
 * @license		GNU/GPL
 * @author      Created on 31-Jan-2010
 */

//-- No direct access
defined('_JEXEC') or die('=;)');

$document =& JFactory::getDocument();

//jQuery support
$settings = $this->settings;
if ($settings['load_jquery_backend']['value'] == 'true') {
	$document->addScript('http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js');
}

//no conflict mode für jQuery (http://docs.jquery.com/Using_jQuery_with_Other_Libraries)
$document->addCustomTag( '<script type="text/javascript">jQuery.noConflict();</script>' );

if ($settings['load_jqueryui_backend']['value'] == 'true') {
	$document->addScript('http://ajax.googleapis.com/ajax/libs/jqueryui/1.7/jquery-ui.min.js');
	$document->addStylesheet('http://ajax.googleapis.com/ajax/libs/jqueryui/1.7/themes/ui-darkness/jquery-ui.css');
}


//stylesheets
$document->addStylesheet('components/com_verplan/includes/css/general.css');


?>

<h2>Spalten</h2>

<?php
//get settings
$columns = $this->columns;

$sort = $this->sort;

//soriere array nach ordering
$ordering = array();
$sortarr = array();
foreach ($columns as $key => $row) {
	$ordering[$key] = $row['ordering'];
	$sortarr[$key] = $row[$sort];
}
//sortiert
array_multisort($sortarr, SORT_ASC, $ordering, SORT_ASC, $columns);

//debug
//var_dump($columns);
?>

<form name="columns_form" id="columns_form" method="post" enctype="multipart/form-data" action="index.php?option=com_verplan">

	<input type="submit" name="columns" class="columnsbutton" value="Speichern" /> 
	<input type="reset" name="columns" class="columnsbutton" value="Reset" /><br><br>

	<table class="admin_table adminlist" id="columntable">
		<thead>
		<?php
		echo "<tr>";
		//reset heißt ersten eintrag
		foreach (reset($columns) as $heads => $value) {
			echo "<th>";
			echo '<a href="index.php?option=com_verplan&view=columns&debug='.JRequest::getVar('debug', false).'&sort='.$heads.'">'.$heads.'</a>';
			echo "</th>";
		}
		?>
		</thead>
		
		<tbody>
		
		<?php 
		
		$z = 0;
		
		foreach ($columns as $column => $subarray) {
			
			//zebramuster für tabelle
			if ($z % 2 == 1) {
				$zebra = "row0";
			} else {
				$zebra = "row1";
			}
			$z++;
			
			echo '<tr class="'.$zebra.'">';
			foreach ($subarray as $key => $value) {
				
				//der name des formularfeldes muss die id enthalten, damit die 
				//daten später richtig zugeordnet werden können
				//trennzeichen: #
				$name = $subarray[id].'#'.$key;
				
				echo "<td>";
				switch ($key) {
					case ($key == 'id'):
						echo $value;
						break;
					case 'published':
						echo "<select name=".$name.">";
						for ($i = 0; $i < 2; $i++) {
							echo "<option";
							echo ($i == $value ? " selected=\"selected\"" : "");
							echo ">$i</option>";
						}
						//echo "</select><span class=\"min_f_sort\">".$value."</span>";
						break;
					case ($key == 'label'):
						echo '<input name="'.$name.'" type="text" value="'.$value.'"></input>';
						break;
					case ($key == 'description'):
						echo '<textarea name="'.$name.'" type="text" cols="50" rows="2">'.$value.'</textarea>';
						break;
					case ($key == 'ordering'):
						echo '<input name="'.$name.'" type="text" value="'.$value.'"></input>';
						break;
					default:
						echo $value;
						break;
				}
				echo "</td>";
			}
			echo "</tr>";
		}
		
		?>
			
		</tbody>
	</table>
	<br>
	
	
<input type="submit" name="columns" class="columnsbutton" value="Speichern" /> 
<input type="reset" name="columns" class="columnsbutton" value="Reset" />

<!-- damit die Komponente wieder aufgerufen wird -->
<input type="hidden" name="option" value="com_verplan" />
<!-- task laden (in verplanControllrsave_settings -->
<input type="hidden" name="task" value="setColumns" />
<input type="hidden" name="boxchecked" value="0" />
<!-- richtiger Controller -->
<input type="hidden" name="controller" value="columns" />
<!-- wieder richtiges view -->
<input type="hidden" name="view" value="columns" />

<!-- debug -->
<input type="hidden" name="debug" value="<?php echo JRequest::getVar('debug', false)?>" />
	
</form>

<br><br>
<a href="index.php?option=com_verplan&controller=columns&task=reorder&debug=<?php echo JRequest::getVar('debug', false)?>" class="links_do">Sortierung neu aufbauen</a>