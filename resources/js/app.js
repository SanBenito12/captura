import Dropzone from "dropzone";

Dropzone.autoDiscover = false;

const dropzone = new Dropzone('#dropzone', {
    dictDefaultMessage: 'Sube tu imagen',
    acceptedFiles: ".png,.jpg,.jpeg,.gif",
    addRemoveLinks: true,
    dictRemoveFile: 'Borrar Archivo',
    maxFiles: 1,
    uploadMultiple: false,

    init: function() {
        const myDropzone = this;

        // Si hay un valor en el input hidden
        const imagenInput = document.querySelector('[name="imagen"]');
        if(imagenInput.value.trim()) {
            const imagenPublicada = {
                size: 1234,
                name: imagenInput.value
            };

            // Mostrar la imagen predicament subida
            myDropzone.displayExistingFile(imagenPublicada, `/uploads/${imagenInput.value}`);
        }

        // Limpiar dropzone cuando hay errores de validación
        if(document.querySelectorAll('.bg-red-500').length > 0) {
            myDropzone.removeAllFiles();
        }
    }
});

dropzone.on("success", function(file, response) {
    document.querySelector('[name="imagen"]').value = response.imagen;
});

dropzone.on("removedfile", function() {
    document.querySelector('[name="imagen"]').value = '';
});

dropzone.on("error", function(file, message) {
    console.log("Error:", message);
});
