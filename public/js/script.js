// Initialize and add the map

$( function() {
    $( ".datepicker" ).datepicker({
        startDate: new Date()
    });
});

$("#datePicker").datepicker({ format: 'dd/mm/yyyy' }).datepicker("setDate", new Date());

$(function () {
    $('[data-toggle="tooltip"]').tooltip()
});