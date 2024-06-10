$(function () {
    // $.fn.dataTable.ext.errMode = 'throw';
    let table = $('.datatableProduct').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route("list_product") }}',
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'code', name: 'code'},
            {data: 'name', name: 'name'},
            {data: 'category_id', name: 'category_id'},
            {data: 'quantity', name: 'quantity'},
            {data: 'price', name: 'price'},
            {
                data: 'action', 
                name: 'action', 
                orderable: true, 
                searchable: true
            },
        ]
    });
    
  });