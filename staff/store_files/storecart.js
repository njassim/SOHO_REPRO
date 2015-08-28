/**
 * SohoRepro
 *
 * LICENSE
 *
 * This source file is subject to the Propitory Licesse of ThinkDesign that is
 * bundled with this package in the file licence.txt. If you have not recived a
 * copy of the licence please mail to rayshah@thinkdesign.com
 *
 * @package     ThinkDesign Inc.
 * @copyright   Copyright (c) 2011 ThinkDesign Inc. All Rights Reserved
 * @license     Propitory
 */



function listenToQuantityChange()
{
    $('.supplyStoreElementQuantity').live('change', function() {
        var totalPrice = 0;
        var allitems = {};
        $('.supplyStoreElementQuantity').each(function(index, data) {
            if($(this).val() == false) {
                var thisQuantity = 0;
            } else {
                var thisQuantity = $(this).val();
            }
            allitems[$(this).attr('item')] = thisQuantity;
            var subTotal = thisQuantity * $(this).attr('price');
            totalPrice = totalPrice + subTotal;
            $($(this).parents('tr').children().get(5)).children('.wijmo-wijgrid-innercell').html(money_format(subTotal, '$'));            
        });
        $('#supplyStoreCartTotal').html('Total: ' + money_format(totalPrice, '$'));
        $.get('view/setstoreitemquantity/item/' + $(this).attr('item') + '/amount/' + $(this).val(), function (data) {});
    });
    $('.supplyStoreElementQuantity').each(function(index, data) {
        $($(this).parents('tr').children().get(5)).children('.wijmo-wijgrid-innercell').css('text-align', 'right');
        $($(this).parents('tr').children().get(3)).children('.wijmo-wijgrid-innercell').css('text-align', 'right');
    });
    $('.deleteSelectedItem').click(function () {
        window.location = 'view/supplystoredelete/delete/' + $(this).attr('index');
    });
    $('.addmorestoreproducts').live('click', function () {
        window.location = 'view/store';
    });
}

function listenStoreProduct()
{
    $('.storeproduct').live('blur', function() {
        var product_id = $(this).attr('proid');
        var quantity   = $(this).val();
        $.get('system/validatestore/item/' + product_id + '/amount/' + quantity, function (data) {});
    });
}

function calculateStorePriceing(storeSection)
{
    if(storeSection == false) {
        var segment = $('.loadAccordion input');
        var priceContainer = $('#allCurrentOrderTotal');
    } else {
        var segment = $(storeSection).parents('table').find('input');
        var priceContainer = $(storeSection).parents('table').parent().parent().parent().find('.sectionTotal').find('strong'); 
    }
    var sectionTotal = 0;
    segment.each(function(index, data) {
        //console.log(this);
        var tempVar_A = $(this).attr('subtotal');
        if(typeof tempVar_A != 'undefined') {
            sectionTotal = parseFloat(sectionTotal) + parseFloat(tempVar_A);
        }
    });
    if(storeSection == false)
    {
        priceContainer.html(money_format(parseFloat(sectionTotal) + parseFloat(getTotalpriceFromOtherSections()), '$'));
    } else {
        priceContainer.html(money_format(sectionTotal, '$'));
    }
    if(storeSection != false) {
        var segmentHeading = $(storeSection).parents('table').parent().parent().parent().prev().find('.headingSubTotal');
        //console.log(segmentHeading);
        if(sectionTotal == 0) {
            segmentHeading.html('');
        } else {
            segmentHeading.html(money_format(sectionTotal, '$'));
        }
    } else {
        
    }
}

function calculateSectionPriceing()
{
    $('.loadAccordion div').each(function (index, data) {
        if($(this).hasClass('sectionTotal') || $(this).hasClass('headingSubTotal')) {} else {
            var sectionTotal = 0;
            $(this).children().find('input').each(function (indexb, datab) {
                //console.log(this);
                var tempVar_A = $(this).attr('subtotal');
                if(typeof tempVar_A != 'undefined') {
                    sectionTotal = parseFloat(sectionTotal) + parseFloat(tempVar_A);
                }
            });
            //console.log();
            if(sectionTotal > 0) {
                $(this).prev().find('.headingSubTotal').html(money_format(sectionTotal, '$'));
                $(this).children('.sectionTotal').children('strong').html(money_format(sectionTotal, '$'));
            }
        }
    });
}

function getTotalpriceFromOtherSections()
{
    if(typeof $('#storeOrderQuqeControl').attr('totalPrice') != 'undefined') {
        return $('#storeOrderQuqeControl').attr('totalPrice');
    }
    return 0;
}

$(document).ready(function() {
    listenStoreProduct();
    $('.loadAccordion input').each(function(index, data) {
        //console.log(this);
        var unitPrice = $(this).attr('price');
        var quantity  = $(this).val();
        //var tempVar_A = 0;
        if(quantity == '') {
            quantity = 0;
        }
        var subTotal = unitPrice * quantity;
        $(this).attr('subtotal', subTotal);
        //console.log(money_format(subTotal, '$'));
        //console.log($($(this).parent().parent().children().get(3)));
        $($(this).parent().parent().children().get(3)).html(money_format(subTotal, '$'));
        //calculateStorePriceing(this);
    });
    $('#continueStoreShopping').click(function() {
        window.location = "view/store";
    })
    $('#showOrderQuqe').click(function() {
        var anchorElem = $(this);
        $('#storeOrderQuqe').slideToggle('slow', function() {
             if(anchorElem.attr('status') == 'view') {
                 anchorElem.html('Close');
                 anchorElem.attr('status', 'close') ;
                 anchorElem.parent().css('margin-top', '0px');
                 anchorElem.parent().prev().css('margin-top', '-20px');
             } else {
                 anchorElem.html('View');
                 anchorElem.attr('status', 'view') ;
                 anchorElem.parent().css('margin-top', '-20px');
                 anchorElem.parent().prev().css('margin-top', '0px');
             }
        });
        return false;
    })
    $('#jobref').live('blur', function() {
        var url = 'system/stjobref/jobref/' + $(this).val();
        $.get(url, function(data) {});
    });
    calculateStorePriceing(false);
    calculateSectionPriceing();
    //setTimeout('listenToQuantityChange()', 100);
});