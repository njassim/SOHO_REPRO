
$(document).ready(function()
{

    $(".manager").click(function()
    {
        var check_val = $('#manager').attr('checked') ? 1 : 0;
        var check_ok = confirm($('#manager').attr('checked') ? "Are you sure?" : "Are you sure?");
        var comp_id = $(".copm_id").attr("id");
        var cust_id = $(".customer_id").attr("id");
        //$('.cus_adm_succ').html('');
        //$('.cus_adm_succ').show();
        if (check_ok == true){
            $.ajax
                    ({
                        type: "POST",
                        url: "customers_account_type.php",
                        data: "comp_id=" + comp_id + "&cust_id=" + cust_id + "&account_type=" + check_val,
                        beforeSend: loadStart,
                        complete: loadStop,
                        success: function(option)
                        {
                            var myarr = option.split("~");
                            $('#user_details_' + comp_id + '_' + cust_id).html(myarr[1]);
                            $('#msg_' + comp_id).html(myarr[0]);
                            $('#msg_' + comp_id).fadeIn(1000); 
                            $('#msg_' + comp_id).fadeOut(1000); 
                            //$('#msg_' + comp_id).fadeIn(1200);
                        }
                    });
                }else{
                    return false;
                }
       
    });
    
    
     $(".active_user").click(function()
    {
        var check_val = $('#active_user').attr('checked') ? 1 : 0;
        var check_ok = confirm($('#active_user').attr('checked') ? "Are you sure?" : "Are you sure?");
        var comp_id = $(".copm_id").attr("id");
        var cust_id = $(".cust_id").attr("id");
        if (!check_ok)
        {
            return false;
        }
        else
        {
            $.ajax
                    ({
                        type: "POST",
                        url: "customers_status.php",
                        data: "comp_id=" + comp_id + "&cust_id=" + cust_id + "&account_type=" + check_val,
                        success: function(option)
                        {
                            var myarr = option.split("~");

                            $('#user_details_' + comp_id + '_' + cust_id).html(myarr[1]);
                            $('#msg_' + comp_id + '_' + cust_id).html(myarr[0]);
                            $('#msg_' + comp_id + '_' + cust_id).hide(2000);
                        }
                    });
        }

    });
    

    $(".edit_cust_dtls").click(function()
    {
        var ID = $('.main_id').attr('id');
        $(".cus_fname_" + ID).hide();
        $(".cus_lname_" + ID).hide();
        $(".cus_email_" + ID).hide();
        $(".cus_phone_" + ID).hide();
        $(".edit_" + ID).hide();
        $(".cus_fname_txt_" + ID).show();
        $(".cus_lname_txt_" + ID).show();
        $(".cus_email_txt_" + ID).show();
        $(".cus_phone_txt_" + ID).show();
        $(".save_" + ID).show();
    });

    $(".svae_cus_dtls").click(function()
    {
        var ID = $(".main_id").attr("id");
        var fname = document.getElementById('cus_fname_txt_' + ID).value;
        var lname = document.getElementById('cus_lname_txt_' + ID).value;
        var email = document.getElementById('cus_email_txt_' + ID).value;
        var phone = document.getElementById('cus_phone_txt_' + ID).value;
        var filter = /^[a-zA-Z0-9\-_]+(\.[a-zA-Z0-9\-_]+)*@[a-z0-9]+(\-[a-z0-9]+)*(\.[a-z0-9]+(\-[a-z0-9]+)*)*\.[a-z]{2,4}$/;
        //alert(fname + " " + lname + " " + email + " " + phone);
//        if (fname == '') {
//            alert("First name should not be empty.");
//            document.getElementById('cus_fname_txt_' + ID).focus();
//            return false;
//        }
//        if (lname == '') {
//            alert("Last name should not be empty.");
//            document.getElementById('cus_lname_txt_' + ID).focus();
//            return false;
//        }
//        if (email == '') {
//            alert("Email should not be empty.");
//            document.getElementById('cus_email_txt_' + ID).focus();
//            return false;
//        }
//        if (!filter.test(email)) {
//            alert('Please provide a valid email address');
//            document.getElementById('cus_email_txt_' + ID).focus();
//            return false;
//        }
//        if (phone == '') {
//            alert("Phone should not be empty.");
//            document.getElementById('cus_phone_txt_' + ID).focus();
//            return false;
//        }
        if (phone == '')
        {
            $.ajax
                    ({
                        type: "POST",
                        url: "update_cus_dtls.php",
                        data: "id=" + ID + "&fname=" + fname + "&lname=" + lname + "&email=" + email + "&phone=" + phone,
                        success: function(option)
                        {
                            var myarr = option.split("~");

                            $(".cus_fname_txt_" + ID).hide();
                            $(".cus_lname_txt_" + ID).hide();
                            $(".cus_email_txt_" + ID).hide();
                            $(".cus_phone_txt_" + ID).hide();
                            $(".save_" + ID).hide();
                            $(".edit_" + ID).show();
                            $(".cus_fname_" + ID).show();
                            $(".cus_lname_" + ID).show();
                            $(".cus_email_" + ID).show();
                            $(".cus_phone_" + ID).show();
                            $('#cus_fname_' + ID).html(myarr[1]);
                            $('#cus_lname_' + ID).html(myarr[2]);
                            $('#cus_email_' + ID).html(myarr[3]);
                            $('#cus_phone_' + ID).html(myarr[4]);
                            $('#msg_' + ID).html(myarr[0]);
                            $('#msg_' + ID).hide(2000);
                        }
                    });

        }
        else
        {

        }

    });

    $(".delete_cust_dtls").click(function()
    {
        var ID = $(".main_id").attr("id");
        var del = confirm('Are you sure you want to delete this user?');
        if (!del)
        {
            return false;
        }
        else
        {
            //alert(ID);
            $.ajax
                    ({
                        type: "POST",
                        url: "delete_cus_dtls.php",
                        data: "id=" + ID,
                        success: function(option)
                        {
                            var myarr = option.split("~");
                            $('#user_select_box_' + ID).html(myarr[1]);
                            $('#user_details_' + ID).html(myarr[2]);
                            $('#msg_' + ID).html(myarr[0]);
                            $('#msg_' + ID).hide(2000);
                        }
                    });


        }


    });

    $(".select_customer").change(function()
    {
        var ID = $(this).attr('id');
        var cust_id = $(".customer_name_" + ID).val();
        //alert(ID);
        if (cust_id != '') {

            $.ajax
                    ({
                        type: "POST",
                        url: "customers_edit.php",
                        data: "id=" + ID + "&cust_id=" + cust_id,
                        success: function(option)
                        {
                            $('#customer_dtls_' + ID).html(option);
                        }
                    });


        }
    });

//First Name Inline Edit Start
$(".edit_fname").click(function()
    {
        var ID = $('.main_id').attr('id');
        $(".cus_fname_" + ID).hide(); 
        $(".cus_fname_txt_" + ID).show(); 
        $(".fn_update_"+ID).show();
        $(".fn_cancel_"+ID).show();
    });

$(".fncancel").click(function()
    {
        var ID = $('.main_id').attr('id');
        $(".cus_fname_" + ID).show(); 
        $(".cus_fname_txt_" + ID).hide(); 
        $(".fn_update_"+ID).hide();
        $(".fn_cancel_"+ID).hide();
    });
    
    
$(".fnupdate").click(function()
    {
        var ID              = $('.main_id').attr('id');
        var fields          = ID.split(/_/);
        var customer_id     = fields[1];        
        var fname_val_pre   = $(".cus_fname_txt_" + ID).val();
        var fname_val       = (fname_val_pre != '') ? fname_val_pre : '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
        //alert(fname_val);
        if (customer_id != '') {

            $.ajax
                    ({
                        type: "POST",
                        url: "customers_edit_inline.php",
                        data: "id=" + customer_id + "&fname="+fname_val,
                        success: function(option)
                        {
                            $('#cus_fname_' + ID).html(fname_val);
                            $(".cus_fname_txt_" + ID).hide(); 
                            $(".fn_update_"+ID).hide();
                            $(".fn_cancel_"+ID).hide();
                            $(".cus_fname_" + ID).show(); 
                        }
                    });


        }
        
    });

//First Name Inline Edit End


//Last Name Inline Edit Start
$(".edit_lname").click(function()
    {
        var ID = $('.main_id').attr('id');
        $(".cus_lname_" + ID).hide(); 
        $(".cus_lname_txt_" + ID).show(); 
        $(".ln_update_"+ID).show();
        $(".ln_cancel_"+ID).show();
    });

$(".lncancel").click(function()
    {
        var ID = $('.main_id').attr('id');
        $(".cus_lname_" + ID).show(); 
        $(".cus_lname_txt_" + ID).hide(); 
        $(".ln_update_"+ID).hide();
        $(".ln_cancel_"+ID).hide();
    });
    
    
$(".lnupdate").click(function()
    {
        var ID              = $('.main_id').attr('id');
        var fields          = ID.split(/_/);
        var customer_id     = fields[1];        
        var lname_val_pre   = $(".cus_lname_txt_" + ID).val();
        var lname_val       = (lname_val_pre != '') ? lname_val_pre : '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
        //alert(fname_val);
        if (customer_id != '') {

            $.ajax
                    ({
                        type: "POST",
                        url: "customers_edit_inline.php",
                        data: "id=" + customer_id + "&lname="+lname_val,
                        success: function(option)
                        {
                            $('#cus_lname_' + ID).html(lname_val);
                            $(".cus_lname_txt_" + ID).hide(); 
                            $(".ln_update_"+ID).hide();
                            $(".ln_cancel_"+ID).hide();
                            $(".cus_lname_" + ID).show(); 
                        }
                    });


        }
    });

//Last Name Inline Edit End

//Email Name Inline Edit Start
$(".edit_email").click(function()
    {
        var ID = $('.main_id').attr('id');
        $(".cus_email_" + ID).hide(); 
        $(".cus_email_txt_" + ID).show(); 
        $(".em_update_"+ID).show();
        $(".em_cancel_"+ID).show();
    });

$(".emcancel").click(function()
    {
        var ID = $('.main_id').attr('id');
        var fields      = ID.split(/_/);
        $(".cus_email_" + ID).show(); 
        $(".cus_email_txt_" + ID).hide(); 
        $(".em_update_"+ID).hide();
        $(".em_cancel_"+ID).hide();
        $("#fail_alert_"+fields[0]).html('');
    });
    
    
$(".emupdate").click(function()
    {
        var ID          = $('.main_id').attr('id');
        var fields      = ID.split(/_/);
        var customer_id = fields[1];        
        var email_val   = $(".cus_email_txt_" + ID).val();
        var filter = /^[a-zA-Z0-9\-_]+(\.[a-zA-Z0-9\-_]+)*@[a-z0-9]+(\-[a-z0-9]+)*(\.[a-z0-9]+(\-[a-z0-9]+)*)*\.[a-z]{2,4}$/;
        //alert(fname_val);
        if (!filter.test(email_val)) {
            alert('Please provide a valid email address');
            document.getElementById('cus_email_txt_' + ID).focus();
            return false;
        }
        if (email_val != '') {

            $.ajax
                    ({
                        type: "POST",
                        url: "customers_edit_inline.php",
                        data: "id=" + customer_id + "&email="+email_val,
                        success: function(option)
                        {
                            if(option == '0'){
                                $("#fail_alert_"+fields[0]).html('Email already exist.');
                                document.getElementById("cus_email_txt_" + ID).focus();
                            }else{
                                $('#cus_email_' + ID).html(option);
                                $(".cus_email_txt_" + ID).hide(); 
                                $(".em_update_"+ID).hide();
                                $(".em_cancel_"+ID).hide();
                                $(".cus_email_" + ID).show();    
                            }
                        }
                    });


        }
    });

//Email Name Inline Edit End

//Password Inline Edit Start
$(".edit_password").click(function()
    {
        var ID = $('.main_id').attr('id');
        $(".cus_password_" + ID).hide();
        $("#cus_resend_"+ID).hide();
        $(".cus_password_txt_" + ID).show(); 
        $(".password_update_"+ID).show();
        $(".password_cancel_"+ID).show();
    });

$(".passwordcancel").click(function()
    {
        var ID = $('.main_id').attr('id');
        $(".cus_password_" + ID).show(); 
        $("#cus_resend_"+ID).show();
        $(".cus_password_txt_" + ID).hide(); 
        $(".password_update_"+ID).hide();
        $(".password_cancel_"+ID).hide();
    });



$(".passwordupdate").click(function()
    {
        var ID          = $('.main_id').attr('id');
        var fields      = ID.split(/_/);
        var customer_id = fields[1];        
        var password_val   = $(".cus_password_txt_" + ID).val();
        //alert(fname_val);
        if (password_val != '') {

            $.ajax
                    ({
                        type: "POST",
                        url: "customers_edit_inline.php",
                        data: "id=" + customer_id + "&password_value="+password_val,
                        success: function(option)
                        {
                            $('#cus_password_' + ID).html(option);
                            $(".cus_password_txt_" + ID).hide(); 
                            $(".password_update_"+ID).hide();
                            $(".password_cancel_"+ID).hide();
                            $(".cus_password_" + ID).show();
                            $("#cus_resend_"+ID).show();
                        }
                    });


        }
    });



//Password Inline Edit End





//Phone Inline Edit Start
$(".edit_phone").click(function()
    {
        var ID = $('.main_id').attr('id');
        $(".cus_phone_" + ID).hide(); 
        $(".cus_phone_txt_" + ID).show(); 
        $(".ph_update_"+ID).show();
        $(".ph_cancel_"+ID).show();
    });

$(".phcancel").click(function()
    {
        var ID = $('.main_id').attr('id');
        $(".cus_phone_" + ID).show(); 
        $(".cus_phone_txt_" + ID).hide(); 
        $(".ph_update_"+ID).hide();
        $(".ph_cancel_"+ID).hide();
    });
    
    
$(".phupdate").click(function()
    {
        var ID          = $('.main_id').attr('id');
        var fields      = ID.split(/_/);
        var customer_id = fields[1];        
        var phone_val   = $(".cus_phone_txt_" + ID).val();
        //alert(fname_val);
        if (phone_val != '') {

            $.ajax
                    ({
                        type: "POST",
                        url: "customers_edit_inline.php",
                        data: "id=" + customer_id + "&phone="+phone_val,
                        success: function(option)
                        {
                            $('#cus_phone_' + ID).html(option);
                            $(".cus_phone_txt_" + ID).hide(); 
                            $(".ph_update_"+ID).hide();
                            $(".ph_cancel_"+ID).hide();
                            $(".cus_phone_" + ID).show(); 
                        }
                    });


        }
    });

//Phone Inline Edit End



});


function resend_cred(COMP_ID,CUS_ID)
{
    var confirm_send = confirm("Are you sure?");
    if(confirm_send == true){
    if (CUS_ID != '') {

            $.ajax
                    ({
                        type: "POST",
                        url: "customers_edit_inline.php",
                        data: "resend_company_id=" + COMP_ID + "&resend_customer_id="+CUS_ID,
                        beforeSend: loadStart,
                        complete: loadStop,
                        success: function(option)
                        {
                            $("#succ_resend_"+COMP_ID).html(option);
                            $("#succ_resend_"+COMP_ID).fadeOut(2500);
                        }
                    });


        }
    }
    else{
        return false;
    }
}

function delete_ind_user(COMP_ID,CUS_ID)
{
    var confirm_send = confirm("Are you sure?");
    if(confirm_send == true){
    if (CUS_ID != '') {
        $.ajax
            ({
                type: "POST",
                url: "customers_edit_inline.php",
                data: "delete_ind_cus_id=" + CUS_ID,
                beforeSend: loadStart,
                complete: loadStop,
                success: function(option)
                {
                    if(option == '1'){
                        window.location = "customers.php?cus_id="+COMP_ID+"&succ=1";
                    }else{
                        window.location = "customers.php?cus_id="+COMP_ID+"&succ=0";
                    }
                }
            });
        }
    }
    else{
        return false;
    }
}


function loadStart() {
$('#loading').show();
}

function loadStop() {
$('#loading').hide();
}