<script>
    $(document).ready(function () {
        "use strict";

        const client_selector = $('#client_id');
        const contact_selector = $('#contact_id');
        const job_billing_address_selector = $("#job_billing_address")

        const clients = {!! $clients !!};
        contact_selector.empty().prop("disabled", true);

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

                        // Set Job Billing Address According to Client Billing Address
                        $("#street").val(item.billing_street);
                        $("#city").val(item.billing_city);
                        $("#code").val(item.billing_code);
                        $("#state").val(item.billing_state);
                        $("#country_id").val(item.billing_country_id).trigger("change");
                    }
                });
            } else {
                contact_selector.empty().prop('disabled', true);
            }
        });
    });
</script>
