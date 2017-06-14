/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function () {
    updatePsw();
});

function updatePsw(){
    $('#passwordUpdate').click(function(){
        var url = 'updatePsw';
        var formId = 'updatePasswordForm';
        var infoId = 'form_password_update';
        formRequest(url, formId, infoId);
    });
}

