<script>
    $(document).ready(function () {
        "use strict";

        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});

        // ---------------- Data Table Code  ----------------------->>
        $.fn.dataTable.ext.errMode = 'throw';

        let taskDataTable = $('#jobsDataTable').DataTable({
            serverSide: true,
            ajax: "{{ route('jobs.index') }}",
            searching: true,
            processing: true,
            responsive: true,
            columns: [
                {data: "DT_RowIndex", name: "DT_RowIndex", orderable: false, searchable: false},
                {data: 'job_title', name: 'job_title'},
                {data: 'opening_status', name: 'opening_status'},
                {data: 'client', name: 'client'},
                {data: 'city', name: 'city'},
                {data: 'last_apply_date', name: 'last_apply_date'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
            "order": [[0, "asc"]]
        });

        $.modalCallBackOnAnyChange = function () {
            taskDataTable.draw(false);
        }
        // ---------------- Data Table Code  -----------------------||

        $('body').on('shown.bs.modal', '.modal', function () {
            const create_client_selector = $('.client_id_create');
            const edit_client_selector = $('.client_id_edit');
            const create_contact_selector = $('.contact_id_create');
            const edit_contact_selector = $('.contact_id_edit');

            const clients = {!! $clients !!};

            create_client_selector.select2();
            edit_client_selector.select2();

            create_contact_selector.select2().prop("disabled", true);
            edit_contact_selector.select2();

            const contacts = [];
            create_client_selector.on('change', function () {
                let changedClientVal = $(this).val();
                let clientCollection = collect(clients)
                if (changedClientVal) {
                    clientCollection.map(function (item) {
                        if (item.id == changedClientVal) {
                            let contactsData = item.contacts;

                            let contactCollection = collect(contactsData).map((contact) => {
                                let contactFullName = contact.first_name + " " + contact.last_name;
                                return {id: contact.id, text: contactFullName}
                            }).all();

                            create_contact_selector.empty();
                            contactCollection.unshift({id: "", text: ""});
                            create_contact_selector.select2({
                                data: contactCollection,
                                placeholder: "Select Contact"
                            });
                            create_contact_selector.prop("disabled", false);
                        }
                    });
                } else {
                    create_contact_selector.prop('disabled', true);
                }
            });

            edit_client_selector.on('change', function () {
                let changedClientVal = $(this).val();
                let clientCollection = collect(clients)
                if (changedClientVal) {
                    clientCollection.map(function (item) {
                        if (item.id == changedClientVal) {
                            let contactsData = item.contacts;

                            let contactCollection = collect(contactsData).map((contact) => {
                                let contactFullName = contact.first_name + " " + contact.last_name;
                                return {id: contact.id, text: contactFullName}
                            }).all();

                            edit_contact_selector.empty();
                            contactCollection.unshift({id: "", text: ""});
                            edit_contact_selector.select2({data: contactCollection, placeholder: "Select Contact"});
                            edit_contact_selector.prop("disabled", false);
                        }
                    });
                } else {
                    edit_contact_selector.prop('disabled', true);
                }
            });
        });
    });
</script>
