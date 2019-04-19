/**
 * Created by thocou on 18/04/19.
 */
let pdfField = document.getElementById('property_pdfFile');
let pdfLabel = document.getElementsByClassName('custom-file-label')[0];

pdfField.onchange=function(e) {
    pdfLabel.classList.add('fontawesome-placeholder');
};
