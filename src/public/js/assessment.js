$(function() {

    $("#assessmentContent").load(MINI.ServiceURL.AssessmentURL, {
        account: MINI.Form.Account, 
        patient: MINI.Form.Patient
    });

});


