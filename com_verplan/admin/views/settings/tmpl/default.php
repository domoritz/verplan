<?php
/**
 * tempalte des admin backends
 * 
 * @version		$Id$
 * @package		verplan
 * @author		Dominik Moritz {@link http://www.dmoritz.bplaced.de}
 * @link		http://code.google.com/p/verplan/
 * @license		GNU/GPL
 * @author      CCreated on 31-Jan-2010
 */

//-- No direct access
defined('_JEXEC') or die('=;)');

$document =& JFactory::getDocument();

$baseurl = JURI::base().'components/com_verplan/';

//jQuery support
$settings = $this->settings;
if ($settings['load_jquery_backend']['value'] == 'true') {
	$document->addScript($baseurl.'includes/js/jquery-1.4.2.min.js');
}

//no conflict mode für jQuery (http://docs.jquery.com/Using_jQuery_with_Other_Libraries)
$document->addCustomTag( '<script type="text/javascript">jQuery.noConflict();</script>' );

//stylesheets
$document->addStylesheet('components/com_verplan/includes/css/general.css');


?>


<?php 

//JToolBarHelper::preferences( 'com_verplan' );

$sort = $this->sort;

//soriere array nach ordering
$ordering = array();
$sortarr = array();
foreach ($settings as $key => $row) {
	$ordering[$key] = $row['ordering'];
	$sortarr[$key] = $row[$sort];
}
//sortiert
array_multisort($sortarr, SORT_ASC, $ordering, SORT_ASC, $settings);

?>

<h2>Parameter/ Einstellungen</h2>

<?php 
	//var_dump($settings);
?>

<form name="settings_form" id="settings_form" method="post" enctype="multipart/form-data" action="index.php?option=com_verplan">
	
	<input type="submit" name="columns" class="columnsbutton" value="Speichern" /> 
	<input type="reset" name="columns" class="columnsbutton" value="Reset" /><br><br>

	<table class="admin_table adminlist">
		<thead>
			<tr>
				<th><a href="index.php?option=com_verplan&view=settings&debug=<?php echo JRequest::getVar('debug', false)?>&sort=id">Nummer</a></th>
				<th><a href="index.php?option=com_verplan&view=settings&debug=<?php echo JRequest::getVar('debug', false)?>&sort=name">Name</a></th>
				<th><a href="index.php?option=com_verplan&view=settings&debug=<?php echo JRequest::getVar('debug', false)?>&sort=value">Wert</a></th>
				<th><a href="index.php?option=com_verplan&view=settings&debug=<?php echo JRequest::getVar('debug', false)?>&sort=default">Default</a></th>
				<th><a href="index.php?option=com_verplan&view=settings&debug=<?php echo JRequest::getVar('debug', false)?>&sort=de">Beschreibung</a></th>
			</tr>
		</thead>
		<tbody>
		<?php 
		
		$z = 0;
		
		foreach ($settings as $key => $setting) {
			
			//zebramuster für tabelle
			if ($z % 2 == 1) {
				$zebra = "row0";
			} else {
				$zebra = "row1";
			}
			$z++;
			
			?>
			<tr class="<?php echo $zebra ?>">
				<td style="width: 20px"><?php echo $setting['id']; ?></td>	
				<td style="width: 90px"><?php echo $setting['name']; ?></td>	
				<?php 
				if ($setting['name'] == 'message' || $setting['name'] == 'head_text' ) {
					?>
					<td style="width: 130px"><textarea name="<?php echo $setting['name'] ?>" cols="40" rows="5"><?php echo $setting['value']; ?></textarea></td>
					
					<?php
				} else {
					?>		
					<td style="width: 130px"><input size="40" type="text" name="<?php echo $setting['name'] ?>" value="<?php echo $setting['value']; ?>" /></td>
					<?php 
				}?>
				<td style="width: 130px" class="def_td"><?php echo $setting['default']; ?></td>
				<td style="min-width: 300px;"><label><?php echo $setting['de']; ?></label></td>
			</tr>
			<?php 
		}
		?>			
		</tbody>
	</table>
	<input type="submit" name="settings" class="settingsbutton" value="Speichern" />
	<input type="reset" name="columns" class="columnsbutton" value="Reset" />

	<!-- damit die Komponente wieder aufgerufen wird --> 
	<input type="hidden" name="option" value="com_verplan" /> 
	<!-- task laden (in verplanControllrsave_settings -->
	<input type="hidden" name="task" value="setSettings" /> 
	<input type="hidden" name="boxchecked" value="0" /> 
	<!-- richtiger Controller -->
	<input type="hidden" name="controller" value="settings" /> 
	<!-- wieder richtiges view -->
	<input type="hidden" name="view" value="settings" />
	
	<!-- debug -->
	<input type="hidden" name="debug" value="<?php echo JRequest::getVar('debug', false)?>" />
</form>