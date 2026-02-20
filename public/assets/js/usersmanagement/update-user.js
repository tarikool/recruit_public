$(document).ready(function () {
    "use strict";
    let number_div = $("#number_div");
    number_div.hide();

    let role = $("#role");
    let number = $("#number");
    let candidateRoleId = number.data('candidate-role-id');

    toggleUserPhoneNumber(role.val(),candidateRoleId)
    role.on('change',function () {
        let selectedRoleId = role.val();
        toggleUserPhoneNumber(selectedRoleId,candidateRoleId)
    });

    function toggleUserPhoneNumber(selectedRoleId,candidateRoleId) {
        if (selectedRoleId == candidateRoleId){
            number_div.fadeIn('slow').show();
        }
        else if(selectedRoleId!=candidateRoleId && number_div.is(':visible')){
            number_div.fadeOut('slow').hide();
        }
    }
});
