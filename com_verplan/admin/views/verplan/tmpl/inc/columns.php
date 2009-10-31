<?php
/**
 * @version		$Id$
 * @package		verplan
 * @author		Dominik Moritz {@link http://www.dmoritz.bplaced.net}
 * @link		http://code.google.com/p/verplan/
 * @license		GNU/GPL
 * @author      Created on 31-Oct-2009
 */
?>

<h3 id="columns_header" class="expander plus">Spalten</h3>
<div id="admin_columns_div">


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
?>


<table class="adminlist" id="columntable">
	<thead>
	<?php
	echo "<tr>";
	//reset heißt ersten eintrag
	foreach (reset($columns) as $heads => $value) {
		echo "<th>";
		echo $heads;
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

			foreach ($subarray as $heads => $value) {
				echo "<td>";

				switch ($heads) {
					case 'published':
						echo "<select name=".$heads.">";
						for ($i = 0; $i < 2; $i++) {
							echo "<option";
							echo ($i == $value ? " selected=\"selected\"" : "");
							echo ">$i</option>";
						}
						echo "</select>";
						break;
					case ($heads == 'label' || $heads == 'name' || $heads == 'type'):
						echo '<input name="'.$heads.'" type="text" value="'.$value.'"></input>';
						break;
					default:
						echo $value;
						break;
				}

				echo "</td>";
			}

			?>		
		
		<td><input type="submit" name="columns" class="columnsbutton"
			value="Speichern" /> <input type="reset" name="columns"
			class="columnsbutton" value="Reset" /></td>
		<input type="hidden" name="format" value="js" />

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


</div>
