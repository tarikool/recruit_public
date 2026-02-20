$(document).ready(function () {

    "use strict";

    $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});

    // ---------------- Data Table Code  ----------------------->>
    $.fn.dataTable.ext.errMode = 'throw';

    let dataTable = $('#noteTypeDataTable').DataTable({
        serverSide: true,
        ajax: quickRecruitSpace.route,
        searching: true,
        processing: true,
        responsive: true,
        columns: [
            {data: "DT_RowIndex", name: "DT_RowIndex", orderable: false, searchable: false},
            {data: 'name', name: 'name'},
            {data: 'status', name: 'status'},
            {data: 'updated_at', name: 'updated_at'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        "order": [[0, "asc"]]
    });

    $.modalCallBackOnAnyChange = function () {
        dataTable.draw(false);
    }
});
