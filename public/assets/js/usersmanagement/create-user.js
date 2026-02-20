$(document).ready(function () {

    "use strict";

    let number_div = $("#number_div");
    let role = $("#role");
    let number = $("#number");
    let candidateRoleId = number.data('candidate-role-id');

    number_div.hide();
    role.on('change',function () {
        let selectedRoleId = role.val();
        if (selectedRoleId == candidateRoleId){
            number_div.fadeIn('slow').show();
        }
        else if(selectedRoleId!=candidateRoleId && number_div.is(':visible')){
            number_div.fadeOut('slow').hide();
        }
    });
});
