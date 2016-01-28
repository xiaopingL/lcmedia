$(document).ready(function() {
		gebo_datepicker.init();
	});
	gebo_datepicker = {
    init: function() {
        $('#dp1').datepicker();
        $('#dp2').datepicker();

        $('#dp_start').datepicker({format: "mm/dd/yyyy"}).on('changeDate', function(ev){
            var dateText = $(this).data('date');

            var endDateTextBox = $('#dp_end input');
            if (endDateTextBox.val() != '') {
                var testStartDate = new Date(dateText);
                var testEndDate = new Date(endDateTextBox.val());
                if (testStartDate > testEndDate) {
                    endDateTextBox.val(dateText);
                }
            }
            else {
                endDateTextBox.val(dateText);
            };
            $('#dp_end').datepicker('setStartDate', dateText);
            $('#dp_start').datepicker('hide');
        });
        $('#dp_end').datepicker({format: "mm/dd/yyyy"}).on('changeDate', function(ev){
            var dateText = $(this).data('date');
            var startDateTextBox = $('#dp_start input');
            if (startDateTextBox.val() != '') {
                var testStartDate = new Date(startDateTextBox.val());
                var testEndDate = new Date(dateText);
                if (testStartDate > testEndDate) {
                    startDateTextBox.val(dateText);
                }
            }
            else {
                startDateTextBox.val(dateText);
            };
            $('#dp_start').datepicker('setEndDate', dateText);
            $('#dp_end').datepicker('hide');
        });
        $('#dp_modal').datepicker();
    }
};