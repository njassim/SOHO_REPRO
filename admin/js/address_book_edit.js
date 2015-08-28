$(document).ready(function()
{

//Address Book  Attention_to Inline Edit Start
            
            $('.edit_adb_att').click(function()
            {
                var ID = $(this).attr('id');
                // alert(ID);
                $(".add_book_att_" + ID).hide();
                $(".add_book_att_txt_" + ID).css("display", "inline-block");
                //$(".add_book_lbl_" + ID).css("display", "inline-block");
                $(".cn_att_update_" + ID).css("display", "inline-block");
                $(".cn_att_cancel_" + ID).css("display", "inline-block");
                //$(".cus_id").attr("id",ID);        
            });
            
            $('.cn_att_cancel').click(function()
            {
                var ID = $(this).attr('id');
                $(".add_book_att_" + ID).show();
                $(".add_book_att_txt_" + ID).hide();
                $(".cn_att_update_" + ID).hide();
                $(".cn_att_cancel_" + ID).hide();
                //$(".add_book_lbl_" + ID).hide();
                //$(".cus_id").attr("id",ID);        
            });
            
            $('.cn_att_update').click(function()
            {
                var ID = $(this).attr('id');
                var cname_val = $(".add_book_att_txt_" + ID).val();
                var cname_val_rep_fnl =   (cname_val == '') ? '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' : cname_val;                  
                    $.ajax
                            ({
                                type: "POST",
                                url: "customers_edit_inline.php",
                                data: "id=" + ID + "&attention_to=" + encodeURIComponent(cname_val_rep_fnl),
                                success: function(option)
                                {
                                    $(".add_book_att_" + ID).html(option);
                                    $(".add_book_att_" + ID).css("display", "inline-block");
                                    $(".add_book_att_txt_" + ID).hide();
                                    $(".cn_att_update_" + ID).hide();
                                    $(".cn_att_cancel_" + ID).hide();
                                }
                            });

            });
            
//Address Book  Comp Name Inline Edit End

//Address Book  Comp Name Inline Edit Start
            
            $('.edit_adb_cn').click(function()
            {
                var ID = $(this).attr('id');
                // alert(ID);
                $(".add_book_cn_" + ID).hide();
                $(".add_book_txt_" + ID).css("display", "inline-block");
                $(".add_book_lbl_" + ID).css("display", "inline-block");
                $(".cn_adb_update_" + ID).css("display", "inline-block");
                $(".cn_adb_cancel_" + ID).css("display", "inline-block");
                //$(".cus_id").attr("id",ID);        
            });
            
            $('.cn_adb_cancel').click(function()
            {
                var ID = $(this).attr('id');
                $(".add_book_cn_" + ID).show();
                $(".add_book_txt_" + ID).hide();
                $(".cn_adb_update_" + ID).hide();
                $(".cn_adb_cancel_" + ID).hide();
                $(".add_book_lbl_" + ID).hide();
                //$(".cus_id").attr("id",ID);        
            });
            
            $('.cn_adb_update').click(function()
            {
                var ID = $(this).attr('id');
                var cname_val = $(".add_book_txt_" + ID).val();
                var cname_val_rep_fnl =   (cname_val == '') ? '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' : cname_val; 
                    $.ajax
                            ({
                                type: "POST",
                                url: "customers_edit_inline.php",
                                data: "id=" + ID + "&adb_company_name=" + encodeURIComponent(cname_val_rep_fnl),
                                success: function(option)
                                {
                                    $(".add_book_cn_" + ID).html(option);
                                    $(".add_book_cn_" + ID).css("display", "inline-block");
                                    $(".add_book_txt_" + ID).hide();
                                    $(".cn_adb_update_" + ID).hide();
                                    $(".cn_adb_cancel_" + ID).hide();
                                }
                            });

            });
            
//Address Book  Attention_to Inline Edit End
            
            
//Address Book  Address 1 Inline Edit Start
            
            $('.edit_adb_ad1').click(function()
            {
                var ID = $(this).attr('id');
                // alert(ID);
                $(".add_book_ad1_" + ID).hide();
                $(".add_book_ad1_lbl_" + ID).css("display", "inline-block");
                $(".add_book_ad1_txt_" + ID).css("display", "inline-block");
                $(".adb_ad1_update_" + ID).css("display", "inline-block");
                $(".adb_ad1_cancel_" + ID).css("display", "inline-block");
                //$(".cus_id").attr("id",ID);        
            });
            
            $('.adb_ad1_cancel').click(function()
            {
                var ID = $(this).attr('id');
                $(".add_book_ad1_" + ID).show();
                $(".add_book_ad1_lbl_" + ID).hide();
                $(".add_book_ad1_txt_" + ID).hide();
                $(".adb_ad1_update_" + ID).hide();
                $(".adb_ad1_cancel_" + ID).hide();
                //$(".cus_id").attr("id",ID);        
            });
            
            $('.adb_ad1_update').click(function()
            {
                var ID = $(this).attr('id');
                var cname_val = $(".add_book_ad1_txt_" + ID).val();
                var cname_val_rep_fnl =   (cname_val == '') ? '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' : cname_val; 
                $.ajax
                        ({
                            type: "POST",
                            url: "customers_edit_inline.php",
                            data: "id=" + ID + "&adb_address_1=" + encodeURIComponent(cname_val_rep_fnl),
                            success: function(option)
                            {
                                $(".add_book_ad1_" + ID).html(option);
                                $(".add_book_ad1_" + ID).css("display", "inline-block");
                                $(".add_book_ad1_txt_" + ID).hide();
                                $(".adb_ad1_update_" + ID).hide();
                                $(".adb_ad1_cancel_" + ID).hide();
                            }
                        });
            });
            
//Address Book  Address 1 Inline Edit End            

//Address Book  Address 2 Inline Edit Start
            
            $('.edit_adb_ad2').click(function()
            {
                var ID = $(this).attr('id');
                // alert(ID);
                $(".add_book_ad2_" + ID).hide();
                $(".add_book_ad2_lbl_" + ID).css("display", "inline-block");
                $(".add_book_ad2_txt_" + ID).css("display", "inline-block");
                $(".adb_ad2_update_" + ID).css("display", "inline-block");
                $(".adb_ad2_cancel_" + ID).css("display", "inline-block");
                //$(".cus_id").attr("id",ID);        
            });
            
            $('.adb_ad2_cancel').click(function()
            {
                var ID = $(this).attr('id');
                $(".add_book_ad2_" + ID).show();
                $(".add_book_ad2_lbl_" + ID).hide();
                $(".add_book_ad2_txt_" + ID).hide();
                $(".adb_ad2_update_" + ID).hide();
                $(".adb_ad2_cancel_" + ID).hide();
                //$(".cus_id").attr("id",ID);        
            });
            
            $('.adb_ad2_update').click(function()
            {
                var ID = $(this).attr('id');
                var cname_val = $(".add_book_ad2_txt_" + ID).val();
                var cname_val_rep_fnl =   (cname_val == '') ? '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' : cname_val; 
                $.ajax
                        ({
                            type: "POST",
                            url: "customers_edit_inline.php",
                            data: "id=" + ID + "&adb_address_2=" + encodeURIComponent(cname_val_rep_fnl),
                            success: function(option)
                            {
                                $(".add_book_ad2_" + ID).html(option);
                                $(".add_book_ad2_" + ID).css("display", "inline-block");
                                $(".add_book_ad2_txt_" + ID).hide();
                                $(".adb_ad2_update_" + ID).hide();
                                $(".adb_ad2_cancel_" + ID).hide();
                            }
                        });
            });
            
//Address Book  Address 2 Inline Edit End    

//Address Book  Address 3 Inline Edit Start
            
            $('.edit_adb_ad3').click(function()
            {
                var ID = $(this).attr('id');
                // alert(ID);
                $(".add_book_ad3_" + ID).hide();
                $(".add_book_ad3_lbl_" + ID).css("display", "inline-block");
                $(".add_book_ad3_txt_" + ID).css("display", "inline-block");
                $(".adb_ad3_update_" + ID).css("display", "inline-block");
                $(".adb_ad3_cancel_" + ID).css("display", "inline-block");
                //$(".cus_id").attr("id",ID);        
            });
            
            $('.adb_ad3_cancel').click(function()
            {
                var ID = $(this).attr('id');
                $(".add_book_ad3_" + ID).show();
                $(".add_book_ad3_lbl_" + ID).hide();
                $(".add_book_ad3_txt_" + ID).hide();
                $(".adb_ad3_update_" + ID).hide();
                $(".adb_ad3_cancel_" + ID).hide();
                //$(".cus_id").attr("id",ID);        
            });
            
            $('.adb_ad3_update').click(function()
            {
                var ID = $(this).attr('id');
                var cname_val = $(".add_book_ad3_txt_" + ID).val();
                var cname_val_rep_fnl =   (cname_val == '') ? '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' : cname_val; 
                $.ajax
                    ({
                        type: "POST",
                        url: "customers_edit_inline.php",
                        data: "id=" + ID + "&adb_address_3=" + encodeURIComponent(cname_val_rep_fnl),
                        success: function(option)
                        {
                            $(".add_book_ad3_" + ID).html(option);
                            $(".add_book_ad3_" + ID).css("display", "inline-block");
                            $(".add_book_ad3_txt_" + ID).hide();
                            $(".adb_ad3_update_" + ID).hide();
                            $(".adb_ad3_cancel_" + ID).hide();
                        }
                    });
            });
            
//Address Book  Address 3 Inline Edit End

//Address Book city Inline Edit Start

            $('.adb_city_inline').click(function()
            {
                var ID = $(this).attr('id');
                // alert(ID);
                $(".adb_city_inline_span_" + ID).hide();
                $(".adb_city_inline_txt_" + ID).css("display", "inline-block");
                $(".city_update_abd_" + ID).css("display", "inline-block");
                $(".city_cancel_abd_" + ID).css("display", "inline-block");
                //$(".cus_id").attr("id",ID);        
            });

            $('.city_cancel_abd').click(function()
            {
                var ID = $(this).attr('id');
                $(".adb_city_inline_span_" + ID).show();
                $(".adb_city_inline_txt_" + ID).hide();
                $(".city_update_abd_" + ID).hide();
                $(".city_cancel_abd_" + ID).hide();
                //$(".cus_id").attr("id",ID);        
            });


            $('.city_update_abd').click(function()
            {
                var ID = $(this).attr('id');
                var city_val = $(".adb_city_inline_txt_" + ID).val();
                var cname_val_rep_fnl =   (city_val == '') ? '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' : city_val;   
                $.ajax
                    ({
                        type: "POST",
                        url: "customers_edit_inline.php",
                        data: "id=" + ID + "&adb_city=" + encodeURIComponent(cname_val_rep_fnl),
                        success: function(option)
                        {
                            $(".adb_city_inline_span_" + ID).html(option);
                            $(".adb_city_inline_span_" + ID).css("display", "inline-block");
                            $(".adb_city_inline_txt_" + ID).hide();
                            $(".city_update_abd_" + ID).hide();
                            $(".city_cancel_abd_" + ID).hide();
                        }
                    });
            });
//Address Book Book city Inline Edit End  

//Address Book State Inline Edit Start
            $('.adb_stat_inline').click(function()
            {
                var ID = $(this).attr('id');
                $(".adb_stat_inline_span_" + ID).hide();
                $(".adb_stat_inline_txt_" + ID).css("display", "inline-block");
                $(".stat_update_" + ID).css("display", "inline-block");
                $(".stat_cancel_" + ID).css("display", "inline-block");
            });

            $('.stat_cancel').click(function()
            {
                var ID = $(this).attr('id');
                $(".bus_stat_inline_span_" + ID).show();
                $(".bus_stat_inline_txt_" + ID).hide();
                $(".stat_update_" + ID).hide();
                $(".stat_cancel_" + ID).hide();
            });



            $('.adb_state').change(function()
            {
                var ID = $(this).attr('id');
                var state_val = $(this).val();
                //alert(cname_val);        
                if (state_val != '') {

                    $.ajax
                            ({
                                type: "POST",
                                url: "customers_edit_inline.php",
                                data: "id=" + ID + "&adb_state_val=" + state_val,
                                success: function(option)
                                {
                                    $(".adb_stat_inline_span_" + ID).html(option);
                                    $(".adb_stat_inline_span_" + ID).css("display", "inline-block");
                                    $(".adb_stat_inline_txt_" + ID).hide();
                                }
                            });

                }

            });
            
//Address Book State Inline Edit End 

//Address Book Zip Inline Edit Start

            $('.adb_zip_inline').click(function()
            {
                var ID = $(this).attr('id');
                $(".adb_zip_inline_span_" + ID).hide();
                $(".adb_zip_inline_txt_" + ID).css("display", "inline-block");
                $(".zip_update_abd_" + ID).css("display", "inline-block");
                $(".zip_cancel_abd_" + ID).css("display", "inline-block");
            });

            $('.zip_cancel_abd').click(function()
            {
                var ID = $(this).attr('id');
                $(".adb_zip_inline_span_" + ID).show();
                $(".adb_zip_inline_txt_" + ID).hide();
                $(".zip_update_abd_" + ID).hide();
                $(".zip_cancel_abd_" + ID).hide();
            });


            $('.zip_update_abd_').click(function()
            {
                var ID = $(this).attr('id');
                var zip_val = $(".adb_zip_inline_txt_" + ID).val();
                var cname_val_rep_fnl =   (zip_val == '') ? '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' : zip_val;   
                $.ajax
                    ({
                        type: "POST",
                        url: "customers_edit_inline.php",
                        data: "id=" + ID + "&adb_zip=" + cname_val_rep_fnl,
                        success: function(option)
                        {
                            $(".adb_zip_inline_span_" + ID).html(option);
                            $(".adb_zip_inline_span_" + ID).css("display", "inline-block");
                            $(".adb_zip_inline_txt_" + ID).hide();
                            $(".zip_update_abd_" + ID).hide();
                            $(".zip_cancel_abd_" + ID).hide();
                        }
                    });
            });


//Address Book Zip Inline Edit End 


//Delivery Zip Ext Inline Edit Start

            $('.zip_inline_del_ext_abd').click(function()
            {
                var ID = $(this).attr('id');
                $(".zip_inline_span_del_ext_abd_" + ID).hide();
                $(".zip_inline_txt_del_ext_abd_" + ID).css("display", "inline-block");
                $(".zip_update_del_ext_abd_" + ID).css("display", "inline-block");
                $(".zip_cancel_del_ext_abd_" + ID).css("display", "inline-block");
            });

            $('.zip_cancel_del_ext_abd').click(function()
            {
                var ID = $(this).attr('id');
                $(".zip_inline_span_del_ext_abd_" + ID).show();
                $(".zip_inline_txt_del_ext_abd_" + ID).hide();
                $(".zip_update_del_ext_abd_" + ID).hide();
                $(".zip_cancel_del_ext_abd_" + ID).hide();
            });


            $('.zip_update_del_ext_abd').click(function()
            {
                var ID = $(this).attr('id');
                var zip_val = $(".zip_inline_txt_del_ext_abd_" + ID).val();
                var zip_val_fnl =   (zip_val == '') ? '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' : zip_val;   
                if (zip_val != '') {

                    $.ajax
                            ({
                                type: "POST",
                                url: "customers_edit_inline.php",
                                data: "id=" + ID + "&bus_zip_del_ext_adb="+zip_val_fnl,
                                success: function(option)
                                {
                                    $(".zip_inline_span_del_ext_abd_" + ID).html(option);
                                    $(".zip_inline_span_del_ext_abd_" + ID).css("display", "inline-block");
                                    $(".zip_inline_txt_del_ext_abd_" + ID).hide();
                                    $(".zip_update_del_ext_abd_" + ID).hide();
                                    $(".zip_cancel_del_ext_abd_" + ID).hide();
                                }
                            });

                }

            });


            //Delivery Zip Ext Inline Edit End 



//Address Book Phone Inline Edit Start

            $('.adb_phone_inline').click(function()
            {
                var ID = $(this).attr('id');
                $(".adb_phone_inline_span_" + ID).hide();
                $(".adb_phone_inline_txt_" + ID).css("display", "inline-block");
                $(".adb_phone_inline_lbl_" + ID).css("display", "inline-block");
                $(".phone_adb_update_" + ID).css("display", "inline-block");
                $(".phone_adb_cancel_" + ID).css("display", "inline-block");
                $(".adb_phone_head_inline_span_" + ID).css("float", "left");
                $(".adb_phone_inline_txt_" + ID).css("float", "left");
            });

            $('.phone_adb_cancel').click(function()
            {
                var ID = $(this).attr('id');
                $(".adb_phone_inline_span_" + ID).show();
                $(".adb_phone_inline_txt_" + ID).hide();
                $(".adb_phone_inline_lbl_" + ID).hide();
                $(".phone_adb_update_" + ID).hide();
                $(".phone_adb_cancel_" + ID).hide();
            });


            $('.phone_adb_update').click(function()
            {
                var ID = $(this).attr('id');
                var phone_val = $(".adb_phone_inline_txt_" + ID).val();
                var cname_val_rep_fnl =   (phone_val == '') ? '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' : phone_val;   
                $.ajax
                    ({
                        type: "POST",
                        url: "customers_edit_inline.php",
                        data: "id=" + ID + "&adb_phone=" + cname_val_rep_fnl,
                        success: function(option)
                        {
                            $(".adb_phone_inline_span_" + ID).html(option);
                            $(".adb_phone_inline_span_" + ID).css("display", "inline-block");
                            $(".adb_phone_inline_txt_" + ID).hide();
                            $(".phone_adb_update_" + ID).hide();
                            $(".phone_adb_cancel_" + ID).hide();
                        }
                    });
            });


//Address Book Phone Inline Edit End 

});


function delete_shipp_add(ID,COMP_ID)
{
    var delete_id   =   ID;
    var delete_shipp = confirm('Are you sure?');
    if(delete_shipp == true){
        if (delete_id != '') {
          $.ajax
                    ({
                        type: "POST",
                        url: "customers_edit_inline.php",
                        data: "delete_shipp_id=" + delete_id,
                        beforeSend: loadStart,
                        complete: loadStop,
                        success: function(option)
                        {
                            if(option == true){
                            window.location = "customers.php?cus_id="+COMP_ID+"&cus_add_id="+COMP_ID;
                            }
                        }
                    });

        }
    }else{
        return false;
    }
}

function loadStart() {
$('#loading').show();
}

function loadStop() {
$('#loading').hide();
}