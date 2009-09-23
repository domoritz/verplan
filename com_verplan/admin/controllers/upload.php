<?php
/**
 *
 * @version $Id$
 * @package    verplan
 * @subpackage _ECR_SUBPACKAGE_
 * @author     EasyJoomla {@link http://www.easy-joomla.org Easy-Joomla.org}
 * @author     Dominik Moritz {@link http://www.dmoritz.bplaced.net}
 * @author     Created on 15-Sep-2009
 *
 *
 * Hello Controller for Hello World Component
 *
 * @package    Joomla.Tutorials
 * @subpackage Components
 * @link http://docs.joomla.org/Developing_a_Model-View-Controller_Component_-_Part_4
 * @license		GNU/GPL
 */

// No direct access
//defined( '_JEXEC' ) or die( 'Restricted access' );

/**
 * verplan Upload Controller
 *
 */
class verplanControllerUpload extends verplanController
{
	/**
	 * constructor (registers additional tasks to methods)
	 * @return void
	 */
	function __construct()
	{
		parent::__construct();

		// Register Extra tasks
		$this->registerTask('upload','upload');
		$this->registerTask('parse_file_to_array','parse_file_to_array');
	}

	/**
	 * lädt den Vertreutungsplan hoch
	 * @return void
	 */
	function upload() {
		//Retrieve file details from uploaded file, sent from upload form
		$file = JRequest::getVar('file', null, 'files', 'array');

		//lade Settings
		$model =& $this->getModel();
		$settings = $model->getSettings();
		
		//falls fehler ignoriert werden sollen
		$ignore = JRequest::getVar('ignore',false);

		//get filetype information
		$allowed_filetypes_string = $settings['allowed_filetypes'];
		$allowed_filetypes = explode(",",$allowed_filetypes_string);

		//Import filesystem libraries. Perhaps not necessary, but does not hurt
		jimport('joomla.filesystem.file');

		//Clean up filename to get rid of strange characters like spaces etc
		$filename = JFile::makeSafe($file['name']);

		//get filesize
		$filesize = $file['size'];

		//Set up the source and destination of the file
		$src = $file['tmp_name'];
		$dest = JPATH_COMPONENT . DS . "uploads" . DS . $filename;

		//First check if the file has the right extension, we need jpg only
		if ( in_array(strtolower(JFile::getExt($filename)),$allowed_filetypes) OR false) {
			if ($filesize <= $settings['max_file_size']) {
				if (JFile::upload($src, $dest) ) {
					//Redirect to a page of your choice
					if (strtolower(JFile::getExt($filename)) == "htm" || strtolower(JFile::getExt($filename)) == "html"){
						$this->parse_file_to_array($dest);
						//$this->setRedirect( 'index.php?option=com_verplan&controller=upload&task=parse_file_to_array&file='.$dest);
					} else {
						$msg = 'Upload erfolgreich, Redirect auf die Datei und nicht die richtige Datenbankanzeige';
						$this->setRedirect( 'index.php?option=com_verplan', $msg );
					}
				} else {
					//Redirect and throw an error message
					$msg = "Upload nicht erfolgreich, Fehler beim Hochladen";
					$this->setRedirect( 'index.php?option=com_verplan', $msg );
				}
			} else {
				//Redirect and throw an error message
				$filesize_settings = $settings['max_file_size'];
				$msg = "Upload nicht erfolgreich, Datei ist zu groß ($filesize > $filesize_settings)";
				$this->setRedirect( 'index.php?option=com_verplan', $msg );
			}

		} else {
			//Redirect and notify user file is not right extension
			$filetype = strtolower(JFile::getExt($filename));
			$allowed_filetypes_string = implode(",",$allowed_filetypes);
			$msg = "Upload nicht erfolgreich, falscher Dateityp ($filetype), erlaubt sind: $allowed_filetypes_string";
			$this->setRedirect( 'index.php?option=com_verplan', $msg );
		}
	}

	/**
	 * gibt den String zwischen $start und $end zurueck
	 * 
	 * @param $string
	 * @param $start
	 * @param $end
	 * @return string
	 */
	function get_string_between($string, $start, $end) {
		$string = " ".$string;
		$ini = strpos($string,$start);
		if ($ini == 0) return "";
		$ini += strlen($start);
		$len = strpos($string,$end,$ini) - $ini;
		return substr($string,$ini,$len);
	}

	/**
	 * wandelt die datei in ein array um (parsen) und übergibt das array an die methode zum speichern
	 * bei fehlern werden meldungen ausgegeben
	 * 
	 * @param $filename
	 * @return array
	 */
	function parse_file_to_array($file) {
		//falls keine datei angegeben ist und die methode z.b. ueber den task gestartet wurde
		if (!$file){
			$file = JRequest::getVar('file');
		}

		//Dateiinhalt der plandatei laden
		$FileHandle = fopen($file, "r" ) ;
		$n = filesize($file) ;
		$inhalt = fread( $FileHandle , $n ) ;
		fclose( $FileHandle ) ;

		//falls es sich um eine gp-untis datei handelt
		if (true OR strpos($inhalt, "gp-Untis")) {
			//debug
			echo "<pre>";
			/*
			 //string sollte nur mit "guten" umbruechen sein
			 //also aus \r\n nur \n machen, ads vereinfacht alles
			 $zeichen = "\n";
			 $inhalt = str_replace("\r\n", $zeichen, $inhalt);
			 //keine probleme mit ' und "
			 $inhalt = str_replace("'", '"', $inhalt);
			 */


			//extractor, parser
			//extractor einbinden
			require_once("components/com_verplan/includes/js-extractor_0.1.1/library/JS/Extractor.php");
			//neue instanz des Extractors
			$extractor = new JS_Extractor($inhalt);
			$body = $extractor->query("body")->item(0);
			$table = $body->query("//table")->item(0);

			/*STAND*/

			//0. stand aus tabellenzelle
			//$data = $table->extract(array(".//tr", "th|td"));
			//$standstring = $data['2']['4'];

			//1. stand mit dom über nummer der zelle
			//$td = $extractor->query("//td");
			//$standstring = $td->item(12)->nodeValue;

			// 2. stand ueber regulaeren ausdruck
			/* regulaerer ausdruck: Stand: dann zeichen dann Uhrzeit mit :, 
			 * U=ungreedy
			 * */
			$pattern = '/Stand:.*:[0-5][0-9]/U';
			if(preg_match_all($pattern,$inhalt,$matches)){
				//falls es mehr als zwei treffer gibt, sollte es eine fehlermeldung geben
				if($matches[1] && !$ignore){
					//debug
					foreach ($matches as $y => $match) {
						print_r($match);
					}
					$msg = "Fehler beim Parsen (stand, regexp, zu viele entsprechungen, line: ".__LINE__.")";
					$this->setRedirect( 'index.php?option=com_verplan', $msg );
				} else {
					foreach ($matches as $y => $match) {
						//debug
						//print_r($match);
						$standstring = $match[0];
					}

				}
			} else {
				$msg = "Fehler beim Parsen (stand, regexp, nichts gefunden, line: ".__LINE__.")";
				$this->setRedirect( 'index.php?option=com_verplan', $msg );
			}

			//strip "Stand:"
			$standstring = substr($standstring,0);

			//Datumsformat parsen
			$stand_array = date_parse_from_format("d.m.Y H:i", $standstring);
			//print_r($stand_array);
			//array in unix timestamp wandeln
			$stand = mktime($stand_array[hour],$stand_array[minute],$stand_array[second],$stand_array[month],$stand_array[day],$stand_array[year]);

			//debug
			setlocale(LC_TIME, "de_DE");
			$format="Stand: %A %d.%m.%Y %H:%M";
			$strf=strftime($format,$stand);			
			echo "$strf <br>";
			//echo $standstring;


			/*DATUM*/
			/*foreach ($extractor->query("//div[@class='mon_title']") as $link) {
			 $datestring = $link->nodeValue."<br>";
			 }*/

			//laedt alle passenden div mit class und class="mon_title"
			$div = $extractor->query("//div[@class='mon_title']");
			$datestring = $div->item(0)->nodeValue;

			//Datumsformat parsen
			$date_array = date_parse_from_format("j.n.Y w", $datestring);
			//print_r($date_array);
			//array in unix timestamp wandeln
			$date = mktime($date_array[hour],$date_array[minute],$date_array[second],$date_array[month],$date_array[day],$date_array[year]);

			//debug
			setlocale(LC_TIME, "de_DE");
			$format="Date: %A %d.%m.%Y %H:%M";
			$strf=strftime($format,$date);
			echo "$strf <br>";



			/*
			 $search = array("sonntag","montag","dienstag","mittwoch","donnerstag","freitag","samstag");
			 $replace = array("0","1","2","3","4","5","6");
			 $date = str_replace( $search, $replace, strtolower( $date ) );
			 echo $date;

			 $datedate = date_parse_from_format("j.n.Y w", $date);
			 print_r($datedate);
			 echo date("l dS of F Y h:i:s A",$datedate);
			 */

			/*TABELLE*/
			//alle tabellen und trennt dann nach tr oder td
			
			//$table = $body->query("//table")->item(2);
			//$data = $table->extract(array(".//tr", "th|td"));
			
			$table = $extractor->query("//table[@class='mon_list']")->item(0);
			$data = $table->extract(array(".//tr", "th|td"));

			//debug
			print_r($data);

			//debug
			echo "</pre>";

			$msg = 'Parsen und Einstellen erfolgreich';
			//$this->setRedirect( 'index.php?option=com_verplan', print_r($data) );

		} else {
			$msg = "Datei eingestellt, ohne DB";
			$this->setRedirect( 'index.php?option=com_verplan', $msg );
		}
	}

}