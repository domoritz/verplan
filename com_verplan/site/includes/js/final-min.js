var filterKlasse=jQuery.cookie("Klasse");if(filterKlasse==null){filterKlasse="";}var myInterval;function iniFilters(){jQuery("#filter_input").clearableTextField();jQuery("#filter_input").keyup(function(){jQuery("#klasse").val("");removeCookie();filterTable();});jQuery("#filter_this").change(function(){console.log("filter_this change");jQuery("#klasse").val("");removeCookie();jQuery("#filter_input").val(null).change();filterTable();});jQuery("#klasse").change(function(){console.log("klasse change "+this.value);if(this.value==""){jQuery("#filter_this").val("");removeCookie();}else{jQuery("#filter_this").val(getColname());jQuery.cookie("Klasse",this.value,{expires:7});filterKlasse=this.value;console.log("cookie gespeichert: "+this.value);}jQuery("#filter_input").val(this.value).change();filterTable();});}function filterTable(){var b=jQuery("#filter_this").val();var a=jQuery("#filter_input").val();console.log("Filter: "+b+" "+a);jQuery.uiTableFilter(jQuery("#jquerytable"),a,b);hideHint(0);}function removeCookie(){jQuery.cookie("Klasse",null);filterKlasse="";console.log("cookie gel??scht");}function updateFilters(){console.log("updateFilters");jQuery("#klasse").val(filterKlasse);if(filterKlasse==""){}else{jQuery("#filter_this").val(getColname());jQuery("#filter_input").val(filterKlasse);}jQuery("#filter_input").change();var b=jQuery("#filter_this").val();var a=jQuery("#filter_input").val();jQuery.uiTableFilter(jQuery("#jquerytable"),a,b);if(jQuery("#filter_input").val()!=""){clearInterval(myInterval);console.log("start listener");myInterval=setInterval(function(){console.log("wait for hint");if(hintshown==false){clearInterval(myInterval);hintshown==true;setTimeout("showHint('Es werden Spalten ausgeblendet, weil ein Filter aktiv ist', 'warn', '420px', 'filty');",500);}},100);}}function clickOnClear(){jQuery("#klasse").val("").change();}jQuery(document).ready(function(){if(jQuery.cookie("show_advanced_layer")=="true"){toggleStuff();}else{jQuery("#options_panel").hide("");jQuery.cookie("show_advanced_layer",null);}jQuery("#expander_options:not(.ui-state-active)").click(function(){jQuery("#options_panel").slideToggle(600);toggleStuff();jQuery.cookie("show_advanced_layer","true",{expires:7});});jQuery("#expander_options.ui-state-active").click(function(){jQuery("#options_panel").slideToggle(600);toggleStuff();jQuery.cookie("show_advanced_layer",null);});});function toggleStuff(){jQuery("#icon_options").toggleClass("ui-icon-circle-plus").toggleClass("ui-icon-circle-minus");jQuery("#expander_options").toggleClass("ui-state-default");jQuery("#expander_options").toggleClass("ui-state-active");}jQuery(document).ready(function(){jQuery("a[rel^='prettyPhoto']").prettyPhoto();});var debugging=getDebug();if(typeof console=="undefined"){var console={log:function(){},time:function(){},timeEnd:function(){}};}else{if(!debugging||typeof console.log=="undefined"){console.log=function(){};console.time=function(){};console.timeEnd=function(){};}}var hash;jQuery(document).ready(function(){rooturl=getURL();hash=getHash();table_init();jQuery("#logo_verplan").click(function(){window.location.hash="";window.location.href=window.location.href.slice(0,-1);});if(!hash){hash=jQuery("#select_date_verplan").val();setHash(hash);}jQuery.history.init(initverplan);});function initverplan(b){clearInterval(myInterval);clearInterval(myInterval2);jQuery("#select_date_verplan option").attr("selected","");jQuery("#select_date_verplan option[value='"+b+"']").attr("selected","selected");var a=document.getElementById("select_date_verplan").selectedIndex;jQuery("#select_date_verplan").selectmenu("value",a);ajax_stand=jQuery("#verplan_form [name=stand]").val();ajax_options=jQuery("#verplan_form [name=options]").val();getAndUseJSON(b,ajax_stand,ajax_options);}function gup(b){b=b.replace(/[\[]/,"\\[").replace(/[\]]/,"\\]");var a="[\\?&]"+b+"=([^&#]*)";var d=new RegExp(a);var c=d.exec(window.location.href);if(c==null){return false;}else{return c[1];}}jQuery.fn.pause=function(a){return this.queue(function(){var b=this;setTimeout(function(){return jQuery(b).dequeue();},a);});};function getHash(){var a=window.location.hash.substr(1,document.location.hash.length);console.log("hash: "+a);return a;}function setHash(a){hash=a;window.location.hash=hash;console.log("setHash "+hash+" | "+window.location.hash);return window.location.hash;}jQuery.fn.chain=function(c){var d=this;var b=0;function a(){if(d.eq(b)){c.apply(d.eq(b),[a]);}b++;}a();};var hintshown=false;function showHint(d,c,b,a){hintshown=true;console.log("hintshown");if(!b){b="400px";}if(c=="warn"){d='<span class="icon_verplan icon_warn">&nbsp;</span><strong>Achtung:</strong> '+d;}if(c=="info"){d='<span class="icon_verplan icon_info">&nbsp;</span><strong>Info:</strong> '+d;}if(c=="critical"){d='<span class="icon_verplan icon_critical">&nbsp;</span><strong style="color: red; ">Kritischer Fehler:</strong> '+d;}jQuery("#notify #text").html(d).parent().css("width",b).css("left",0).attr("name",a).show("slide",{direction:"right"},500);console.log(c+" "+d+" "+b+" "+a);}function hideHint(a){if(hintshown==true){jQuery("#notify:visible").stop().pause(a).hide("slide",{direction:"right"},1000,function(){console.log("hinthidden");hintshown=false;});}}var speed=500;var effects=true;var effects_indi=true;function hideNoDB(){if(jQuery("#no_db").css("display")!="none"){if(effects){jQuery("#no_db").hide("blind",speed);}else{jQuery("#no_db").hide();}}}function showNoDB(){if(effects){jQuery("#no_db").show("blind",speed);}else{jQuery("#no_db").show();}}function showIndicator(){if(effects_indi){jQuery("#loading").fadeIn("fast");showHint("Lade Daten...","info","250px","loady");}}function hideIndicator(){if(effects_indi){jQuery("#loading").pause(500).fadeOut(1000);hideHint(1500);}}function showTable(){if(effects){jQuery("#jquerytable tbody").fadeIn(speed);jQuery("#miniindi").hide();}}function hideTable(){if(effects){jQuery("#jquerytable tbody").fadeOut(speed,ajaxCall);jQuery("#miniindi").show();}}function ajaxcomplete(){jQuery("#miniindi").hide();}function show_hint(a,b){jQuery("#hint_table div").html('<p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: 0.3em; margin-top: 0.3em;"></span><p><strong>'+a+"</strong><br>"+b+"</p></p>");jQuery("#hint_table").show("blind","slow");}jQuery(document).ready(function(){jQuery("#ui_themeswitcher").themeswitcher({width:200,onSelect:function(){},onOpen:function(){},onClose:function(){},initialText:"Theme wechseln"});jQuery("#ui_themeswitcher").append("");jQuery("#select_date_verplan").selectmenu({change:function(){hash=jQuery(this).val();console.log("Wert aus select: "+hash);jQuery.history.load(hash);}});jQuery("#jquerytable thead th").mouseover(function(){jQuery(this).addClass("ui-state-hover");});jQuery("#jquerytable thead th").mouseout(function(){jQuery(this).removeClass("ui-state-hover");});jQuery("#up_btn, #expander_options").mouseenter(function(){jQuery(this).addClass("ui-state-hover");}).mouseleave(function(){jQuery(this).removeClass("ui-state-hover");});});var style="";function updateTooltipStyle(){var a=jQuery.cookie("jquery-ui-theme");console.log("jQuery UI theme: "+a);switch(a){case"UI darkness":style="own";break;case"UI lightness":style="dark";break;case"Start":style="dark";break;default:style="own";break;}console.log("Tooltipstyle: "+style);}jQuery(document).ready(function(){updateTooltipStyle();defaultStyle();createTooltips();});function defaultStyle(){jQuery.fn.qtip.styles.domstyle={tip:{corner:true,background:null},"font-size":"small",border:{width:5,radius:3},name:style};jQuery.fn.qtip.styles.own={color:"#000",background:"#DCEDFF",border:{color:"#59B4D4"},name:"blue"};}function createTooltips(){jQuery("a[title]").qtip({style:{name:"domstyle",tip:true},position:{corner:{target:"topMiddle",tooltip:"bottomLeft"}}});jQuery("#help_head").qtip({content:"Benutzerhandbuch und Hilfe",position:{corner:{target:"leftMiddle",tooltip:"rightMiddle"}},style:{name:"domstyle"}});jQuery("#options_label").qtip({content:"nicht beachten",position:{corner:{target:"topRight",tooltip:"bottomLeft"}},style:{name:"domstyle"}});jQuery("#stand_label").qtip({content:"nicht beachten",position:{corner:{target:"topRight",tooltip:"bottomLeft"}},style:{name:"domstyle"}});jQuery("#filter_label").qtip({content:"Daten nach einer bestimmten Spalte filtern. Die Spalte, nach der gefiltert werden soll, kannst du in der Auswahlbox rechts neben dem Textfeld ausw??hlen.",hide:{when:"mouseout",fixed:true},show:"mouseover",position:{corner:{target:"topRight",tooltip:"bottomLeft"}},style:{name:"domstyle"}});jQuery("#filter_label").click(function(){jQuery(this).qtip("hide");});jQuery("#filter_label_klassen").qtip({content:"Filtere die Tabelle nach deiner Klasse. Die Eingabe bleibt auch erhalten, wenn du einen neuen Plan w??hlst oder sogar die Seite neu aufrufst. ",hide:{when:"mouseout",fixed:true},show:"mouseover",position:{corner:{target:"topRight",tooltip:"bottomLeft"}},style:{name:"domstyle"}});jQuery("#filter_label_klassen").click(function(){jQuery(this).qtip("hide");});jQuery("#link_mobile").qtip({content:"Zur mobilen Ansicht wechseln. Diese Ansicht ist f??r Handys, Smartphones und Subnoteboks optimiert.",hide:{when:"mouseout",fixed:true},show:"mouseover",position:{corner:{target:"topRight",tooltip:"bottomLeft"}},style:{name:"domstyle"}});jQuery("#link_mobile").click(function(){jQuery(this).qtip("hide");});jQuery(".ui-selectmenu-status").qtip({content:"Geltungsdatum w??hlen",show:"mouseover",hide:"mouseout",position:{corner:{target:"topMiddle",tooltip:"bottomLeft"}},style:{name:"domstyle"}});jQuery("#expander_options").qtip({content:"Erweiterte Einstellungen und Funktionen. z.B. Filter",show:"mouseover",hide:"mouseout",position:{corner:{target:"bottomMiddle",tooltip:"topRight"}},style:{name:"domstyle",textAlign:"left",tip:"topRight"}});jQuery("#ui_themeswitcher").qtip({content:"W??hle ein Design aus, das dir gef??llt.",show:"mouseover",hide:"mouseout",position:{corner:{target:"topMiddle",tooltip:"bottomRight"}},style:{name:"domstyle",textAlign:"left",tip:"bottomRight"}});jQuery("#jquerytable thead th[title]").qtip({content:{},show:"mouseover",hide:{when:"mouseout",fixed:true},position:{corner:{target:"bottomMiddle",tooltip:"topMiddle"}},style:{name:"domstyle",textAlign:"center",tip:"topMiddle"}});jQuery("#feedy").qtip({content:{text:'Hey, du benutzt eine <strong>Vorabversion</strong>. Damit Fehler behoben werden und das Programm verbessert wird, gib bitte dein <strong>Feedback</strong> ab. Jedes einzelne ist wichtig f??r mich. <br>Vielen Dank und viel Spa??<br><p id="closefeedy" style="cursor: pointer; font-weight: bold; float:right;">schlie??en</p> '},show:"focus",hide:"click",position:{corner:{target:"bottomMiddle",tooltip:"topMiddle"}},style:{background:"#A00000",color:"#fff",textAlign:"left",padding:5,border:{width:4,radius:5,color:"#A00000"},width:220,tip:"topMiddle","font-size":"small"}});jQuery("#feedy").focus();jQuery("#closefeedy").click(function(){jQuery("#feedy").qtip("hide");});jQuery("#hpvd").qtip({content:"auf meine Website",show:"mouseover",hide:"mouseout",position:{corner:{target:"topLeft",tooltip:"bottomLeft"}},style:{name:"domstyle",textAlign:"left",tip:"bottomMiddle"}});jQuery("#hpvvp").qtip({content:"Zur Projektseite. Hier gibt es den gesamten Code, Anleitungen, Hilfe und das Programmm selber zum Downloaden. ",show:"mouseover",hide:"mouseout",position:{corner:{target:"topMiddle",tooltip:"bottomMiddle"}},style:{name:"domstyle",textAlign:"left",tip:"bottomMiddle"}});jQuery("#up_btn").qtip({content:"nach oben",show:"mouseover",hide:"mouseout",position:{corner:{target:"topLeft",tooltip:"bottomRight"}},style:{width:50,name:"domstyle",tip:"bottomRight"}});}