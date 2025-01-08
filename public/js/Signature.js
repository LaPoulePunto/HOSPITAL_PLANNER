document.addEventListener('DOMContentLoaded', function () {
    const canvas = document.querySelector('#signatureCanvas');
    const signaturePad = new SignaturePad(canvas);
    const form = document.querySelector('form');
    canvas.width = canvas.offsetWidth;
    canvas.height = canvas.offsetHeight;
    form.addEventListener('submit', function (event) {
        const signatureField = document.getElementById('signatureField');
        signatureField.value = signaturePad.toDataURL('image/png');
    });
});