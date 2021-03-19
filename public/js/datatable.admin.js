
function format(d) {
return '<div class="slider">'+
  '<table table-responsive>'+
    '<tr>'+
      '<td>Marca: '+'<span class="badge badge-pill badge-success">'+d.MARCA+'</span>'+
      '<td>Memoria RAM(ranura 01): '+d.RAM0+'</td>'+
      '<td>Memoria RAM(ranura 02): '+d.RAM1+'</td>'+
      '<td>Disco Duro: '+d.HDD+'</td>'+ 
      '<td>S/N monitor: '+d.SERIAL_MONITOR+'</td>'+
      '</td>'+
    '</tr>'+
    '<tr>'+
      '<td>Modelo: '+d.MODELO+''+
      '<td>Disco Duro: '+d.CPU+'</td>'+
      '<td>'+'<img class="img-fluid" width="24px" src="https://cdn.svgporn.com/logos/microsoft-windows.svg" alt="windows">'+'</img>'+' '+d.OS+'</td>'+
      '<td>Ubicación: '+d.UBICACIÓN+'</td>'+
      '<td></td>'+
      '</td>'+
    '</tr>'+
    '<tr>'+
      '<td>Tipo: '+d.TIPO_MAQUINA+
      '<td>Dirección IP: '+d.IP+'</td>'+
      '<td>Direccion MAC: '+d.MAC+'</td>'+
      '<td></td>'+
      '<td></td>'+
      '</td>'+
    '</tr>'+
    '<tr>'+
      '<td>Imagen: '+'<img class="img-fluid" width="160px" src="{{ asset('media/dashboard/photos/M710q.png') }}">'+'</img>'+'</td>'+ 
      '<td></td>'+
      '<td></td>'+
      '<td></td>'+
      '<td></td>'+     
    '</tr>'+
    '</table>'+
  '</div>';
}

$(document).ready(function() {
var dt = $('#example').DataTable( {
"processing": true,
"serverSide": true,
"ajax": "{{ route('admin.pcs.index') }}",
"language": {
"lengthMenu": "Display _MENU_ records per page",
"zeroRecords": "Registro no encontrado",
"info": "Showing page _PAGE_ of _PAGES_",
"infoEmpty": "No records available",
"infoFiltered": "(filtered from _MAX_ total records)",
"search" : "Buscar"
},
"columns": [
{
"class": "details-control",
"orderable": false,
"data": null,
"defaultContent": ""
},
{ "data": "COD_INVENTARIO" },
{ "data": "SERIAL" },
{ "data": "IP" },
{ "data": "MAC" },
{ "data": "ANYDESK" },
{ "data": "F_CREACIÓN" },
{ "data": "SEDE" },
{ "data": "ESTADO" },
{ "data": "action" }
],
"order": [[1, 'asc']]
} );

// Array to track the ids of the details displayed rows
$('#example tbody').on('click', 'td.details-control', function () {
var tr = $(this).closest('tr');
var row = dt.row( tr );

if ( row.child.isShown() ) {
// This row is already open - close it
$('div.slider', row.child()).slideUp( function () {
row.child.hide();
tr.removeClass('shown');
} );
}
else {
// Open this row
row.child( format(row.data()), 'no-padding' ).show();
tr.addClass('shown');

$('div.slider', row.child()).slideDown();
}
} );
} );