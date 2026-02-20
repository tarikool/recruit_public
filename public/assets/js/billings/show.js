$(document).ready(function () {

    "use strict"

    $(document).on('click', "#send-email", function () {
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

        const data_route = $(this).data('route');

        axios.post(data_route).then((response) => {
            $.unblockUI();
            console.log(response.data);

            if (response.status == 200) {
                swal(response.data.message, {icon: "success"});
                $('#send-again').slideUp('slow', function () {
                    $('#send-again').text('Send Email Again').slideDown('slow');
                });
            }
        }, (error) => {
            $.unblockUI();
            console.log(error);
        });

    });

});
