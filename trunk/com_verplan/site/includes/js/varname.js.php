/**
 * @version		$Id$
 * @package		verplan
 * @author		Dominik Moritz {@link http://www.dmoritz.bplaced.net}
 * @link		http://code.google.com/p/verplan/
 * @license		GNU/GPL
 * @author      Created on 21-Nov-2009
 */

function getVarname(){
	var a = '<?php echo $_GET['var'];?>';
	a.trim();
	console.log('Varname: '+a);
	return a;
}