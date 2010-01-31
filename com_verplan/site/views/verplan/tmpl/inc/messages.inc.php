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
				<strong>Achtung:</strong><br>
				Du musst JavaScript aktivieren, um den Vrtretungsplan sehen zu können.<br>
				Falls du Javascript nicht aktivieren möchtest oder kannst, klicke bitte <a href="<?php echo JURI::base()?>?option=com_verplan&view=mobile">hier</a>
			</p>
		</div>
	</div>

</noscript>