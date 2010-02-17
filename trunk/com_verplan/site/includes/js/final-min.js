/*version: 02/17/2010*/
var speed=500;var effects=true;var effects_indi=true;var note_loader;jQuery(document).ajaxSend(function(){jQuery("#loading").fadeIn("fast")});jQuery(document).ajaxStop(function(){jQuery("#loading").pause(500).fadeOut(1000)});function hideNoDB(){if(jQuery("#no_db").css("display")!="none"){if(effects){jQuery("#no_db").hide("blind",speed)}else{jQuery("#no_db").hide()}}}function showNoDB(){if(effects){jQuery("#no_db").show("blind",speed)}else{jQuery("#no_db").show()}}function showIndicator(){if(effects_indi){showHint("Lade Daten...","info","250px","loady");if(notify=="pnotify"||notify=="both"){note_loader=jQuery.pnotify({pnotify_title:"Lade Daten...",pnotify_text:"Daten des Vertretungsplanes werden geladen. Bitte warten.",pnotify_hide:false,pnotify_history:false})}}}function hideIndicator(){if(effects_indi){hideHint(1500);setTimeout(function(){if(note_loader){note_loader.pnotify_remove()}},1500)}}function showTable(){if(effects){jQuery("#jquerytable tbody").fadeIn(speed)}}function hideTable(){if(effects){jQuery("#jquerytable tbody").fadeOut(speed,ajaxCall)}}var ajax_date;var ajax_stand;var ajax_options;var note_noplan;var note_error_load;var note_nodb;var note_db;var myInterval2;function getAndUseJSON(date,stand,options){ajax_date=date;ajax_stand=stand;ajax_options=options;showIndicator();jQuery("#miniindi").show();hideTable()}function ajaxCall(){jQuery.ajax({type:"GET",dataType:(jQuery.browser.msie)?"text":"json",contentType:"application/json; charset=utf-8",cache:false,url:rooturl+"index.php",data:{option:"com_verplan",view:"data",format:"json",date:ajax_date,stand:ajax_stand,options:ajax_options},timeout:(15000),async:true,global:true,success:function(XMLHttpRequest,textStatus){if(XMLHttpRequest.infos==""){JSONfail(XMLHttpRequest,textStatus)}else{JSONsuccess(XMLHttpRequest,textStatus)}},error:function(XMLHttpRequest,textStatus,errorThrown){switch(textStatus){case"timeout":var reload=confirm("Timeout Fehler beim Laden der Einstellungen.\n Willst du die Seite neu laden?");if(reload){location.reload()}break;case"404":alert("Angeforderte URL nicht gefunden.\n Code 404");break;case"500":alert("Interner Servererror!\n Code 500");break;case"0":alert("Du bist offline. Bitte überprüfe dein Netzwerk.");break;case"parsererror":alert("Error\nParsen des JSON fehlgeschlagen!\n".textStatus);break;default:alert("Unbekannter Fehler beim Laden des Vertretungsplanes!\nXMLHttpRequest:"+XMLHttpRequest+"\ntextStatus: "+textStatus+"\nError: "+errorThrown)}},complete:hideIndicator})}function JSONsuccess(json,textStatus){if(jQuery.browser.msie){json=eval("("+json+")")}infoarr=json.infos;var length=infoarr.length-1;switch(json.infos[length].type){case"db":hideNoDB();buildTableFromJSON(jQuery("#jquerytable tbody"),json.rows);showTable();filterKlassen(json.rows);table_update();if(notify=="pnotify"||notify=="both"){note_db=jQuery.pnotify({pnotify_title:"Vertretungsplan geladen",pnotify_text:"Der Vertretungsplan für den "+json.infos[length].Geltungsdatum.substring(0,10)+" (Stand: <strong>"+json.infos[length].Stand+"</strong>) wurde erfolgreich geladen. ",pnotify_notice_icon:"ui-icon ui-icon-info",pnotify_type:"notice"})}break;case"none":jQuery("#no_db").html("<p>Hurra! Keine Vertretungen für diesen Tag </p>(Stand: "+json.infos[length].Stand+")");showNoDB();if(notify=="pnotify"||notify=="both"){note_nodb=jQuery.pnotify({pnotify_title:"keine Vertretungen",pnotify_text:"Für den gewählten Tag gibt es keine Vertretungen. Das heißt, der Unterricht findet wie geplant statt. Bitte beachte, dass sich der Vertretungsplan ständig ändern kann.",pnotify_notice_icon:"ui-icon ui-icon-lightbulb",pnotify_type:"notice",pnotify_hide:false})}break;default:jQuery("#no_db").html('<p><a href="'+json.infos[length].url+'">zum Vertretungsplan...</a> </p>(Stand: '+json.infos[length].Stand+")");showNoDB();if(notify=="pnotify"||notify=="both"){note_nodb=jQuery.pnotify({pnotify_title:"Datei",pnotify_text:'Für den gewählten Tag wurde ein Vertretungsplan hochgeladen. Dieser liegt als "'+json.infos[length].type+'" vor. Um den Vertretungsplan zu sehen, musst du die Datei Ã¶ffnen. Klicke dazu auf den <a href="'+json.infos[length].url+'">Link</a>.',pnotify_notice_icon:"ui-icon ui-icon-lightbulb",pnotify_type:"notice",pnotify_hide:false})}break}jQuery("#miniindi").hide()}function JSONfail(json,textStatus){jQuery("#jquerytable tbody").html("");jQuery("#no_db").hide();if(notify=="pnotify"||notify=="both"){note_noplan=jQuery.pnotify({pnotify_title:"Fehler",pnotify_text:"Es wurdet kein Plan für das gewählte Datum gefunden. Bitte wähle ein anderes Datum!",pnotify_error_icon:"ui-icon ui-icon-alert",pnotify_type:"error",pnotify_hide:false})}if(notify=="own"||notify=="both"){clearInterval(myInterval2);console.log("start listener");myInterval2=setInterval(function(){console.log("wait for hint");if(hintshown==false){clearInterval(myInterval2);hintshown==true;setTimeout("showHint('Fehler. Es existiert kein Plan für das gewählte Datum.', 'warn', '400px', 'noplan');",200)}},100)}}function buildTableFromJSON(tbody,json){console.time("tablebuild");tbody.html("");var table="";jQuery.each(json,function(){table+="<tr>";jQuery.each(this,function(name,content){table+='<td title="'+name+'">';table+=(content)?content:"";table+="</td>"});table+="</tr>"});tbody.append(table);console.timeEnd("tablebuild")}function filterKlassen(rows){console.time("filterklassen");jQuery("#klasse").html("");var klassehead=settings.class_name.value;var klassenArray=new Array();var klasse=null;var nummer=null;jQuery.each(rows,function(id,subarray){klasse=subarray[klassehead];nummer=klassenArray.length;if(klasse!=null){klasse.trim;if(!contains(klassenArray,klasse)){klassenArray[nummer]=klasse}}});klassenArray.sort(sortfunction);console.log(klassenArray);jQuery("#klasse").append('<option value="">alle</option>');jQuery.each(klassenArray,function(id,klasse){jQuery("#klasse").append('<option value="'+klasse+'">'+klasse+"</option>")});console.timeEnd("filterklassen")}function sortfunction(first,second){var komma=first.search(",");if(komma<0){komma=first.length}first=first.substring(0,komma);var komma=second.search(",");if(komma<0){komma=second.length}second=second.substring(0,komma);a=jQuery.trim(first);a=a.toLowerCase();b=jQuery.trim(second);b=b.toLowerCase();var replace=null;var replaced_a=false;var replaced_b=false;var array=new Array("a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z");for(var i=0;i<array.length;i++){if(i>=10){replace=i}else{replace="0"+(i+1)}if(a.search(RegExp(array[i],"g"),replace)>0){a=a.replace(RegExp(array[i],"g"),replace);replaced_a=true}if(b.search(RegExp(array[i],"g"),replace)>0){b=b.replace(RegExp(array[i],"g"),replace);replaced_b=true}}if(!replaced_a){a=a+"00"}if(!replaced_b){b=b+"00"}return(a-b)}function uniqueArr(a){for(i=0;i<a.length;i++){if(contains(a,a[i])){a.splice(a.indexOf(a[i]),1)}}return a}function contains(a,e){var inarray=false;for(j=0;j<a.length;j++){if(a[j]==e){inarray=true}}return inarray}jQuery(document).ready(function(){jQuery("a[rel^='prettyPhoto']").prettyPhoto();jQuery("#feedy").click(function(){jQuery.prettyPhoto.open("http://spreadsheets.google.com/viewform?formkey=dGdDanZxa2k4RHhKbHJaS1RxT0Q2eWc6MA&iframe=true&width=95%&height=100%","Feedbackbogen","Gib hier dein Feedback zum Programm ab und melde Fehler. ");return false})});if(typeof console==="undefined"){console={log:function(){},warn:function(){},info:function(){},assert:function(){},trace:function(){},time:function(){},timeEnd:function(){},groupEnd:function(){},group:function(){}}}var filterKlasse=jQuery.cookie("Klasse");if(filterKlasse==null){filterKlasse=""}var myInterval;var note_filter;var note_filter_general;var note_klasse;function iniFilters(){jQuery("#filter_input").clearableTextField();jQuery("#filter_input").keyup(function(){jQuery("#klasse").val("");removeCookie();if(note_klasse){note_klasse.pnotify_remove()}filterTable()});jQuery("#filter_this").change(function(){jQuery("#klasse").val("");removeCookie();if(note_klasse){note_klasse.pnotify_remove()}jQuery("#filter_input").val(null).change();filterTable()});jQuery("#klasse").change(function(){if(note_klasse){note_klasse.pnotify_remove()}if(this.value==""){jQuery("#filter_this").val("");removeCookie()}else{jQuery("#filter_this").val(settings.class_col.value);jQuery.cookie("Klasse",this.value,{expires:7});filterKlasse=this.value;console.log("cookie gespeichert: "+this.value);if(notify=="pnotify"||notify=="both"){note_klasse=jQuery.pnotify({pnotify_title:"Klasse",pnotify_text:"Es werden nur die Spalten der Klasse "+this.value+' angezeigt. <a href="http://code.google.com/p/verplan/wiki/Benutzerhandbuch_Frontend#Filter_-_Klassen" target="_blank">Hilfe</a>',pnotify_notice_icon:"ui-icon ui-icon-search",pnotify_type:"notice",pnotify_remove:true,pnotify_hide:false})}}jQuery("#filter_input").val(this.value).change();filterTable()})}function filterTable(){var filter_this=jQuery("#filter_this").val();var input=jQuery("#filter_input").val();jQuery.uiTableFilter(jQuery("#jquerytable"),input,filter_this);if(notify=="pnotify"||notify=="both"){if(input!=""&!(note_filter_general)){note_filter_general=jQuery.pnotify({pnotify_text:'Ein Filter ist aktiv. <a href="http://code.google.com/p/verplan/wiki/Benutzerhandbuch_Frontend#Filter" target="_blank">Hilfe</a>',pnotify_notice_icon:"ui-icon ui-icon-search",pnotify_type:"notice",pnotify_remove:true,pnotify_hide:false})}if(input==""){if(note_filter_general){note_filter_general.pnotify_remove();note_filter_general=null}}}hideHint(0);if(note_filter){note_filter.pnotify_remove()}}function removeCookie(){jQuery.cookie("Klasse",null);filterKlasse="";console.log("cookie gelÃ¶scht")}function updateFilters(){jQuery("#klasse").val(filterKlasse);if(filterKlasse==""){}else{jQuery("#filter_this").val(settings.class_col.value);jQuery("#filter_input").val(filterKlasse)}jQuery("#filter_input").change();var filter_this=jQuery("#filter_this").val();var input=jQuery("#filter_input").val();jQuery.uiTableFilter(jQuery("#jquerytable"),input,filter_this);if(notify=="pnotify"||notify=="both"){if(jQuery("#filter_input").val()!=""){if(note_filter){note_filter.pnotify_remove()}note_filter=jQuery.pnotify({pnotify_title:"Filter aktiv",pnotify_text:'Es werden Spalten ausgeblendet, weil ein Filter aktiv ist. Wenn du wieder alle Spalten sehen mÃ¶chtest, klicke bitte <a href="javascript: clickOnClear()">hier</a>',pnotify_error_icon:"ui-icon ui-icon-search",pnotify_type:"error",pnotify_hide:false});note_filter_general=jQuery.pnotify({pnotify_text:'Ein Filter ist aktiv. <a href="http://code.google.com/p/verplan/wiki/Benutzerhandbuch_Frontend#Filter" target="_blank">Hilfe</a>',pnotify_notice_icon:"ui-icon ui-icon-search",pnotify_type:"notice",pnotify_remove:true,pnotify_hide:false})}}if(jQuery("#filter_input").val()!=""){if(notify=="own"||notify=="both"){clearInterval(myInterval);console.log("start listener");myInterval=setInterval(function(){console.log("wait for hint");if(hintshown==false){clearInterval(myInterval);hintshown==true;setTimeout("showHint('Es werden Spalten ausgeblendet, weil ein Filter aktiv ist', 'warn', '420px', 'filty');",500)}},100)}}}function clickOnClear(){jQuery("#klasse").val("").change()}var hash;var notify;var _alert;jQuery(document).ready(function(){hash=getHash();if(!hash){hash=jQuery("#select_date_verplan").val();setHash(hash)}initiate_everything()});function initiate_everything(){notify=settings.notify.value;if((notify=="pnotify"||notify=="both")&&settings.message_title.value!=""){jQuery.pnotify({pnotify_title:settings.message_title.value,pnotify_text:settings.message.value,pnotify_notice_icon:"ui-icon ui-icon-star",pnotify_type:"notice",pnotify_hide:false})}hash=getHash();table_init();jQuery("#logo_verplan").click(function(){window.location.hash="";window.location.href=window.location.href.slice(0,-1)});if(notify=="pnotify"||notify=="both"){clicks_notice()}jQuery.historyInit(loadverplan,"index.php")}function loadverplan(hash){clearInterval(myInterval);clearInterval(myInterval2);if(notify=="pnotify"||notify=="both"){if(note_noplan){note_noplan.pnotify_remove()}if(note_error_load){note_error_load.pnotify_remove()}if(note_filter_general){note_filter_general.pnotify_remove()}if(note_nodb){note_nodb.pnotify_remove()}if(note_db){note_db.pnotify_remove()}if(note_loader){note_loader.pnotify_remove()}}jQuery("#select_date_verplan option").attr("selected","");jQuery("#select_date_verplan option[value='"+hash+"']").attr("selected","selected");var selected=document.getElementById("select_date_verplan").selectedIndex;jQuery("#select_date_verplan").selectmenu("value",selected);ajax_stand="latest";ajax_options=",min";getAndUseJSON(hash,ajax_stand,ajax_options)}function gup(name){name=name.replace(/[\[]/,"\\[").replace(/[\]]/,"\\]");var regexS="[\\?&]"+name+"=([^&#]*)";var regex=new RegExp(regexS);var results=regex.exec(window.location.href);if(results==null){return false}else{return results[1]}}function consume_alert(){if(_alert){return}_alert=window.alert;window.alert=function(message){jQuery.pnotify({pnotify_title:"Alert",pnotify_text:message})}}function release_alert(){if(!_alert){return}window.alert=_alert;_alert=null}function clicks_notice(){jQuery("#help_head").click(function(){note_filter_general=jQuery.pnotify({pnotify_title:"Handbuch",pnotify_text:'Das Handbuch wurde geÃ¶ffnet.<br>Link: <a href="http://code.google.com/p/verplan/wiki/Benutzerhandbuch_Frontend">http://code.google.com/p/verplan/wiki/Benutzerhandbuch_Frontend</a>',pnotify_notice_icon:"ui-icon ui-icon-link",pnotify_type:"notice"})});jQuery("#link_homepage").click(function(){note_filter_general=jQuery.pnotify({pnotify_title:"Website",pnotify_text:'Die Homepage wurde aufgerufen.<br>Link: <a href="http://www.dmoritz.bplaced.de">http://www.dmoritz.bplaced.de</a>',pnotify_notice_icon:"ui-icon ui-icon-link",pnotify_type:"notice"})});jQuery("#link_project").click(function(){note_filter_general=jQuery.pnotify({pnotify_title:"Projektseite",pnotify_text:'Die Projektseite wurde geÃ¶ffnet.<br>Link: <a href="http://verplan.googlecode.com">http://verplan.googlecode.com</a>',pnotify_notice_icon:"ui-icon ui-icon-link",pnotify_type:"notice"})});jQuery("#feedy_oi").click(function(){note_filter_general=jQuery.pnotify({pnotify_title:"Feedbackbogen",pnotify_text:'Der Feedbackbogen wurde geÃ¶ffnet.<br>Link: <a href="http://verplan.googlecode.com">http://verplan.googlecode.com</a>',pnotify_notice_icon:"ui-icon ui-icon-link",pnotify_type:"notice"})})}jQuery.fn.pause=function(n){return this.queue(function(){var el=this;setTimeout(function(){return jQuery(el).dequeue()},n)})};function getHash(){var hash=window.location.hash.substr(1,document.location.hash.length);console.log("hash: "+hash);return hash}function setHash(hashP){hash=hashP;window.location.hash=hash;console.log("setHash "+hash+" | "+window.location.hash);return window.location.hash}jQuery.fn.chain=function(fn){var elements=this;var i=0;function nextAction(){if(elements.eq(i)){fn.apply(elements.eq(i),[nextAction])}i++}nextAction()};var hintshown=false;function showHint(text,type,width,name){if(notify=="own"||notify=="both"){hintshown=true;console.log("hintshown");if(!width){width="400px"}if(type=="warn"){text='<span class="icon_verplan icon_warn">&nbsp;</span><strong>Achtung:</strong> '+text}if(type=="info"){text='<span class="icon_verplan icon_info">&nbsp;</span><strong>Info:</strong> '+text}if(type=="critical"){text='<span class="icon_verplan icon_critical">&nbsp;</span><strong style="color: red; ">Kritischer Fehler:</strong> '+text}jQuery("#notify #text").html(text).parent().css("width",width).css("left",0).attr("name",name).show("slide",{direction:"right"},500);console.log(type+" "+text+" "+width+" "+name)}}function hideHint(time){if(notify=="own"||notify=="both"){if(hintshown==true){jQuery("#notify:visible").stop().pause(time).hide("slide",{direction:"right"},1000,function(){console.log("hinthidden");hintshown=false})}}}jQuery(document).ready(function(){if(jQuery.cookie("show_advanced_layer")=="true"){toggleStuff()}else{jQuery("#options_panel").hide("");jQuery.cookie("show_advanced_layer",null)}jQuery("#expander_options:not(.ui-state-active)").click(function(){jQuery("#options_panel").slideToggle(600);toggleStuff();jQuery.cookie("show_advanced_layer","true",{expires:7})});jQuery("#expander_options.ui-state-active").click(function(){jQuery("#options_panel").slideToggle(600);toggleStuff();jQuery.cookie("show_advanced_layer",null)})});function toggleStuff(){jQuery("#icon_options").toggleClass("ui-icon-circle-plus").toggleClass("ui-icon-circle-minus");jQuery("#expander_options").toggleClass("ui-state-default");jQuery("#expander_options").toggleClass("ui-state-active")}function table_init(){jQuery.tablesorter.addParser({id:"klasse",is:function(s){s=jQuery.trim(s);var reg=new RegExp("^[0-9]{1,2}( )*[a-z]{0,1}$","i");return s.search(reg)!=-1},format:function(s){var komma=s.search(",");if(komma<0){komma=s.length}s=s.substring(0,komma);s=jQuery.trim(s);s=s.toLowerCase();var replace=null;var replaced=false;var array=new Array("a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z");for(var i=0;i<array.length&&!replaced;i++){if(i>=10){replace=i}else{replace="0"+(i+1)}if(s.search(RegExp(array[i],"g"),replace)>0){s=s.replace(RegExp(array[i],"g"),replace);replaced=true}}if(!replaced){s=s+"00"}return s},type:"numeric"});jQuery("#jquerytable").tablesorter({dateFormat:"de",decimal:",",debug:false,sortMultiSortKey:"ctrlKey",textExtraction:"complex",cssDesc:"ui-state-active headerSortUp",cssAsc:"ui-state-active headerSortDown",widgets:["zebra"],widgetZebra:{css:["even","odd"]}});iniFilters();table_update()}function table_update(){if(jQuery("#hint_table").css("display")!="none"){jQuery("#hint_table").hide("blind","slow")}jQuery("#jquerytablebody tr").removeClass("even");jQuery("#jquerytablebody tr").removeClass("odd");jQuery("#jquerytable tbody tr:even").addClass("even");jQuery("#jquerytable tbody tr:odd").addClass("odd");jQuery("#jquerytable tbody").colorize({altColor:"none",bgColor:"none",hover:"row",click:"row",hiliteClass:"ui-state-hover",hoverClass:"state-hover",oneClick:false});jQuery("#jquerytable").trigger("update");jQuery("#jquerytable thead th.ui-state-active").click().click();updateFilters()}var style="";function updateTooltipStyle(){var theme=jQuery.cookie("jquery-ui-theme");console.log("jQuery UI theme: "+theme);switch(theme){case"UI darkness":style="own";break;case"UI lightness":style="dark";break;case"Start":style="dark";break;default:style="own";break}console.log("Tooltipstyle: "+style)}jQuery(document).ready(function(){updateTooltipStyle();defaultStyle();createTooltips()});function defaultStyle(){jQuery.fn.qtip.styles.domstyle={tip:{corner:true,background:null},"font-size":"small",border:{width:3,radius:2},name:style};jQuery.fn.qtip.styles.own={color:"#000",background:"#DCEDFF",border:{color:"#59B4D4"},name:"blue"}}function createTooltips(){jQuery("a[title]").qtip({style:{name:"domstyle",tip:true},position:{corner:{target:"topMiddle",tooltip:"bottomLeft"}}});jQuery("#help_head").qtip({content:"Benutzerhandbuch und Hilfe",position:{corner:{target:"leftMiddle",tooltip:"rightMiddle"}},style:{name:"domstyle"}});jQuery("#options_label").qtip({content:"nicht beachten",position:{corner:{target:"topRight",tooltip:"bottomLeft"}},style:{name:"domstyle"}});jQuery("#stand_label").qtip({content:"nicht beachten",position:{corner:{target:"topRight",tooltip:"bottomLeft"}},style:{name:"domstyle"}});jQuery("#filter_label").qtip({content:"Daten nach einer bestimmten Spalte filtern. Die Spalte, nach der gefiltert werden soll, kannst du in der Auswahlbox rechts neben dem Textfeld auswählen.",hide:{when:"mouseout",fixed:true},show:"mouseover",position:{corner:{target:"topRight",tooltip:"bottomLeft"}},style:{name:"domstyle"}});jQuery("#filter_label").click(function(){jQuery(this).qtip("hide")});jQuery("#filter_label_klassen").qtip({content:"Filtere die Tabelle nach deiner Klasse. Die Eingabe bleibt auch erhalten, wenn du einen neuen Plan wählst oder sogar die Seite neu aufrufst. ",hide:{when:"mouseout",fixed:true},show:"mouseover",position:{corner:{target:"topRight",tooltip:"bottomLeft"}},style:{name:"domstyle"}});jQuery("#filter_label_klassen").click(function(){jQuery(this).qtip("hide")});jQuery("#link_mobile").qtip({content:"Zur mobilen Ansicht wechseln. Diese Ansicht ist für Handys, Smartphones und Subnoteboks optimiert.",hide:{when:"mouseout",fixed:true},show:"mouseover",position:{corner:{target:"topRight",tooltip:"bottomLeft"}},style:{name:"domstyle"}});jQuery("#link_mobile").click(function(){jQuery(this).qtip("hide")});jQuery(".ui-selectmenu-status").qtip({content:"hier kannst du das Geltungsdatum wählen",show:"mouseover",hide:"mouseout",position:{corner:{target:"topMiddle",tooltip:"bottomLeft"}},style:{name:"domstyle"}});jQuery("#expander_options").qtip({content:"Erweiterte Einstellungen und Funktionen. z.B. Filter und ein Link zur mobilen Ansicht",show:"mouseover",hide:"mouseout",position:{corner:{target:"bottomMiddle",tooltip:"topRight"}},style:{name:"domstyle",textAlign:"left",tip:"topRight"}});jQuery("#ui_themeswitcher").qtip({content:"Wähle ein Design aus, das dir gefällt.",show:"mouseover",hide:"mouseout",position:{corner:{target:"topMiddle",tooltip:"bottomRight"}},style:{name:"domstyle",textAlign:"left",tip:"bottomRight"}});jQuery("#jquerytable thead th[title]").qtip({content:{},show:"mouseover",hide:{when:"mouseout",fixed:true},position:{corner:{target:"bottomMiddle",tooltip:"topMiddle"}},style:{name:"domstyle",textAlign:"center",tip:"topMiddle"}});jQuery("#feedy").qtip({content:{text:'Gib dein <strong>Feedback</strong> ab um Fehler zu melden und das Programm zu verbessern!<br><p id="closefeedy" style="cursor: pointer; font-weight: bold; float:right;">schließen</p>'},show:"focus",hide:"click",position:{corner:{target:"bottomMiddle",tooltip:"topMiddle"}},style:{background:"#A00000",color:"#fff",textAlign:"left",padding:5,border:{width:4,radius:5,color:"#A00000"},width:220,tip:"topMiddle","font-size":"small"}});jQuery("#feedy").focus();jQuery("#closefeedy").click(function(){jQuery("#feedy").qtip("hide")});jQuery("#hpvd").qtip({content:"auf meine Website",show:"mouseover",hide:"mouseout",position:{corner:{target:"topLeft",tooltip:"bottomLeft"}},style:{name:"domstyle",textAlign:"left",tip:"bottomMiddle"}});jQuery("#hpvvp").qtip({content:"Zur Projektseite. Hier gibt es den gesamten Code, Anleitungen, Hilfe und das Programmm selber zum Downloaden. ",show:"mouseover",hide:"mouseout",position:{corner:{target:"topMiddle",tooltip:"bottomMiddle"}},style:{name:"domstyle",textAlign:"left",tip:"bottomMiddle"}});jQuery("#up_btn").qtip({content:"nach oben",show:"mouseover",hide:"mouseout",position:{corner:{target:"topLeft",tooltip:"bottomRight"}},style:{width:50,name:"domstyle",tip:"bottomRight"}})}jQuery(document).ready(function(){var counter=0;jQuery("#ui_themeswitcher").themeswitcher({width:200,onSelect:function(){if((notify=="pnotify"||notify=="both")&&counter>0){jQuery.pnotify({pnotify_title:"Design",pnotify_text:"Das Design wurde geändert.<br>"+jQuery("#ui_themeswitcher").text(),pnotify_notice_icon:"ui-icon ui-icon-info",pnotify_type:"notice"});counter=1}},initialText:"Theme wechseln"});jQuery("#ui_themeswitcher").append("");counter=1;jQuery("#select_date_verplan").selectmenu({change:function(){hash=jQuery(this).val();jQuery.historyLoad(hash)}});jQuery("#jquerytable thead th").mouseover(function(){jQuery(this).addClass("ui-state-hover")});jQuery("#jquerytable thead th").mouseout(function(){jQuery(this).removeClass("ui-state-hover")});jQuery("#up_btn, #expander_options").mouseenter(function(){jQuery(this).addClass("ui-state-hover")}).mouseleave(function(){jQuery(this).removeClass("ui-state-hover")})});