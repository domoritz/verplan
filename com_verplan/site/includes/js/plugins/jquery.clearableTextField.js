 /*
  * Clearable Text Field - jQuery plugin version 0.1
  * Copyright (c) 2009 Tatsuya Ono
  *
  * http://github.com/ono/clearable_text_field
  *
  * Dual licensed under the MIT and GPL licenses:
  *   http://www.opensource.org/licenses/mit-license.php
  *   http://www.gnu.org/licenses/gpl.html
  */
(function($) {
  $.fn.clearableTextField = function() {
    if ($(this).length>0) {
      $(this).bind('keyup change paste cut', onSomethingChanged);
    
      trigger($(this));
    }
  }
  
  function onSomethingChanged() {
    trigger($(this));
  }
  
  function trigger(input) {
    if(input.val().length>0){
      add_clear_button(input);
    } else {
      remove_clear_button(input);
    }    
  }
  
  function add_clear_button(input) {
    if (input.parent().children('div.text_clear_button').length==0) {
      // appends div
      input.parent().append("<div class='text_clear_button'></div>");
    
      var clear_button = input.parent().children('div.text_clear_button');
      var w = clear_button.outerHeight(), h = clear_button.outerHeight();
      
      /*       
      input.css('padding-right', parseInt(input.css('padding-right')) + w + 1);
      input.width(input.width() - w - 1);
       */
      
      input.css('padding-right', parseInt(input.css('padding-right')) + 1);
      input.width(input.width() - 1);
          
      var pos = input.position();
      var style = {};  
      style['left'] = pos.left + input.outerWidth(false) - (w+2);
      var offset = Math.round((input.outerHeight(true) - h)/2.0);
      style['top'] = pos.top + offset;
            
      clear_button.css(style);
          
      clear_button.click(function(){
        input.val('');
        
        //filter updaten        
        resetAllFilter();
        resetKlassFilter();
        
        trigger(input);
      });
    }
  }
  
  function remove_clear_button(input) {
    var clear_button = input.parent().children('div.text_clear_button');
    
    if (clear_button.length>0) {
      clear_button.remove();
      var w = clear_button.width();

      input.css('padding-right', parseInt(input.css('padding-right')) - w -1);
      input.width(input.width() + w + 1);
    }
  }
  
})(jQuery);