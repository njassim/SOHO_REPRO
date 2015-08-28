/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
   
   function inline_edit(row_id,comp_id)
   {
        var ID = row_id+"_"+comp_id;
        
        $(".list_price_c_"+ID).hide(); 
        $(".discount_price_c_"+ID).hide();
        $(".special_price_c_"+ID).hide();
        $(".edit_c_"+ID).hide();  
        $(".list_price_txt_c_"+ID).show(); 
        $(".discount_price_txt_c_"+ID).show();
        $(".special_price_txt_c_"+ID).show();        
        $(".update_c_"+ID).show();          
   }
   
   
    function discount_change(row_id,comp_id)
    {     
        var ID = row_id+"_"+comp_id;
        //alert(ID);
        var list            = document.getElementById('list_price_txt_c_'+ID).value;
        var discount        = document.getElementById('discount_price_txt_c_'+ID).value; 
        //var disc_val        = Number(discount).toFixed(2);
        
        var price           = (discount * (list/100));
        var special         = (list - price);
        var special_val     = Number(special).toFixed(2);
        
        $(".discount_price_txt_c_"+ID).val(discount);
        $(".special_price_txt_c_"+ID).val(special_val);
    }
   
    function special_change(row_id,comp_id)
    {
        var ID = row_id+"_"+comp_id;
        var list            = document.getElementById('list_price_txt_c_'+ID).value;
        var special         = document.getElementById('special_price_txt_c_'+ID).value;
        //var special_val     = Number(special).toFixed(2);
        
        var discount        = (((list - special) / list)*100);
        var discount_val    = Number(discount).toFixed(2);
        
        $(".discount_price_txt_c_"+ID).val(discount_val);
        $(".special_price_txt_c_"+ID).val(special);
    }
   
$(document).ready(function()
{
  
    $('.list_list').keydown(function (event) {

           if (event.shiftKey == true) {
                event.preventDefault();
            }

            if ((event.keyCode >= 48 && event.keyCode <= 57) || (event.keyCode >= 96 && event.keyCode <= 105) || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 37 || event.keyCode == 39 || event.keyCode == 110) {

            } else {
                event.preventDefault();
            }
            
            if(($(this).val().indexOf('.') !== -1 && event.keyCode == 110))
                event.preventDefault();

        });
        
    $('.special_special').keydown(function (event) {

           if (event.shiftKey == true) {
                event.preventDefault();
            }

            if ((event.keyCode >= 48 && event.keyCode <= 57) || (event.keyCode >= 96 && event.keyCode <= 105) || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 37 || event.keyCode == 39 || event.keyCode == 110) {

            } else {
                event.preventDefault();
            }
            
            if(($(this).val().indexOf('.') !== -1 && event.keyCode == 110))
                event.preventDefault();

        });
        
//    $('.special_special').keyup(function (event){
//        var ID              = $(".jass_p").attr("id"); 
//        var list            = document.getElementById('list_price_txt_c_'+ID).value;
//        var special         = document.getElementById('special_price_txt_c_'+ID).value;        
//        var discount        = (((list - special) / list)*100);
//        $(".discount_price_txt_c_"+ID).val(discount);
//        $(".special_price_txt_c_"+ID).val(special);
//    });
    
//    $('.discount_discount').keyup(function (event){
//        var ID              = $(".jass_p").attr("id"); 
//        //alert(ID);
//        var list            = document.getElementById('list_price_txt_c_'+ID).value;
//        var discount        = document.getElementById('discount_price_txt_c_'+ID).value;
//        
//        var price           = (discount * (list/100));
//        var special         = (list - price);
//        $(".discount_price_txt_c_"+ID).val(discount);
//        $(".special_price_txt_c_"+ID).val(special);
//    });
    
    $('.discount_discount').keydown(function (event) 
    {
//            var dis_var         = $(this).val().split('.');
//            if((dis_var[1].length == '2'))
//            {
//                    if(event.keyCode == 8)
//                    {                    
//                    //return false;
//                    }
//            }
//           
            if (event.shiftKey == true) {
                event.preventDefault();
            }

            if ((event.keyCode >= 48 && event.keyCode <= 57) || (event.keyCode >= 96 && event.keyCode <= 105) || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 37 || event.keyCode == 39 || event.keyCode == 110) {

            } else {
                event.preventDefault();
            }
            
            if(($(this).val().indexOf('.') !== -1 && event.keyCode == 110))
                event.preventDefault();
            
            

        });
    
       
//    $(document).mouseup(function()
//    {
//        var ID = $('.jass_p').attr('id');
//        $(".list_price_c_"+ID).show(); 
//        $(".discount_price_c_"+ID).show();
//        $(".special_price_c_"+ID).show();
//        $(".edit_c_"+ID).show(); 
//        $(".list_price_txt_c_"+ID).hide(); 
//        $(".discount_price_txt_c_"+ID).hide();
//        $(".special_price_txt_c_"+ID).hide();     
//        $(".update_c_"+ID).hide(); 
//    });
 
 
 $(".super_cat").click(function(){
        $(this).next(".sub_cat").toggle().siblings(".sub_cat").hide();
        });
 
});

    
    function update_sprice(str,str1)
    {
        var ID                   = str1; 
        var list_price           = document.getElementById('list_price_txt_c_'+str1+'_'+str).value;
        var discount             = document.getElementById('discount_price_txt_c_'+str1+'_'+str).value; 
        var special              = document.getElementById('special_price_txt_c_'+str1+'_'+str).value;
        var user_id              = str; 
        //alert(str1+' AND'+list_price+' AND'+discount+' AND'+user_id);
        
             if(list_price != '' && discount != '')  
	 {
	  $.ajax
	  ({
	     type: "POST",
		 url: "special_set.php",
		 data: "id="+ID+"&list_price_c="+list_price+"&discount_c="+discount+"&user_id="+user_id+"&special="+special,
		 success: function(option)
		 {
		     var myarr              = option.split("~");
                     var list_price         = myarr[0];
                     var discount_price     = myarr[1];
                     var special_price      = myarr[2];
                     var spl_prc            = myarr[3];
                     
                     $(".list_price_c_"+str1+'_'+str).html(list_price); 
                     $(".discount_price_c_"+str1+'_'+str).html(discount_price); 
                     $(".special_price_c_"+str1+'_'+str).html(special_price);
                     $(".list_price_txt_c_"+str1+'_'+str).hide(); 
                     $(".discount_price_txt_c_"+str1+'_'+str).hide();
                     $(".special_price_txt_c_"+str1+'_'+str).hide();
                     $(".update_c_"+str1+'_'+str).hide(); 
                     $(".list_price_c_"+str1+'_'+str).show(); 
                     $(".discount_price_c_"+str1+'_'+str).show(); 
                     $(".special_price_c_"+str1+'_'+str).show();
                     $(".edit_c_"+str1+'_'+str).show();                     
                     $('#spl_'+str).html(spl_prc);                       
		 }
	  });
	 }
	 else
	 {
	   $(".error").html("Please fill the all fields"); 
	 }
	return false;
        

    }


    function delete_special(special_id,cid)
    {
        var con                   = confirm("Are you sure you want to delete this special price.");
        var sp_id                 = special_id;
        var user_id               = cid;
        if (con == true)
            {
                if(sp_id != ''){
                    
        $.ajax
	  ({
	     type: "POST",
		 url: "delete_spl.php",
		 data: "sp_id="+sp_id+"&user_id="+user_id,
		 success: function(option)
		 {
                     var myarr              = option.split("~");
                     var succ               = myarr[0];
                     var special_price      = myarr[1];
                     $(".succ").html(succ);
                     $('.succ').delay(3000).fadeOut('slow');
                     $('#mas_'+user_id).html(special_price);
                     //$("#test_"+cid+"_"+special_id).hide();                     
		 }
	  });
                    
                }
                
            }
    }
    
    function add_favorites(PROD_ID, USR_ID)
    {        
        if (USR_ID != '') {    
            var ID = PROD_ID+"_"+USR_ID;
            $("#fav_id_"+PROD_ID).html('<img src="images/loading_fav.gif" height="18px" width="18px" />');            
            $.ajax
                    ({
                        type: "POST",
                        url: "favorites.php",
                        data: "fav_prod_id=" + PROD_ID + "&fav_usr_id=" + USR_ID,                        
                        success: function(option)
                        {
                            var pulse_class = (option == 'fav.png') ? 'pulse' : 'pulse_1';
                            $("#fav_id_"+PROD_ID).html('');
                            $("#fav_id_"+PROD_ID).html('<img src="images/'+option+'" border="0px" style="cursor: pointer;" class="'+pulse_class+'" onclick="return add_favorites('+PROD_ID+', '+USR_ID+');" />');                                                  
                            $(".list_price_txt_c_"+ID).hide(); 
                            $(".discount_price_txt_c_"+ID).hide();
                            $(".special_price_txt_c_"+ID).hide();
                            $(".update_c_"+ID).hide(); 
                            $(".list_price_c_"+ID).show(); 
                            $(".discount_price_c_"+ID).show(); 
                            $(".special_price_c_"+ID).show();
                            $(".edit_c_"+ID).show(); 
                        }
                    });
        } else {
            alert('You must login to make as favorites.');
        }
    }