/**
 * @version $Id$
 * @package verplan
 * @author  Dominik Moritz {@link http://www.dmoritz.bplaced.de}
 * @link    http://code.google.com/p/verplan/
 * @license GNU/GPL
 * @author  Created on 20-Jan-2010
 */

/**
 * It will cause Javascript errors, terminating the execution of the block of Javascript containing the error. 
 * You could, however, define a dummy function that's a no-op when Firebug is not active:
 * 
 * diese zeilen lenken die consolenausgaben ins leere, falls keine console vorhanden ist. 
 * das ist wichtig, weil es sonst zu js fehlern kommt. 
 */

/**
 * Hilfe zu debug: http://getfirebug.com/console.html
 * und http://michaelsync.net/2007/09/09/firebug-tutorial-logging-profiling-and-commandline-part-i
 */

if(typeof console === "undefined") {
    console = { 
    		log: function() {},
    		warn: function() {},
    		info: function() {},
    		assert: function() {},
    		trace: function() {},
    		time: function() {},
    		timeEnd: function() {},
    		groupEnd: function() {},
    		group: function() {}
    };
} 