<?php
$controller   = JRequest::getCmd('controller', 'com_verplan');

JHTML::_('behavior.switcher');

// Load submenus
$controllers = array('' => JText::_('Home'), '&view=columns' => JText::_('Spalten'), '&view=settings' => JText::_('Einstellungen'), '&view=about' => JText::_('About'), );

foreach ($controllers as $key => $val) {
   $active   = ($controller == $key);
   JSubMenuHelper::addEntry($val, 'index.php?option=com_verplan'.$key, $active);
}
?>
