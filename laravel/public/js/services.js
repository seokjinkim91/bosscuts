$(function(){
    
 $("#employees").change(function () {
    console.log(this.value);
    
    $val=this.value;
     LoadServices($val.substring(0, $val.indexOf('_')));
   
});
    
    
    
$('#editDialog').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget); 
  
  $('#title').val(button.data('title'));
  $('#duration').val(button.data('mins'));
  $('#price').val(button.data('price'));
  $('#type').val(button.data('type'));
  $('#priority').val(button.data('priority'));
  $('#message').val(button.data('desc'));
  $('#serviceid').val(button.data('id'));
  $("#servicetype").val(button.data('servicetype')).change();
//   $("#servicetype option:selected").text(button.data('servicetype'));
});

$('#deleteDialog').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget); 
  
 $('#deleteDialog .modal-body').text(button.data('title'));
 $('#deleteDialog #serviceid').val(button.data('id'));
 
});






});

          //employees
  function LoadEmployees($date){
    
    console.log($date);
        	$.ajax({
                  type: 'GET', 
                  url: 'bookingDate/{date}',
                  data:{date:$date},
                  dataType:'json',
                  success: function(response){
                    // console.log(response);
                     var options = $("#employees");
                     options.empty();
                     
                      $.each(response, function() {
                        options.append(new Option(this.employee+' - '+this.datetime, this.id+'_'+this.datetimeid));
                     });

                  },
                  error: function (XMLHttpRequest, textStatus, errorThrown){
                  //  console.log(errorThrown);
                  },
                  complete:function(data){
                     InitialLoadServices();  
                  }
              });
                
                
   }
   
   
    function InitialLoadEmployees(){
            $date=$("#inlineDatepicker").val();
              if( $date === "" || $date === null) 
              LoadEmployees($.datepick.formatDate('mm/dd/yyyy', new Date()));
            
          }
          
          function InitialLoadServices(){
             $val=$('#employees').val();
             $services = $('#services').val();
             
             if( $services=== null || $services==="")
             LoadServices($val.substring(0, $val.indexOf('_')));
            
            
          }
          
           
           //services offered
           function LoadServices($employeeid){
             
                 $.ajax({
                  type:'GET',
                  url:'bookingServices/{empid}',
                  data:{empid:$employeeid},
                  dataType:'json',
                  success:function(result){
                      
                      console.log($employeeid);
                 console.log('success'+result);
                    
                    var options=$('#services');
                     options.empty();
                     $.each(result, function() {
                          options.append(new Option(this.service, this.service_id));
                     });
                  }
                   
                 });
             
           }
           
           
         

