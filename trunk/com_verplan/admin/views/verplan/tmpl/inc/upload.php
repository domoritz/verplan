<?php
/**
 * template inc plan hochladen
 * 
 * @version		$Id$
 * @package		verplan
 * @author		Dominik Moritz {@link http://www.dmoritz.bplaced.net}
 * @link		http://code.google.com/p/verplan/
 * @license		GNU/GPL
 * @author      Created on 31-Oct-2009
 */
?>

<h2>Upload</h2>

<dl id="system-message" class="ajaxresmess_0">
		<dt class="message">Message</dt>
		<dd class="message message fade">
		<ul>
			<li id="ajaxresponse_0"></li>
		</ul>
		</dd>
	</dl>

<!-- bitte auf post lassen, da es sonst probleme mit doppelten "option" werten gibt-->
<form id="form_verplan" name="upload" method="post" enctype="multipart/form-data"	action="index.php?option=com_verplan">
	
	<table class="admin_table">
		<tbody>
			<tr>
				<td class="key"><label for="file">Datei</label></td>
				<td colspan="2">
					<input size="40" type="file" id="file" name="file" class="inputbox" />
				</td>
			</tr>
			<tr>
				<th colspan="3"><br>Optional</th>
			</tr>
			<tr>
				<td class="key"><label for="date">Geltungsdatum</label></td>
				<td  colspan="2">
					<input size="40" type="text" id="datepicker_date" name="date" class="inputbox" />
				</td>
			</tr>
			<tr>
				<td class="key"><label for="stand">Stand</label></td>
				<td>
					<input size="40" type="text" id="datepicker_stand" name="stand" />
					<input size="40" type="text" id="datepicker_stand_time" name="stand_time" />
				</td>
				<!-- <td>
					<input size="40" type="stand_time" id="datepicker_stand_time" name="stand" class="inputbox" /><br>
				</td> -->
			</tr>
		</tbody>
	</table>
	
	<br>
	<input type="submit" name="upload" class="uploadbutton" value="Abschicken" id="send" />
	
	<h3 id="options_header" class="expander plus">Optionen</h3>
	<div id="admin_options_div">
		<table class="admin_table">
		<tbody>
			<!-- anzeige ohne template (praktisch für ajax) -->
			<!--<input type="hidden" name="tmpl" value="component" />-->
			
			<tr>
			<!-- soll das ergebnis ohne template angezeigt werden? (für ajax)-->
			<td><label for="ajax">ajax </label></td>
			<td><select id="select_ajax" name="ajax">
				<option>true</option>
				<option>false</option>
			</select></td>
			<!-- <input type="hidden" name="ajax" value="false" /> -->
			</tr>
			
			<tr>
			<!-- soll das ergebnis ohne template angezeigt werden? (für ajax)-->
			<td><label for="debug">debug </label></td>
			<td><select id="select_debug" name="debug">
				<option>false</option>
				<option>true</option>
			</select>
			</tr></td>
				
			<!-- sollen fehler in den regulaeren ausdrücken ignoriert werden? (empfohlen) --> 
			<input type="hidden" name="ignore" value="true" /> 
		
			<!-- damit die Komponente wieder aufgerufen wird --> 
			<input type="hidden" name="option" value="com_verplan" /> 
			<!-- task laden (in verplanControllrupload -->
			<input type="hidden" name="task" value="send" />
			<input type="hidden" name="boxchecked" value="0" />
			<!-- richtiger Controller --> 
			<input type="hidden" name="controller" value="send" /> 
			<!-- die user ID (unnötig) -->
			<input type="hidden" name="id" value="<?php echo $this->user->id; ?>" />
		</tbody>
		</table>
	</div>

</form>

