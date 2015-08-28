$(document).ready(function() {
/**  Simple image gallery. Uses default settings*/
$('.fancybox').fancybox();

/**  Different effects */
});

$(function() {
var all_exist_date       = $("#all_exist_date").val();
var split_element        = all_exist_date.split(","); 
var disabledSpecificDays = [split_element[0],split_element[1],split_element[2],split_element[3],split_element[4],split_element[5],split_element[6],split_element[7],split_element[8],split_element[8],split_element[9],split_element[10],split_element[11],split_element[12],split_element[13],split_element[14],split_element[15],split_element[16],split_element[17],split_element[18],split_element[19]];

function disableSpecificDaysAndWeekends(date) {
var m = date.getMonth();
var d = date.getDate();
var y = date.getFullYear();

for (var i = 0; i < disabledSpecificDays.length; i++) {
if ($.inArray((m + 1) + '-' + d + '-' + y, disabledSpecificDays) != -1 ) {
return [false];
}
}

var noWeekend = $.datepicker.noWeekends(date);
return !noWeekend[0] ? noWeekend : [true];
}
$( "#date_off" ).datepicker({minDate: 0,
dateFormat: 'm/d/yy',
inline: true,
dayNamesMin: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
beforeShowDay: disableSpecificDaysAndWeekends});
});

function set_off_days()
{
var date_off = $("#date_off").val();
if(date_off != ''){                   
    $.ajax
    ({
        type: "POST",
        url: "days_off_set.php",
        data: "off_day_insert=" + date_off,
        beforeSend: loadStart,
        complete: loadStop,
        success: function(option)
            {
                if(option != ''){
                    var all_offdate_list = option.split("~"); 
                    $('#days_off_succ').html("Off day set successfully");
                    $('#view_days_off').html(all_offdate_list[1]);
                    $('#insert_days_off').html(all_offdate_list[2]);
                    $('#days_off_succ').fadeOut(1000);
                }else{
                    alert("That date already set;");
                }
            }
        });               
}else{
   alert('Select the date.');
   $("#date_off").focus();
}
}

function off_days_delete(ID)
            {
                var ok_to_proceed = confirm('Are you sure?');
                if(ok_to_proceed == true){
                $.ajax
                    ({
                        type: "POST",
                        url: "days_off_delete.php",
                        data: "off_day_delete_id=" + ID,
                        beforeSend: loadStart,
                        complete: loadStop,
                        success: function(option)
                            {
                                if(option != ''){
                                 var all_offdate_list = option.split("~"); 
                                 $('#days_off_succ').html(all_offdate_list[0]);
                                 $('#view_days_off').html(all_offdate_list[1]);
                                 $('#insert_days_off').html(all_offdate_list[2]);
                                 $('#days_off_succ').fadeOut(1000);
                                }else{
                                    alert("That date already set;");
                                }
                            }
                        }); 
                }else{
                    return false;
                }
            }