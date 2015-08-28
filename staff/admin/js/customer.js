
$(document).ready(function()
{

    $(".manager").click(function()
    {
        var check_val = $('#manager').attr('checked') ? 1 : 0;
        var check_ok = confirm($('#manager').attr('checked') ? "A User Admin already exists. Do you wish to assign it to this user instead?" : "Are you sure?");
        var comp_id = $(".copm_id").attr("id");
        var cust_id = $(".customer_id").attr("id");
        if (!check_ok)
        {
            return false;
        }
        else
        {
            $.ajax
                    ({
                        type: "POST",
                        url: "customers_account_type.php",
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
        var ID          = $('.main_id').attr('id');
        var fields      = ID.split(/_/);
        var customer_id = fields[1];        
        var fname_val   = $(".cus_fname_txt_" + ID).val();
        //alert(fname_val);
        if (customer_id != '') {

            $.ajax
                    ({
                        type: "POST",
                        url: "customers_edit_inline.php",
                        data: "id=" + customer_id + "&fname="+fname_val,
                        success: function(option)
                        {
                            $('#cus_fname_' + ID).html(option);
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
        var ID          = $('.main_id').attr('id');
        var fields      = ID.split(/_/);
        var customer_id = fields[1];        
        var lname_val   = $(".cus_lname_txt_" + ID).val();
        //alert(fname_val);
        if (customer_id != '') {

            $.ajax
                    ({
                        type: "POST",
                        url: "customers_edit_inline.php",
                        data: "id=" + customer_id + "&lname="+lname_val,
                        success: function(option)
                        {
                            $('#cus_lname_' + ID).html(option);
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
        $(".cus_email_" + ID).show(); 
        $(".cus_email_txt_" + ID).hide(); 
        $(".em_update_"+ID).hide();
        $(".em_cancel_"+ID).hide();
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
                            $('#cus_email_' + ID).html(option);
                            $(".cus_email_txt_" + ID).hide(); 
                            $(".em_update_"+ID).hide();
                            $(".em_cancel_"+ID).hide();
                            $(".cus_email_" + ID).show(); 
                        }
                    });


        }
    });

//Email Name Inline Edit End

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
