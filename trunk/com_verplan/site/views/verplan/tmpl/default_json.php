<?php
/**
 * template zum anzeigen der daten als JSON
 * dise daten kann man natürlich auch in anderen programmen 
 * nutzen, indem man einfach die daten über die URL abruft.
 * die syntax ist
 * /index.php?option=com_verplan&view=verplan&format=js&date=<mySQL Timestamp>&stand=<mySQL Timestamp>
 * 
 * Timestamps
 * 
 * PHP -> MySQL
 * $date = date( 'Y-m-d H:i:s', $date );
 * 
 * MySQL -> PHP
 * $date = strtotime($date);
 * 
 * @version		$Id$
 * @package		verplan
 * @author		Dominik Moritz {@link http://www.dmoritz.bplaced.net}
 * @link		http://code.google.com/p/verplan/
 * @license		GNU/GPL
 * @author      Created on 07-Okt-2009
 */

//-- No direct access
defined('_JEXEC') or die('=;)');
?>

<?php
//header('Content-type: application/json');
?>

<?php
//holt das array
$arr = $this->verplanarray;

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
	
	case arr:
		//array direkt
		var_dump($arr);
		break;

	case html:
		//lesbares json mit html
		$json = json_encode($arr);
		echo jsonReadable($json,true);
		break;

	case min:
		//wandelt das assoziative array direkt in json um
		echo json_encode($arr);
		break;

	default:
		//lesbares json
		$json = json_encode($arr);
		echo jsonReadable($json,false);
		break;
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

    return $new_json;
}
?>
