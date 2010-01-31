<?php
/**
 * hauptmodel des frontends
 * 
 * @version		$Id$
 * @package		verplan
 * @author		Dominik Moritz {@link http://www.dmoritz.bplaced.net}
 * @link		http://code.google.com/p/verplan/
 * @license		GNU/GPL
 * @author      Created on 6-Sep-2009
 */


//-- No direct access
defined('_JEXEC') or die('=;)');

jimport( 'joomla.application.component.model' );

/**
 * verplan Model
 *
 * @package    verplan
 * @subpackage Models
 */
class verplanModelverplan extends JModel
{

	function getNojs()
	{
		$nojs = '
			<p><strong>Achtung:</strong><br>
			Bitte aktiviere JavaScript um den vollen Funktionsumfang nutzen zu können! 
			Ohne Javascript kannst du die meisten Funktionen des Programms nicht benutzen!
			</p>
		';
		
		return $nojs;
	}// function
	
	/**
	 * header text, wird nicht verwendet (sondern setting)
	 * @return unknown_type
	 */
	function getText()
	{
		$einltext = '
			Dies ist eine Vorschauversion der neuen Vertretungsplankomponente. 
			Weitere Informationen: <a href="http://verplan.googlecode.com" target="_blank" id="link_project" title="Projektseite">verplan.googlecode.com</a>. 
			Bitte sende dein <a id="feedy" title="Feedbackbogen" rel="prettyPhoto[iframes]" 
			href="http://spreadsheets.google.com/viewform?formkey=dGdDanZxa2k4RHhKbHJaS1RxT0Q2eWc6MA&iframe=true&width=90%&height=100%">Feedback</a>!
		';
		
		return $einltext;
	}// function
}// class