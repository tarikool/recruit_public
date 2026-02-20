<script>
    $(document).ready(function () {
        "use strict"

        let copyButton = new Clipboard('#copy-button');
        copyButton.on('success', function (e) {
            swal({
                title: "Job Details Page URL Copied",
                text: $('#copy-button').data('clipboard-text'),
                icon: "success"
            });
        });

        let candidateStatusSelect = $('.candidate_status_select2');
        let selectedVal = candidateStatusSelect.val();
        let job
        // Initiate Select2 on Candidate Status
        candidateStatusSelect.select2({ dropdownAutoWidth: true, width: 'auto' });

        // Candidate Status on change event
        candidateStatusSelect.on("select2:select", function (e) {

            swal({
                title: "Are you sure?",
                text: "Candidate Status Will Be Updated",
                icon: "warning",
                dangerMode: true,
                buttons: true,
            }).then(willUpdate => {
                if (willUpdate) {
                    let dataRoute = $(this).data('route');
                    let candidateId = $(this).data('candidate-id');
                    let candidateStatusId = $(this).val();
                    updateCandidateStatus(dataRoute, candidateId, candidateStatusId)
                } else {
                    candidateStatusSelect.val(selectedVal).trigger('change')
                }
            });

        });

        function updateCandidateStatus(dataRoute, candidateId, candidateStatusId) {
            let jobId = "{{ $job->id }}";
            let _token = "{{ csrf_token() }}";


            $.blockUI({
                css: {
                    border: 'none',
                    padding: '15px',
                    backgroundColor: '#000',
                    '-webkit-border-radius': '10px',
                    '-moz-border-radius': '10px',
                    opacity: .5,
                    color: '#fff'
                }
            });

            // console.log(dataRoute,"candidateId : "+candidateId,"jobId : "+jobId,"candidateStatusId : "+candidateStatusId)
            axios.post(dataRoute, {
                _token: _token,
                job_id: jobId,
                candidate_id: candidateId,
                candidate_status_id: candidateStatusId
            }).then((response) => {
                    $.unblockUI();
                    if (response.data.code === 200) {
                        iziToast.success({
                            title: "Success",
                            message: response.data.message,
                            position: "topRight",
                        });
                    }
                }, (error) => {
                    $.unblockUI();
                    console.log(error);
                }
            )
        }
    });
</script>

