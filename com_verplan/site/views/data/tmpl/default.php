<?php
/**
 * template zum anzeigen der daten als JSON
 * dise daten kann man natürlich auch in anderen programmen 
 * nutzen, indem man einfach die daten über die URL abruft.
 * die syntax ist
 * ?option=com_verplan&view=data&format=json&date=<mySQL Timestamp>&stand=<mySQL Timestamp>&options=<Optionen für das model>,<Optionen für die anzeige>
 * 
 * Timestamps
 * 
 * PHP -> MySQL
 * $date = date( 'Y-m-d H:i:s', $date );
 * 
 * MySQL -> PHP
 * $date = strtotime($date);
 * 
 * ACHTUNG: keine leerzeichen oder -zeilen vor JSON
 * 
 * @version		$Id$
 * @package		verplan
 * @author		Dominik Moritz {@link http://www.dmoritz.bplaced.de}
 * @link		http://code.google.com/p/verplan/
 * @license		GNU/GPL
 * @author      Created on 31-Jan-2010
 */

//-- No direct access
//defined('_JEXEC') or die('=;)');
?>
<?php
//http header setzen, nicht notwendig, aber besser
 
/*header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-type: application/json');*/

// Get the document object.
$document =& JFactory::getDocument();
 
// Set the MIME type for JSON output.
$document->setMimeEncoding('application/json');
$document->setCharset('utf-8');

?>
<?php
//holt das array
$arr = $this->verplanarray;

//$arr['access'] = $this->access;
//$arr['public'] = $this->public;
	
//nur, wenn zugang gewährt
if ($this->access) {
	
	/*codiert einen wert um
	function utf8(&$value, &$key) {
		utf8_encode($value);
		utf8_encode($key);
	}
	
	//codiert das array in utf-8
	array_walk_recursive($arr,utf8);
	*/
	
	//optionen für view
	$options = $this->options;
	
	switch ($options) {
		//arr nur zu debugzwecken
		case arr:
			//array direkt
			var_dump($arr);
			break;
			
		//wie arr
		case html:
			//lesbares json mit html
			$json = json_encode($arr);
			echo jsonReadable($json,true);
			break;
			
		//minimiertes json
		case min:
			//wandelt das assoziative array direkt in json um
			echo json_encode($arr);
			break;
	
		//standard
		default:
			//lesbares json
			$json = json_encode($arr);
			echo jsonReadable($json,false);
			break;
	}
} else {
	$arr['rows'] = null;
	$arr['infos'] = null;
	$arr['infos'][0][type] = 'no_access';
	
	echo json_encode($arr);
}



/*
 * besser lesbares json
 * http://de.php.net/manual/en/function.json-encode.php
 */
function jsonReadable($json, $html) {
    $tab = "\t";
    $new_json = "";
    $indent_level = 0;
    $in_string = false;
   
    if ($html) {
        $tab = "&nbsp;&nbsp;&nbsp;";
        $newline = "<br/>";
    } else {
        $tab = "\t";
        $newline = "\n";
    } 

    $json_obj = json_decode($json);

    if($json_obj === false)
        return false;

    $json = json_encode($json_obj);
    $len = strlen($json);

    for($c = 0; $c < $len; $c++)
    {
        $char = $json[$c];
        switch($char)
        {
            case '{':
            case '[':
                if(!$in_string)
                {
                    $new_json .= $char . $newline . str_repeat($tab, $indent_level+1);
                    $indent_level++;
                }
                else
                {
                    $new_json .= $char;
                }
                break;
            case '}':
            case ']':
                if(!$in_string)
                {
                    $indent_level--;
                    $new_json .= $newline . str_repeat($tab, $indent_level) . $char;
                }
                else
                {
                    $new_json .= $char;
                }
                break;
            case ',':
                if(!$in_string)
                {
                    $new_json .= ",". $newline . str_repeat($tab, $indent_level);
                }
                else
                {
                    $new_json .= $char;
                }
                break;
            case ':':
                if(!$in_string)
                {
                    $new_json .= ": ";
                }
                else
                {
                    $new_json .= $char;
                }
                break;
            case '"':
                if($c > 0 && $json[$c-1] != '\\')
                {
                    $in_string = !$in_string;
                }
            default:
                $new_json .= $char;
                break;                   
        }
    }

    return trim($new_json);
}
?>
