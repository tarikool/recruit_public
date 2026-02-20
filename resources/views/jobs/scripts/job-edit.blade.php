<script>
    $(document).ready(function () {
        "use strict";

       // $('input[name="related_file"]').submit();

        const client_selector = $('#client_id');
        const contact_selector = $('#contact_id');
        const clients = {!! $clients !!};
        const selected_client_id = client_selector.val();

        const contacts = [];
        client_selector.on('change', function () {
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

                        contact_selector.empty();
                        contactCollection.unshift({id: "", text: ""});
                        contact_selector.select2({data: contactCollection, placeholder: "Select Contact"});
                        contact_selector.prop("disabled", false);
                    }
                });
            } else {
                contact_selector.empty().prop('disabled', true);
            }
        });
    });

</script>
