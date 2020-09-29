jQuery(document).ready(function () {

    jQuery(".open-modal").on("click", function () {
        
        var start_time = $(this).data('time');
        $('#start_time').val(start_time);

        var student = $(this).data('student');
        if (student) {
            var student_select = $('#student');
            student_select.val(student);
            student_select.change();
            student_select.attr('disabled', 'disabled');            
            // select course
            $('#student-course').val($(this).data('course'));
            $('#student-course').attr('disabled', 'disabled');
            // set schedule id
            $('.schedule_id').val($(this).data('schedule-id'));
            $('.student_id').val(student);
            $('.form-actions').show();
        }

        var end_time = $(this).data('time-end');
        if (end_time == null) {
            end_time = timeToSeconds(start_time) + (30 * 60);
            end_time = convertSecondstoTime(end_time);
        }
        $('#end_time').val(end_time);

        var day = $(this).data('day');
        $('#dayCheckbox' + day).attr('checked', true);



        setTimeout(function() {
            $('#schedule-modal').modal();
        }, 1100);
    });

    // codes works on all bootstrap modal windows in application
    jQuery('.modal').on('hidden.bs.modal', function (e) {
        $('.form-check-input').attr('checked', false);
        $('form')[0].reset();
        $('.form-actions').hide();
        $('#student').attr('disabled', '');
        $('#student-course').attr('disabled', '');

    });

    jQuery("#submit-schedule").on("click", function (event) {
        addSchedule();
        return false;
    });

    jQuery("#student").on("change", function (event) {
        getStudentCourses();
    });

    function timeToSeconds(time) {
        time = time.split(':');
        return time[0] * 3600 + time[1] * 60;
    }

    function convertSecondstoTime(given_seconds) {

        dateObj = new Date(given_seconds * 1000);
        hours = dateObj.getUTCHours();
        minutes = dateObj.getUTCMinutes();
        seconds = dateObj.getSeconds();

        timeString = hours.toString().padStart(2, '0')
            + ':' + minutes.toString().padStart(2, '0');

        return timeString;
    }

    function getStudentCourses() {
        jQuery.ajax({
            type: "POST",
            url: getStudentCoursesUrl,
            cache: false,
            dataType: "json",
            data: "student_id=" + jQuery('#student').val(),
            success: function (response) {
                var $select = $('#student-course');
                $select.find('option').remove();
                $.each(response.courses, function (key, value) {
                    $('<option>').val(value.key).text(value.value).appendTo($select);
                });
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert('Error: ' + textStatus + ' - ' + errorThrown);
            }
        });
    }

    function addSchedule() {
        jQuery.ajax({
            type: "POST",
            url: addScheduleUrl,
            cache: false,
            dataType: "json",
            data: jQuery('form#schedule-form').serialize(),
            success: function (response) {
                $('form')[0].reset();
                jQuery("#schedule-modal").modal('hide');
                location.reload();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert('Error: ' + textStatus + ' - ' + errorThrown);
            }
        });
    }

});

