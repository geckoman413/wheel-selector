
$(document).ready(function(){
//  $('#history_table').DataTable({
//      "order": [[ 6, "desc"]]
//  });  
//    $('#outstanding_table').DataTable({
//      "order": [[ 6, "desc"]],
//      "pagination": false
//  });
  

    $( "#slider-range" ).slider({
      range: true,
      min: 0,
      max: 100,
      values: [ 30 , 50],
      slide: function( event, ui ) {
        $( "#amt_tops" ).val(ui.values[ 0 ] + "%");
        hoods_time = ui.values[ 1 ] - ui.values[ 0 ];
        $( "#amt_hoods" ).val(hoods_time + "%");
        drops_time = 100 - (ui.values [ 1 ]);
        $( "#amt_drops" ).val( drops_time + "%");
      }
    });
    $( "#amt_tops" ).val( "$" + $( "#slider-range" ).slider( "values", 0 ));
    $( "#amt_hoods" ).val( "$" + $( "#slider-range" ).slider( "values", 1 ));
    $( "#amt_drops" ).val( "$" + $( "#slider-range" ).slider( "values", 1 ));
   ;

      
})



//var data = JSON.parse(document.getElementById('dom-target').innerHTML);
//data = 
//console.log(data);
//new Morris.Line({
//  element: 'myfirstchart',
//  data: [ data ],
//      xkey: 'time',
//      ykeys: ['value'],
//      labels: ['value']
//});

