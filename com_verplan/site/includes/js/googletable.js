var visualization;
    var data;
 
    var options = {'showRowNumber': true};
    function drawVisualization() {
      // Create and populate the data table.
      var dataAsJson =
      {cols:[
        {id:'A',label:'Name',type:'string'},
        {id:'B',label:'Height',type:'number'},
        {id:'C',label:'Coming',type:'boolean'},
        {id:'D',label:'Time',type:'timeofday'}],
      rows:[
        {c:[{v:'Dave'},{v:159.0,f:'159'},{v:true,f:'TRUE'},{v:[12,25,0,0],f:'12:25:00'}]},
      {c:[{v:'Peter'},{v:185.0,f:'185'},{v:false,f:'FALSE'},{v:[13,15,0,0],f:'13:15:00'}]},
      {c:[{v:'John'},{v:145.0,f:'145'},{v:true,f:'TRUE'},{v:[15,45,0,0],f:'15:45:00'}]},
      {c:[{v:'Moshes'},{v:198.0,f:'198'},{v:true,f:'TRUE'},{v:[16,32,0,0],f:'16:32:00'}]},
      {c:[{v:'Karen'},{v:169.0,f:'169'},{v:true,f:'TRUE'},{v:[19,50,0,0],f:'19:50:00'}]},
      {c:[{v:'Phil'},{v:169.0,f:'169'},{v:false,f:'FALSE'},{v:[18,10,0,0],f:'18:10:00'}]},
      {c:[{v:'Gori'},{v:159.0,f:'159'},{v:true,f:'TRUE'},{v:[13,15,0,0],f:'13:15:00'}]},
      {c:[{v:'Bill'},{v:155.0,f:'155'},{v:false,f:'FALSE'},{v:[7,40,48,0],f:'7:40:48'}]},
      {c:[{v:'Valery'},{v:199.0,f:'199'},{v:true,f:'TRUE'},{v:[6,0,0,0],f:'6:00:00'}]},
      {c:[{v:'Joey'},{v:187.0,f:'187'},{v:true,f:'TRUE'},{v:[5,2,24,0],f:'5:02:24'}]},
      {c:[{v:'Karen'},{v:190.0,f:'190'},{v:true,f:'TRUE'},{v:[6,14,24,0],f:'6:14:24'}]},
      {c:[{v:'Jin'},{v:169.0,f:'169'},{v:false,f:'FALSE'},{v:[5,45,36,0],f:'5:45:36'}]},
      {c:[{v:'Gili'},{v:178.0,f:'178'},{v:true,f:'TRUE'},{v:[6,43,12,0],f:'6:43:12'}]},
      {c:[{v:'Harry'},{v:172.0,f:'172'},{v:false,f:'FALSE'},{v:[6,14,24,0],f:'6:14:24'}]},
      {c:[{v:'Handerson'},{v:175.0,f:'175'},{v:true,f:'TRUE'},{v:[6,57,36,0],f:'6:57:36'}]},
      {c:[{v:'Vornoy'},{v:170.0,f:'170'},{v:true,f:'TRUE'},{v:[13,12,0,0],f:'13:12:00'}]}]};
      data = new google.visualization.DataTable(dataAsJson);
      
      //new data
      /*      data.setCell(0, 0, 'Mike');
            data.setCell(0, 1, 10000, '$10,000');
            data.setCell(0, 2, true);
          
            data.setCell(1, 0, 'Jim');     
            data.setCell(1, 1, 8000, '$8,000');
            data.setCell(1, 2, false);*/
    
          
          // Set the width and height options using the UI controls.
          options['width'] = null;
          options['height'] = null;
          options['alternatingRowStyle'] = true;
          options['sortColumn'] = null;
          options['allowHtml'] = true;
          options['width'] = '100%';
          options['resizable'] = true;
          
          //formatter
          var formatter = new google.visualization.BarFormat({width: 120});  
          formatter.format(data, 1); // Apply formatter to second column    
      
      // Create and draw the visualization.
      visualization = new google.visualization.Table(document.getElementById('ajaxtable'));
      draw();
    }
    
    function draw() {
      visualization.draw(data, options);  
    }
    
 
    google.setOnLoadCallback(drawVisualization);
 
    // sets the width/height of the table
    function setDimension(dimension, value) {
      if (value) {
        options[dimension] = value;
      } else {
        options[dimension] = null;
      }
      draw();
    }