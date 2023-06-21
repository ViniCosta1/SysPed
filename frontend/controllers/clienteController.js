$(document).ready(function () {
    $('.btn-new').click(function (e) { 
        e.preventDefault();
        $('#modal-cliente').modal('show');
    });
    
    $('#table-cliente').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "../../api/model/controllerCliente.php?operacao=list",
            "type": "POST"
        },
        "language": {
            "url": "../../sistema/assets/vendor/DataTables/pt_br.json"
        },
        "order": [
            [0, "desc"]
        ],
        "columns": [{
                "data": 'ID',
                "className": 'text-center'
            },
            {
                "data": 'NOME_RAZAO',
                "className": 'text-left'
            },
            {
                "data": 'TELEFONE',
                "className": 'text-center'
            },
            {
                "data": 'CELULAR',
                "className": 'text-center'
            },
            {
                "data": 'ID',
                "orderable": false,
                "searchable": false,
                "className": 'text-center',
                "render": function(data, type, row, meta) {
                    return `
                    <button id="${data}" class="btn btn-info btn-sm btn-view"><i class="bi bi-eye-fill"></i></button>
                    <button id="${data}" class="btn btn-primary btn-sm btn-edit"><i class="bi bi-pen-fill"></i></button>
                    <button id="${data}" class="btn btn-danger btn-sm btn-delete"><i class="bi bi-trash3-fill"></i></button>
                    `
                }
            }
        ]
    })
});