<?php
/**
 * template inc spalten
 * 
 * @version		$Id$
 * @package		verplan
 * @author		Dominik Moritz {@link http://www.dmoritz.bplaced.net}
 * @link		http://code.google.com/p/verplan/
 * @license		GNU/GPL
 * @author      Created on 31-Oct-2009
 */
?>

<a href="#columns_header" id="columns_header" class="expander plus">Spalten<span id="ajax_indicator_2">loading...</span></a>
<div id="admin_columns_div" class="verschwinder">


<dl id="system-message" class="ajaxresmess_2">
	<dt class="message">Message</dt>
	<dd class="message message fade">
	<ul>
		<li id="ajaxresponse_2"></li>
	</ul>
	</dd>
</dl>


<?php
//get settings
$columns = $this->columns;

$sort = $this->sort;

//soriere array am anfang nach ordering
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


<table class="adminlist" id="columntable">
	<thead>
	<?php
	echo "<tr>";
	//reset heißt ersten eintrag
	foreach (reset($columns) as $heads => $value) {
		echo "<th>";
		echo '<a href="index.php?option=com_verplan&sort='.$heads.'#columns_header">'.$heads.'</a>';
		echo "</th>";
	}
	echo "<th>Speichern</th></tr>";
	?>
	</thead>
	<tbody>
	<?php
	foreach ($columns as $id => $subarray) {
		echo "<tr>";
		$id = $subarray[id];
			
		?>
		<form name="columns" id="columnsform" method="get"
			enctype="multipart/form-data" action="index.php?option=com_verplan">
			<?php

			foreach ($subarray as $head => $value) {
				echo "<td>";

				switch ($head) {
					case ($head == 'id'):
						echo $value;
						break;
					case 'published':
						echo "<select name=".$head.">";
						for ($i = 0; $i < 2; $i++) {
							echo "<option";
							echo ($i == $value ? " selected=\"selected\"" : "");
							echo ">$i</option>";
						}
						//echo "</select><span class=\"min_f_sort\">".$value."</span>";
						break;
					case ($head == 'label' || $head == 'name'):
						echo '<input name="'.$head.'" type="text" value="'.$value.'"></input>';
						break;
					case ($head == 'description'):
						echo '<textarea name="'.$head.'" type="text" cols="50" rows="2">'.$value.'</textarea>';
						break;
					case ($head == 'ordering'):
						echo '<input name="'.$head.'" type="text" value="'.$value.'"></input>';
						break;
					default:
						echo $value;
						break;
				}

				echo "</td>";
			}

			?>		
		
		<td>
		<input type="submit" name="columns" class="columnsbutton" value="Speichern" /> 
		<input type="reset" name="columns" class="columnsbutton" value="Reset" /></td>

		<!-- damit die Komponente wieder aufgerufen wird -->
		<input type="hidden" name="option" value="com_verplan" />
		<!-- task laden (in verplanControllrsave_settings -->
		<input type="hidden" name="task" value="setColumn" />
		<input type="hidden" name="boxchecked" value="0" />
		<!-- richtiger Controller -->
		<input type="hidden" name="controller" value="columns" />
		<!-- id der spalte!!! -->
		<input type="hidden" name="id" value="<?php echo $id; ?>" />
		</form>

		<?php
			
		echo "</tr>";
	}
	?>
	<?php //var_dump($columns);?>
	</tbody>
</table>

<a href="#columns_header" id="save_all_cols" class="links_do">alle Speichern</a><br>
<a href="index.php?option=com_verplan&controller=columns&task=reorder#columns_header" class="links_do">Sortierung neu aufbauen</a>

</div>
