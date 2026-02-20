<script>
    $(document).ready(function () {

        "use strict"
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});

        // ---------------- Data Table Code  ----------------------->>
        $.fn.dataTable.ext.errMode = 'throw';

        let candidatesDataTable = $('#candidatesDataTable').DataTable({
            serverSide: true,
            ajax: "{{ route('candidates.index') }}",
            searching: true,
            processing: true,
            responsive: true,
            columns: [
                {data: "DT_RowIndex", name: "DT_RowIndex", orderable: false, searchable: false},
                {data: 'full_name', name: 'full_name'},
                {data: 'city', name: 'city'},
                {data: 'number', name: 'number'},
                {data: 'candidate_source', name: 'candidate_source'},
                {data: 'resume', name: 'resume'},
                {data: 'skillset_trim', name: 'skillset'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
            "order": [[0, "asc"]]
        });

        $.modalCallBackOnAnyChange = function () {
            candidatesDataTable.draw(false);
        }
        // ---------------- Data Table Code  -----------------------||
    });

</script>
