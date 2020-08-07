jQuery(document).ready(function(){
    jQuery("#makeOnHolidayForm").submit(function(event){
        makeOnHolday();
        return false;
    });

    function makeOnHolday(){
        jQuery.ajax({
            type: "POST",
            url: statusForm
            cache:false,
            data: jQuery('form#makeOnHolidayForm').serialize(),
            success: function(response){
                jQuery("#deactivation").modal('hide');
            },
            error: function(){
                alert("Error");
            }
        });
    }

});

