jQuery(document).ready(function(){

    jQuery(".note-modal").on("click", function() {
        $('#name').val($(this).data('name'));
        $('#request_id').val($(this).data('request'));
    });

    jQuery("#submit-request-note").on("click", function(event){
        addRequestNote();
        return false;
    });    

    jQuery(".notes-detail").on("click", function(event) {
        let request_id = $(this).data('request');
        getRequestNotes(request_id);
    });   
    

    // codes works on all bootstrap modal windows in application
    jQuery('.modal').on('hidden.bs.modal', function(e)
    { 
        jQuery('.request-note').val('');
        $('#notesTable > tbody').empty();
    }) ;    

    function addRequestNote(){
        jQuery.ajax({
            type: "POST",
            url: addNoteUrl,
            cache:false,
            dataType: "json",
            data: jQuery('form#requestNoteForm').serialize(),
            success: function(response){
                jQuery("#note").modal('hide');
            },
            error: function(jqXHR, textStatus, errorThrown){
                alert('Error: ' + textStatus + ' - ' + errorThrown);
            }
        });
    }

    function getRequestNotes(request_id){
        jQuery.ajax({
            type: "POST",
            url: notesListUrl,
            cache:false,
            dataType: "json",
            data: 'request_id='+request_id,
            success: function(response) {
                let notes = response["notes"];
                for (var i=0; i< notes.length; i++) {
                    var row = $('<tr><td>' + notes[i].comment+ '</td><td>' + notes[i].date + '</td></tr>');
                    $('#notesTable > tbody').append(row);
                }
                $('#notes-list').modal('show');
            },
            error: function(jqXHR, textStatus, errorThrown){
                alert('Error: ' + textStatus + ' - ' + errorThrown);
            }
        });
    }
        
});

