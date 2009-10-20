<?php
/**
 *
 * @version		$Id$
 * @package		verplan
 * @author		Dominik Moritz {@link http://www.dmoritz.bplaced.net}
 * @link		http://code.google.com/p/verplan/
 * @license		GNU/GPL
 * @author      Created on 15-Sep-2009

 */

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

/**
 * verplan Upload Controller
 *
 * @package    verplan
 * @subpackage controller
 */
class VerplanControllerUpload extends verplanController
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
		$settingsmodel = JModel::getInstance('Settings', 'VerplanModel');
		$settings = $settingsmodel->getSettings();

		//falls fehler in den regulaeren ausdruecken ignoriert werden sollen
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
						//falls es keine fehler gab
						if (!JERROR::getError()) {
							//Erfolg melden
							//zu bebuggzwecken kann man dies auskommentieren und kann sich dann den ablauf ansehen
							$msg = 'Parsen und Senden erfolgreich';
							$this->setRedirect( 'index.php?option=com_verplan', $msg );
						}
					} else {
						$msg = 'Upload erfolgreich, Redirect auf die Datei und nicht die richtige Datenbankanzeige';
						$this->setRedirect( 'index.php?option=com_verplan', $msg );
					}
				} else {
					//Redirect and throw an error message
					$msg = "Upload nicht erfolgreich, Fehler beim Hochladen";
					JError::raiseWarning(0,$msg);
					//$this->setRedirect( 'index.php?option=com_verplan', $msg );
				}
			} else {
				//Redirect and throw an error message
				$filesize_settings = $settings['max_file_size'];
				$msg = "Upload nicht erfolgreich, Datei ist zu groß ($filesize > $filesize_settings)";
				JError::raiseWarning(0,$msg);
				//$this->setRedirect( 'index.php?option=com_verplan', $msg );
			}

		} else {
			//Redirect and notify user file is not right extension
			$filetype = strtolower(JFile::getExt($filename));
			$allowed_filetypes_string = implode(",",$allowed_filetypes);
			$msg = "Upload nicht erfolgreich, falscher Dateityp ($filetype), erlaubt sind: $allowed_filetypes_string";
			JError::raiseWarning(0,$msg);
			//$this->setRedirect( 'index.php?option=com_verplan', $msg );
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

			//extractor, parser
			/*
			* extractor einbinden
			* der extractor und parser ist ein externes programm, welches sich in
			* admin/includes/js-extractor_0.1.1 befindet
			*/
			require_once("components/com_verplan/includes/js-extractor_0.1.1/library/JS/Extractor.php");
			//neue instanz des Extractors
			$extractor = new JS_Extractor($inhalt);
			$body = $extractor->query("body")->item(0);
			$table = $body->query("//table")->item(0);

			/*STAND*/

			/*
			 * alternative Lösungen
			 */
			//0. stand aus tabellenzelle
			//$data = $table->extract(array(".//tr", "th|td"));
			//$standstring = $data['2']['4'];

			//1. stand mit dom über nummer der zelle
			//$td = $extractor->query("//td");
			//$standstring = $td->item(12)->nodeValue;
			/*
			* ende alternative Lösungen
			*/


			// 2. stand ueber regulaeren ausdruck
			/*
			* regulaerer ausdruck: Stand: dann zeichen dann Uhrzeit mit :,
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

			//Datumsformat parsen !!ACHTUNG, benoetigt >= PHP 5.3!!
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


			/*TABELLE*/
			//alle tabellen und trennt dann nach tr oder td

			//$table = $body->query("//table")->item(2);
			//$data = $table->extract(array(".//tr", "th|td"));

			$table = $extractor->query("//table[@class='mon_list']")->item(0);
			$data = $table->extract(array(".//tr", "th|td"));

			//debug
			//print_r($data);

			//zaehlt die anzahl der spalten (count von subarray), hier nicht verwendet
			//$columns = count($data[0]);
			
			$date = date( 'Y-m-d H:i:s', $date );
			$stand = date( 'Y-m-d H:i:s', $stand );
			
			//array für uploads tabelle
			$upload_arr[Geltungsdatum] = $date; //geltungsdatum
			$upload_arr[Stand] = $stand; //stand
			$upload_arr[type] = 'db'; //typ, hier datenbank
			$upload_arr[url] = $file; //url zur hochgeladenen datei (hier parameter)
			
			
			/*
			 * hier wird das model aufgerufen und die tabelle mit den uploads wird beschrieben. 
			 * darin sind z.b stand und datum vermerkt und über eine id erreichbar.
			 * diese id taucht dann wieder in der plantabelle auf -> normalisierung
			 */
			$model = $this->getModel('data');
			$id = $model->log_in_uploads($upload_arr);
			
			
			//array mit plandaten zum uebergeben vorbereiten (datum und stand anhaengen)
			//tabellenkopf
			$data[0][] = "id_upload";

			/*
			 * umwandeln der timestamps in mysql timestamps
			 * kann einfach entfernt werden, dann wird nicht umgewandelt
			 *
			 * Timestamps
			 *
			 * PHP -> MySQL
			 * $date = date( 'Y-m-d H:i:s', $date );
			 *
			 * MySQL -> PHP
			 * $date = strtotime($date);
			 *
			 */

			//tabellenzellen
			for ($i = 1; $i < count($data); $i++) {
				$data[$i][] = $id;
			}

			//debug
			//print_r($data);


			/*
			 * an dieser stelle wird das model data aufgerufen und die methode
			 * store mit dem array des vertretungsplanes als uebergabewert aufgerufen
			 *
			 * das array enthält alle daten, des planes inklusive einer id für datum und stand
			 */			
			$model->store($data);

			//debug
			echo "</pre>";

		} else {
			$msg = "Datei eingestellt, ohne DB";
			$this->setRedirect( 'index.php?option=com_verplan', $msg );
		}
	}

}
