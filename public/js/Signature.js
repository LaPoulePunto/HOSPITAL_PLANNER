document.addEventListener('DOMContentLoaded', function () {
    const canvas = document.querySelector('#signatureCanvas');
    const signaturePad = new SignaturePad(canvas);
    const form = document.querySelector('form');
    form.addEventListener('submit', function (event) {
        const signatureField = document.getElementById('signatureField');
        signatureField.value = signaturePad.toDataURL('image/png');
    });
});