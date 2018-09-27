$(function(){
$('#editDialog').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget); 
  
  $('#title').val(button.data('title'));
  $('#duration').val(button.data('mins'));
  $('#price').val(button.data('price'));
  $('#type').val(button.data('type'));
//   $('#priority').val(button.data('priority'));
  $('#message').val(button.data('desc'));
  $('#serviceid').val(button.data('id'));

});

$('#deleteDialog').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget); 
  
 $('#deleteDialog .modal-body').text(button.data('title'));
 $('#deleteDialog #serviceid').val(button.data('id'));
 
});






});


