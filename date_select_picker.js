$(function() {
  $( ".date_for_alt" ).datepicker({minDate: 0,beforeShowDay: noSatSunday});
  $( "#date_for_alt_2" ).datepicker({minDate: 0,beforeShowDay: noSatSunday});
  $( "#date_for_alt_3" ).datepicker({minDate: 0,beforeShowDay: noSatSunday});
  $( "#date_for_alt_4" ).datepicker({minDate: 0,beforeShowDay: noSatSunday});
  $( "#date_for_alt_5" ).datepicker({minDate: 0,beforeShowDay: noSatSunday});
  $( "#date_for_alt_6" ).datepicker({minDate: 0,beforeShowDay: noSatSunday});
  $( "#date_for_alt_7" ).datepicker({minDate: 0,beforeShowDay: noSatSunday});
  $( "#date_for_alt_8" ).datepicker({minDate: 0,beforeShowDay: noSatSunday});
  $( "#date_for_alt_9" ).datepicker({minDate: 0,beforeShowDay: noSatSunday});
  $( "#date_for_alt_10" ).datepicker({minDate: 0,beforeShowDay: noSatSunday});
});

function noSatSunday(date){ 
          var day = date.getDay(); 
                      return [(day > 1), '']; 
      };