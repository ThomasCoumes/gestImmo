/**
 * Created by thocou on 18/04/19.
 */
let pdfField = document.getElementById('property_pdfFile');
let pdfLabel = document.getElementsByClassName('custom-file-label')[0];
let pdfFile = document.getElementsByClassName('pdf-file')[0];

if (pdfFile !== undefined) {
    pdfLabel.classList.add('fontawesome-placeholder');
} else {
    pdfField.onchange = function(e) {
        if (pdfField.value !== '') {
            pdfLabel.classList.add('fontawesome-placeholder');
        } else {
            pdfLabel.classList.remove('fontawesome-placeholder');
        }
    };
}
