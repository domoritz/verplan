<?php
/**
 * klasse für den upload. der erzeugte controller wird mit datengefüllt. 
 * anschließend können die verschiedenen methoden ausgeführt werden.
 * die daten werden an die models weitergegeben. 
 *
 * @version		$Id$
 * @package		verplan
 * @author		Dominik Moritz {@link http://www.dmoritz.bplaced.de}
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
	 * Dateiinhalt
	 * @var string
	 */
	public $inhalt;
	/**
	 * dateiinformationen
	 * @var file
	 */
	public $file;
	/**
	 * daten der datei
	 * @var array
	 */
	public $data;
	
	/**
	 * array mit informationen über den upload
	 * darin sind z.b stand und datum vermerkt und über eine id erreichbar.
 	 * diese id taucht dann wieder in der plantabelle auf -> normalisierung
	 * @var array
	 */
	public $upload_arr;
	
	/**
	 * id des uploads aus der tabelle uploads
	 * @var unknown_type
	 */
	public $id;
	
	/**
	 * stand und geltungsdatum, nur bei geparsten daten
	 * @var unknown_type
	 */
	public $stand;
	public $date;

	/**
	 * lädt den die vertretungsplandatei hoch
	 * @return void
	 */
	function upload() {
		//Retrieve file details from uploaded file, sent from upload form
		$file = JRequest::getVar('file', null, 'files', 'array');

		//lade Settings
		//$settingsmodel = JModel::getInstance('Settings', 'VerplanModel');
		//$settings = $settingsmodel->getSettings();

		//falls fehler in den regulaeren ausdruecken ignoriert werden sollen
		$ignore = JRequest::getVar('ignore',false);

		//get filetype information
		$settingsmodel = $this->getModel('settings');
		$allowed_filetypes_string = $settingsmodel->getSetting('allowed_filetypes');
		$allowed_filetypes = explode(",",$allowed_filetypes_string);

		//Import filesystem libraries. Perhaps not necessary, but does not hurt
		jimport('joomla.filesystem.file');
		
		//die datei bekommt das datum in den dateinamen
		$date = date( 'Ymd_Hi_');
		$file['name'] = $date.$file['name'];

		//Clean up filename to get rid of strange characters like spaces etc
		$filename = JFile::makeSafe($file['name']);

		//get filesize
		$filesize = $file['size'];

		//Set up the source and destination of the file
		$src = $file['tmp_name'];
		$upload_dir_comp = $settingsmodel->getSetting('upload_dir_comp');
		
		
		//$upload_dir_comp = "uploads";
		$dest = JPATH_ADMINISTRATOR . DS . $upload_dir_comp . DS . $filename;

		//bestimmungsort
		$file[dest] = $dest;

		//First check if the file has the right extension, we need jpg only
		if ( in_array(strtolower(JFile::getExt($filename)),$allowed_filetypes) OR false) {
			if ($filesize <= $settingsmodel->getSetting('max_file_size')) {
				if (JFile::upload($src, $dest) ) {
					/*
					 * Erfolg melden, upload erfolgreich
					 * es wird true an den controller sent zurückgegeben, welcher nun weiter verfährt
					 */
					//speichere file in class variable
					$this->file = $file;

					//rückgabewert
					return ($file);
				} else {
					//Redirect and throw an error message
					$msg = "Upload nicht erfolgreich, Fehler beim Hochladen";
					JError::raiseWarning(0,$msg);
					//$this->setRedirect( 'index.php?option=com_verplan', $msg );
				}
			} else {
				//Redirect and throw an error message
				$filesize_settings = $settingsmodel->getSetting('max_file_size');
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
	 * löscht die datei
	 * @return unknown_type
	 */
	function remove() {
		return JFile::delete($this->file[dest]);		
	}

	/**
	 * wandelt umlaute in inhalt um, diese funktion muss nocheinmal
	 * anhand richtiger daten überprüft werden
	 *
	 */
	function umlaute() {

		//$this->inhalt = iconv("UTF-8", "ISO-8859-1//TRANSLIT", $this->inhalt);

		/*$countt = 0;

		//umlaute austauschen
		$umlaute = array("ä", "ö", "ü","Ä","Ö","Ü","ß","~","&nbsp;");
		$expressions = array("&auml;", "&ouml;", "&uuml;","&Auml;","&Ouml;","&Uuml;","&szlig;","&#126;"," ");

		for ($i = 0; $i < count($umlaute); $i++) {
			$this->inhalt = str_replace($umlaute[$i], $expressions[$i], $this->inhalt, $count);
			$countt += $count;
		}*/
		
		function htmlent(&$value, &$key) {
			htmlentities($value);
			htmlentities($key);
		}

		//codiert das array in utf-8
		array_walk_recursive($this->data,htmlent);

		///*debug
		echo '<br>==========<br>';
		echo "Umlaute ausgetauscht<br>";
		//*/
	}

	/**
	 * codiert das array um
	 * @return unknown_type
	 */
	function charset() {
		//in utf-8

		//codiert einen wert um
		function utf8(&$value, &$key) {
			utf8_encode($value);
			utf8_encode($key);
		}

		//codiert das array in utf-8
		array_walk_recursive($this->data,utf8);
	}

	/**
	 * liest die datei in die variable inhalt ein
	 *
	 */
	function einlesen() {
		$file = $this->file;

		//öffnet die datei
		$FileHandle = fopen($file[dest], "r" ) ;
		//größe, wichtig für lesen
		$n = $file[size];
		//leißt bis zur größe ein
		$inhalt = fread( $FileHandle , $n ) ;
		//schleißt die datei wieder
		fclose( $FileHandle ) ;

		//inhalt in class variable speichern
		$this->inhalt = $inhalt;
	}


	/**
	 * wandelt die datei in ein array um (parsen)
	 * bei fehlern werden meldungen ausgegeben
	 *
	 * @param $filename
	 * @return array
	 */
	function parse_file_to_array() {
		//variable file aus klasse
		$file = $this->file;

		//variable inhalt aus klasse
		$inhalt = $this->inhalt;

		//extractor, parser
		/*
		* extractor einbinden
		* der extractor und parser ist ein externes programm, welches sich in
		* admin/includes/js-extractor_0.1.1 befindet
		*/
		require_once("components/com_verplan/includes/js-extractor_0.1.1/library/JS/Extractor.php");
		//neue instanz des Extractors
		$extractor = new JS_Extractor($this->inhalt);
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

		$settingsmodel = $this->getModel('settings');
		$pattern = $settingsmodel->getSetting('pattern_stand');
		//$pattern = '/Stand:.*:[0-5][0-9]/U';
		if(preg_match_all($pattern,$this->inhalt,$matches)){
			//wählt die erste entsprechung
			$standstring = $matches[0][0];
		} else {
			$msg = "Fehler beim Parsen (stand, regexp, nichts gefunden, line: ".__LINE__.")";
			$this->setRedirect( 'index.php?option=com_verplan', $msg );
		}

		//strip "Stand:", wenn nötig, hier unnötig
		$standstring = substr($standstring,0);

		//Datumsformat parsen !!ACHTUNG, benoetigt >= PHP 5.3!!
		$format = $settingsmodel->getSetting('format_stand');
		//$format = "d.m.Y H:i";
		$stand_array = date_parse_from_format($format, $standstring);
		//var_dump($stand_array);
		//array in unix timestamp wandeln
		$stand = mktime($stand_array[hour],$stand_array[minute],$stand_array[second],$stand_array[month],$stand_array[day],$stand_array[year]);

		$this->stand = $stand;
		
		///*debug
		echo '<br>==========<br>';
		echo 'Stand<br>';
		echo $standstring.'<br>';
		setlocale(LC_TIME, "de_DE");
		$format="Stand: %A %d.%m.%Y %H:%M";
		$strf=strftime($format,$stand);
		echo "$strf <br>";
		//*/


		/*DATUM*/
		/*foreach ($extractor->query("//div[@class='mon_title']") as $link) {
		 $datestring = $link->nodeValue."<br>";
		 }*/
		
		//http://jacksleight.com/old/blog/2008/02/10/js-extractor-and-the-death-of-table-extractor

		//laedt alle passenden div mit class und class="mon_title"
		$pattern = $settingsmodel->getSetting('pattern_date');
		//$pattern = "//div[@class='mon_title']";
		$div = $extractor->query($pattern);
		$datestring = $div->item(0)->nodeValue;

		//Datumsformat parsen
		$format = $settingsmodel->getSetting('format_date');
		//$format = "j.n.Y w";
		$date_array = date_parse_from_format($format, $datestring);
		//var_dump($date_array);
		//array in unix timestamp wandeln
		$date = mktime($date_array[hour],$date_array[minute],$date_array[second],$date_array[month],$date_array[day],$date_array[year]);

		$this->date = $date;

		///*debug
		echo '<br>==========<br>';
		echo 'Geltungsdatum<br>';
		echo $datestring.'<br>';
		setlocale(LC_TIME, "de_DE");
		$format="Date: %A %d.%m.%Y %H:%M";
		$strf=strftime($format,$date);
		echo "$strf <br>";
		//*/


		/*TABELLE*/
		//alle tabellen und trennt dann nach tr oder td

		//$table = $body->query("//table")->item(2);
		//$data = $table->extract(array(".//tr", "th|td"));

		$pattern = $settingsmodel->getSetting('pattern_plan');
		//$pattern = "//table[@class='mon_list']";
		$table = $extractor->query($pattern)->item(0);
		$data = $table->extract(array(".//tr", "th|td"));

		//debug
		//var_dump($data);

		//zaehlt die anzahl der spalten (count von subarray), hier nicht verwendet
		//$columns = count($data[0]);
			
		$date = date( 'Y-m-d H:i:s', $date );
		$stand = date( 'Y-m-d H:i:s', $stand );

		$upload_dir = $settingsmodel->getSetting('upload_dir');
		//$upload_dir = "/components/com_verplan/uploads/";
			
		//array für uploads tabelle
		$upload_arr[Geltungsdatum] = $date; //geltungsdatum
		$upload_arr[Stand] = $stand; //stand
		$upload_arr[type] = 'db'; //typ, hier datenbank
		$path = JURI::base(true).$upload_dir.JFile::makeSafe($file['name']);
		$upload_arr[url] = $path; //url zur hochgeladenen datei

		/*debug
		echo '<br>==========<br>';
		echo 'Array für Uploads<br>';
		var_dump($upload_arr);
		//*/

			
		//speichere die uploaddaten in einer klassenvariablen zur weiteren verwendung
		$this->upload_arr = $upload_arr;

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

		//debug
		//var_dump($data);

		//speichert data in class variable
		$this->data = $data;


		//gibt array data zurück
		return $data;
	}
	
	/**
	 * hängt die id_upload an das array mit den daten an,
	 * um zu speichern, zu welchem upload die daten gehören 
	 * (und damit zu welchem datum und stand) 
	 * 
	 * @return unknown_type
	 */
	function append_id() {
		//tabellenkopf für id_upload
		$this->data[0][] = "id_upload";

		//tabellenzellen
		for ($i = 1; $i < count($this->data); $i++) {
			$this->data[$i][] = $this->id;
		}
	}


	/**
	 * methode zum speichern der daten in der datenbank
	 * es wird an das model weitergegeben
	 *
	 * @return unknown_type
	 */
	function store() {
		/*
		 * an dieser stelle wird das model data aufgerufen und die methode
		 * store mit dem array des vertretungsplanes als uebergabewert aufgerufen
		 *
		 * das array enthält alle daten, des planes inklusive einer id für datum und stand
		 */
		$model = $this->getModel('data');
		$model->store($this->data);
	}

}
