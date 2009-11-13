<?php
/**
 * template inc einstellungen
 * 
 * @version		$Id$
 * @package		verplan
 * @author		Dominik Moritz {@link http://www.dmoritz.bplaced.net}
 * @link		http://code.google.com/p/verplan/
 * @license		GNU/GPL
 * @author      Created on 31-Oct-2009
 */
?>

<h3 id="settings_header" class="expander plus">Parameter<span id="ajax_indicator_1">loading...</span></h3>
<div id="admin_settings_div">

<dl id="system-message" class="ajaxresmess_1">
	<dt class="message">Message</dt>
	<dd class="message message fade">
	<ul>
		<li id="ajaxresponse_1"></li>
	</ul>
	</dd>
</dl>

<?php 
	//get settings
	$settings = $this->settings;
?>

<form name="settings_form" id="settings_form" method="post" enctype="multipart/form-data" action="index.php?option=com_verplan">
	
	<table class="admin_table adminlist">
		<thead>
			<tr>
				<th>Nummer</th>
				<th>Name</th>
				<th>Wert</th>
				<th>Default</th>
			</tr>
		</thead>
		<tbody>
		<?php 
		foreach ($settings as $key => $setting) {
			
			if ($setting[id] % 2 == 1) {
				$zebra = "row0";
			} else {
				$zebra = "row1";
			}
			?>
			<tr class="<?php echo $zebra ?>">
				<td style="width:20px"><?php echo $setting['id']; ?></td>
				<td style="width:300px"><label><?php echo $setting['de']; ?></label></td>				
				<td><input size="40" type="text" name="<?php echo $setting['name'] ?>" value="<?php echo $setting['value']; ?>" /></td>
				<td class="def_td"><?php echo $setting['default']; ?></td>
			</tr>
			<?php 
		}
		?>			
		</tbody>
	</table>
	<input type="submit" name="settings" class="settingsbutton" value="Speichern" />

	<!-- damit die Komponente wieder aufgerufen wird --> 
	<input type="hidden" name="option" value="com_verplan" /> 
	<!-- task laden (in verplanControllrsave_settings -->
	<input type="hidden" name="task" value="setSettings" /> 
	<input type="hidden" name="boxchecked" value="0" /> 
	<!-- richtiger Controller -->
	<input type="hidden" name="controller" value="settings" /> 
	<!-- die user ID (unnötig) -->
	<input type="hidden" name="id" value="<?php echo $this->user->id; ?>" />
</form>
	
</div>

