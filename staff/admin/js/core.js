$(function() {

	$(".tbl_repeat tbody").tableDnD({
		onDrop: function(table, row) {
			var orders = $.tableDnD.serialize();
			$.post('/sohorepro/admin/order.php', { orders : orders });
                        if(true){
                            alert('Category order sorting');
                            $("#msg").html('Category order sorted successfully');
                            window.location = "category.php";
                        }
                }
	});
        
        $(".tbl_repeatsub tbody").tableDnD({
		onDrop: function(table, row) {
			var orders = $.tableDnD.serialize();
			$.post('/sohorepro/admin/ordersub.php', { orders : orders });
                        if(true){
                            alert('sub category order sorting');
                            $("#msg").html('Subcategory order sorted successfully');
                            window.location = "subcategory.php";
                        }
                }
	});
        
        
         $(".tbl_repeatpro tbody").tableDnD({
		onDrop: function(table, row) {
			var orders = $.tableDnD.serialize();
			$.post('/sohorepro/admin/orderpro.php', { orders : orders });
                        if(true){
                            alert('Products order sorting');
                            $("#msg").html('Products order sorted successfully');
                            window.location = "products.php";
                        }
                }
	});
        
        

});