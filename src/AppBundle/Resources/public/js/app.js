/**
 * Created by matias on 21/6/16.
 */
$(document).ready(function () {
    
    // combo
    $('#new-combo-form').on('submit', function (e) {
        if ($('.new-combo #combo_porcentaje').val() !== '' &&
            $('.new-combo #combo_precio').val() !== '') {
            alert('Porcentaje y Precio son excluyentes');
            e.preventDefault();
        }
        if ($('.new-combo #combo_porcentaje').val() > 100) {
            alert('El porcentaje no puede ser mayor a 100');
            e.preventDefault();
        }

    });
    
    $('#edit-combo-form').on('submit', function (e) {
        if ($('.edit-combo #combo_porcentaje').val() !== '' &&
            $('.edit-combo #combo_precio').val() !== '') {
            alert('Porcentaje y Precio son excluyentes');
            e.preventDefault();
        }
        if ($('.edit-combo #combo_porcentaje').val() > 100) {
            alert('El porcentaje no puede ser mayor a 100');
            e.preventDefault();
        }

    });
});