jQuery(document).ready(function(){

    jQuery("#employee-category").on("change", function (event) {
        getEmployeeByCategory();
    });    


    function getEmployeeByCategory() {
        jQuery.ajax({
            type: "POST",
            url: getEmployeesByCategoryUrl,
            cache: false,
            dataType: "json",
            data: "category_id=" + jQuery('#employee-category').val(),
            success: function (response) {
                var $select = $('#employees');
                $select.find('option').remove();
                $.each(response.employees, function (key, value) {
                    $('<option>').val(value.key).text(value.value).appendTo($select);
                });
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert('Error: ' + textStatus + ' - ' + errorThrown);
            }
        });
    }    

});

