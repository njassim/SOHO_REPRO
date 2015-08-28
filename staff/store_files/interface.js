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
function roundNumber(num, dec) {
	var result = Math.round(num*Math.pow(10,dec))/Math.pow(10,dec);
	return result;
}

function CurrencyFormatted(amount)
{
	var i = parseFloat(amount);
	if(isNaN(i)) { i = 0.00; }
	var minus = '';
	if(i < 0) { minus = '-'; }
	i = Math.abs(i);
	i = parseInt((i + .005) * 100);
	i = i / 100;
	s = new String(i);
	if(s.indexOf('.') < 0) { s += '.00'; }
	if(s.indexOf('.') == (s.length - 2)) { s += '0'; }
	s = minus + s;
	return s;
        //return roundNumber(amount, 2);
}


var listdisplaystate = 'productlist';

var viewportwidth;
 var viewportheight;
 
 // the more standards compliant browsers (mozilla/netscape/opera/IE7) use window.innerWidth and window.innerHeight
 
 if (typeof window.innerWidth != 'undefined')
 {
      viewportwidth = window.innerWidth,
      viewportheight = window.innerHeight
 }
 
// IE6 in standards compliant mode (i.e. with a valid doctype as the first line in the document)

 else if (typeof document.documentElement != 'undefined'
     && typeof document.documentElement.clientWidth !=
     'undefined' && document.documentElement.clientWidth != 0)
 {
       viewportwidth = document.documentElement.clientWidth,
       viewportheight = document.documentElement.clientHeight
 }
 
 // older versions of IE
 
 else
 {
       viewportwidth = document.getElementsByTagName('body')[0].clientWidth,
       viewportheight = document.getElementsByTagName('body')[0].clientHeight
 }
 

/**
 * Juat a more meaningful name for jGrowl
 */
$.pushMessage = $.jGrowl;

/**
 * checks if the input variable is a instance of an object.
 * if it is an object true is returned, else false.
 */
function is_object(input)
{
    return typeof(input)=='object';
}

/**
 * Shows the Global Loader Animation. The Global loader is overlayed over the div with id
 * "contentHolder". For Global loader to work, the layout must have the div
 * with the given id.
 */
function showGlobalLoader()
{
   //$('body').ajaxLoader()
}


/**
 * Hides the Global Loader Animation.
 */
function hideGlobalLoader()
{
   //$('body').ajaxLoaderRemove();
}

/**
 * The Server may send JS function snippt through JSON. However due to security reasons the
 * function is recived by the Browser JS Framework as string and thus becomes non-usable.
 * These function snippts can be reactivated for exicution by passing the JSON through the
 * function reactivateJsFunctionsFromJSONconversion(JSON)
 */
function reactivateJsFunctionsFromJSONconversion(data)
{
    var responce = new Object();
    $.each(data, function(key, value) {
        if(is_object(value)) {
            responce[key] = reactivateJsFunctionsFromJSONconversion(value);
        } else {
            if(typeof(value) == 'string' && value.indexOf("function()") === 0) {
                responce[key] = eval('('+value+')');
            } else {
                responce[key] = value;
            }
        }
    });
    return responce;
}

/**
 * Listens for Gridload Load, by binding the click event of all DOM object with
 * class '.loadajax'
 */
function listenAjaxLoad()
{
    $('.loadajax').unbind('click');
    $('.loadajax').click(function () {
        var config = reactivateJsFunctionsFromJSONconversion($.parseJSON($(this).attr('data')));
        var url = $(this).attr('href');
        if(config.applyto == false) {
            $.get(url, function(data) {
                $.pushMessage('<span style="font-weight:normal;">' + data.responce + '</span>', {
                    header: data.heading,
                    life: 5000
                    //sticky: true
                });
                updateAllApplicableElements('table');
                updateAllApplicableElements('div');
            }, 'json');
        } else {

        }
        return false;
    });
}

/**
 * Listens for Gridload Load, by binding the click event of all DOM object with
 * class '.loadGrid'
 */
function listenGridLoad()
{
     /**/
     var allGrids = $(document).find('table');
     $.each(allGrids, function(key, value) {
         if($(value).attr('class') == 'loadGrid') {
             var config = $.parseJSON($(value).attr('data'));
             $(value).unbind('flexigrid');
             $(value).flexigrid(config);
         }
     });
    /**/
}

/**
 * Listens for Tab Load, by binding the click event of all DOM object with
 * class '.sohotab'
 */
function listenTabLoad()
{
    $('.sohotab').tabs({
        fx: {opacity: 'toggle'}
        //cookie: { expires: 10000 }
    })
}

function money_format(num, currency) {
    num = num.toString().replace(/\$|\,/g,'');
    if(isNaN(num))
    num = "0";
    sign = (num == (num = Math.abs(num)));
    num = Math.floor(num*100+0.50000000001);
    cents = num%100;
    num = Math.floor(num/100).toString();
    if(cents<10)
    cents = "0" + cents;
    for (var i = 0; i < Math.floor((num.length-(1+i))/3); i++)
    num = num.substring(0,num.length-(4*i+3))+','+
    num.substring(num.length-(4*i+3));
    return (((sign)?'':'-') + currency + num + '.' + cents);
}

function listenAccordionLoad()
{
    $('.loadAccordion').unbind('accordion');
    $('.loadAccordion').accordion({autoHeight: false});
    $('.loadAccordion input').unbind('blur');
    $('.loadAccordion input').blur(function () {
        //alert('value changed');
        var unitPrice = $(this).attr('price');
        var quantity  = $(this).val();
        //var tempVar_A = 0;
        if(quantity == '') {
            quantity = 0;
        }
        var subTotal = unitPrice * quantity;
        $(this).attr('subtotal', subTotal);
        //console.log(money_format(subTotal, '$'));
        $($($(this).parent().parent().parent().children().get(3)).children().get(0)).html(money_format(subTotal, '$'));
        calculateStorePriceing(this);
        calculateStorePriceing(false);
    });
}



/**
 * Listens for dialog Load, by binding the click event of all DOM object with
 * class '.loaddialog'
 */
function listenDialogLoad()
{
    $('.loaddialog').unbind('click');
    $('.loaddialog').click(function () {
        
        //showGlobalLoader();
        var url = $(this).attr('href');
        var data = reactivateJsFunctionsFromJSONconversion($.parseJSON($(this).attr('data')));
           
        
        if(typeof data.config['dialogid'] != 'undefined') {
            var holderID = data.config['dialogid'];
        } else {
            var holderID = Math.floor(Math.random()*1000001) + '_dialog';
        }
      
        //console.log(holderID);
        $('#dynamicAppender').append('<div id="' + holderID + '"></div>');
        $('#' + holderID).load(url, function() {
            $(".ui-dialog:hidden, .ui-dialog:hidden div").remove();
            $( "#" + holderID ).dialog( "destroy" );
            $( "#" + holderID ).dialog(data.config);
            //console.log(data.config);
            //hideGlobalLoader();
        });
        return false;
    })
}


function listenloaddialogserviceupdate ()
{
    $('.loaddialogserviceupdate ').unbind('click');
    $('.loaddialogserviceupdate ').click(function () {
        
        //showGlobalLoader();
        var url = $(this).attr('href');
        var holderID = Math.floor(Math.random()*1000001) + '_dialog';
        
        //alert('Hello World');
        //return false;
        //console.log(holderID);
        $('#dynamicAppender').append('<div id="' + holderID + '"></div>');
        $('#' + holderID).load(url, function() {
            $(".ui-dialog:hidden, .ui-dialog:hidden div").remove();
            $( "#" + holderID ).dialog( "destroy" );
            $( "#" + holderID ).dialog({
                width: '300px',
                height: '400px'
            });
            //console.log(data.config);
            //hideGlobalLoader();
        });
        return false;
    })
}

/**
 * Listens for activites in forms present in the DOM structure. Also validates
 * form input for forms created with the System Form API.
 */
function listenSystemFormInstance()
{
    //$('.formSaveButton').button();
    //$('.formSaveButton').css('margin-top', '10px');

    //$('.actionButton').button();
    //$('.actionButton').css('margin-top', '10px');

    /*
    $('.formSaveButton').unbind('click');
    $('.formSaveButton').click(function () {
        $(this).parents().find('form').submit();
    });*/

    $('.fancyMultiselect').unbind('multiselect');
    //$('.fancyMultiselect').multiselect();

    $('form.systemForm input:checkbox').css('width', '10px');
    $('form.systemForm input:radio').css('width', '10px');

    $('.required span').remove();

    $('form.systemForm input').unbind('focusout');
    $('form.systemForm input').focusout(function() {
        $('form.systemForm li').removeClass('focused');
    });
    $('form.systemForm select').unbind('focusout');
    $('form.systemForm select').focusout(function() {
        $('form.systemForm li').removeClass('focused');
    });
    $('form.systemForm textarea').unbind('focusout');
    $('form.systemForm textarea').focusout(function() {
        $('form.systemForm li').removeClass('focused');
    });
    $('form.systemForm input').unbind('focus');
    $('form.systemForm input').focus(function() {
        $(this).parents('li').addClass('focused');
    });
    $('form.systemForm select').unbind('focus');
    $('form.systemForm select').focus(function() {
        $(this).parents('li').addClass('focused');
    });
    $('form.systemForm textarea').unbind('focus');
    $('form.systemForm textarea').focus(function() {
        $(this).parents('li').addClass('focused');
    });
    
    $('form.validate input[type=hidden]').parents('li').css('display', 'none');
    $('form.validate input.donthideparent').parents('li').css('display', 'block');

    $('form.validate input, form.validate select').unbind('blur');
    $('form.validate input, form.validate select').blur(function() {
        var formid = $(this).parents().find('form').attr('id');
        var elementLabel = $(this).parent().parent().children('label');
        var elementObject = this;
        var elementID = $(this).attr('id');
        if($(this).hasClass('printofeach')) {} else {
            $.post('system/validateform/formname/' + formid, $("#" + formid).serialize(), function(data) {
                if(typeof data[elementID] != 'undefined') {
                    var errors = data[elementID];
                    var errorText = '<ul class="tiptiperror">';
                    for(errorKey in errors) {
                        errorText += '<li>' + errors[errorKey]  + '</li>';
                    }
                    errorText += '</ul>';
                    $(elementObject).addClass('errorinput');
                    $(elementLabel).addClass('errorinput');
                    $(elementObject).tipTip({maxWidth: "auto", edgeOffset: 10, content: errorText, activation: 'focus'});
                    /*
                    $.pushMessage(errorText, {
                        header: 'Error in ' + elementLabel.html(),
                        life: 5000
                        //sticky: true
                    });
                    */
                } else {
                    $(elementObject).removeClass('errorinput');
                    $(elementLabel).removeClass('errorinput');
                    $(elementObject).unbind('focus');
                    $(elementObject).focus(function() {
                        $(this).parent().parent().addClass('focused');
                    });
                }
            }, 'json');   
        }
    });
    var allSystemFormInput = $('form.systemForm').find('input');
    $.each(allSystemFormInput, function(key, value) {
         var errorTag = $(value).parent().children('ul.errors');
         if($(errorTag).hasClass('errors')) {
             var elementLabel = $(errorTag).parent().parent().children('label');
             var elementInput = $(errorTag).parent().children('input');
             $(elementInput).addClass('errorinput');
             $(elementLabel).addClass('errorinput');
             $(elementInput).tipTip({
                 maxWidth: "auto",
                 edgeOffset: 10,
                 content: $(errorTag).children('li').html(),
                 activation: 'focus'
             });
         }
    });
    $('form.systemForm label.required').unbind('append');
    $('form.systemForm label.required').append(' <span style="font-sixe:16px;font-weight:bold;">*</span> ');
}

function activateDatePicker()
{
    $(".datepicker").unbind('datepicker');
    $(".datepicker").datepicker();
}

function hideUserMessgeOnClick()
{
    $('#user_message').css('cursor', 'pointer');
    $('#user_message').click(function () {
        $(this).fadeOut();
    })
}

/**
 * Updates Dom elements, as per specified tags.
 */
function updateAllApplicableElements(elementList)
{
    var allElements = $('body').find(elementList);
    $.each(allElements, function(key, value) {
         var updateURL = $(value).attr('update');
         if(!updateURL) {} else {
             var container = $(value).parent();
             $(container).load(updateURL, function() {
                initBaseDisplay();
             });
         }
    });
    return false;
}

function updateElementById(element)
{
    var updateURL = $('#' + element).attr('update');
    if(updateURL == null) {
        $.pushMessage('Unable to update element "' + element + '". The update url seems to be missing. Please refresh you page manually for now.', {
              header: 'Element Update Failure !!',
              life: 10000
        });
        return false;
    }
    var container = $('#' + element).parent();
    $(container).load(updateURL, function() {
        initBaseDisplay();
    });
}

function listenDeleteAddressEntry()
{
    $('.deleteaddressentry').unbind('click');
    $('.deleteaddressentry').click(function () {
       var conff = confirm('Are you sure you want to delete the address?');
       return conff;
    });
}

function listenAddressNameChange()
{
    $('.addressName').unbind('change');
    $('.addressName').change(function () {
        var addressObj = $(this).parent().children('.addressData');
        $.get('view/getaddressdb/name/' + $(this).val() , function(addressBlock) {
            addressObj.html('');
            addressObj.html(addressBlock);
        });
    });
}

function listenproductdelete()
{
    $('.deleteproduct').unbind('click');
    $('.deleteproduct').click(function () {
        var conff = confirm('Are you sure you want to delete thos product?');
        return conff;
    });
}


function updateOrderStatus()
{
    $('#staffOrderStatus').unbind('click');
    $('#staffOrderStatus').click(function () {
        window.location = "admin/updateorderstatus/oid/" + $(this).attr('oid') + "/state/" + $(this).attr('state');
    });
}

function autocompleteJobrefference()
{
    $('#jobref').unbind('autocomplete');
    $('#jobref').unbind('focus');
    $('#jobref').autocomplete({
	source: "user/serachjobref/",        
        minLength: 0
    });
    //$('#jobref').focus(function () {
    //    $(this).autocomplete( "search", "showall" );
    //})
}

function setupServiceDistributionPage()
{
    //distributionset
   
    if(typeof $('#deliveryManagedBySohoRepro-Yes').attr('checked') != 'undefined' && $('#deliveryManagedBySohoRepro-Yes').attr('checked') == true) {
       $('.deliverShippingOptions').hide();
    } else {
       $('.deliverShippingOptions').show();
    }
    $('#deliveryManagedBySohoRepro-Yes').click(function() {
       if(typeof $(this).attr('checked') != 'undefined' && $(this).attr('checked') == true) {
           $('.deliverShippingOptions').hide();
       } else {
           $('.deliverShippingOptions').show();
       }
    })
   
    $('.addRedipientAction').unbind('click');
    $('.addRedipientAction').click(function() {
        var extensionOf = $(this).parents('li').prev().children().find('table');
        //console.log($(this).parents('li').prev().children());
        var currentProspectiveState = {};
        var countSet = $('.distributionObjectTable').length;
        var thisSetCount = countSet - 1;
        $.each($.parseJSON(extensionOf.attr('data')), function(key, data) {
            this.newValue = $('#distribution__' + this.jobref + '__'+ thisSetCount + '__'  + this.orderType + '__' + this.index + '__objects__' + this.objectIndex + '__print').val();
            currentProspectiveState[key] = this;
        });
        //console.log(currentProspectiveState);
        $.post('service/distributionset/setcount/' + countSet, currentProspectiveState, function(result) {
            extensionOf.parents('li').after(result);  
            if(typeof $('#deliveryManagedBySohoRepro-Yes').attr('checked') != 'undefined' && $('#deliveryManagedBySohoRepro-Yes').attr('checked') == true) {
               $('.deliverShippingOptions').hide();
            } else {
               $('.deliverShippingOptions').show();
            }
            //setupServiceDistributionPage();
        });
        //initBaseDisplay();
        return false;
    });
    $('#submitOrderForProcessing').unbind('click');
    $('#submitOrderForProcessing').click(function () {
        //console.log('About to submit order');
        $(this).html('Please Wait...');
        $(this).attr('disable', 'disable');
        window.location = "/service/confirm";
        return false;
    });
}



function listenJobSubmissionOptions()
{
    $('#jobsubmission').unbind('change');
    $('#jobsubmission').change(function () {
        var submissionType = $(this).val();
        if(submissionType == 'U') {
            /** /
            var holderID = Math.floor(Math.random()*1000001) + '_dialog';
            $('#dynamicAppender').append('<div id="' + holderID + '"></div>');
            $('#' + holderID).load('/service/fileuploadform', function() {
                $(".ui-dialog:hidden, .ui-dialog:hidden div").remove();
                $( "#" + holderID ).dialog( "destroy" );
                $( "#" + holderID ).dialog({
                    height: 140,
                    width:  450, 
                    modal: true,
                    resizable: false
                });
                //console.log(data.config);
                var targetUpload = holderID + '_uploadInterface'
                $('#jobfileuploadform').attr('target', targetUpload);
                $('#jobfileuploadform').unbind('submit');
                $('#jobfileuploadform').submit(function () {
                    var filetobeuploaded = $('#jobfileuploadform input[name=jobfile]').val();
                    var fileid = $('#jobfileuploadform input[name=uploadedfileid]').val();
                    $.get('/service/filegetregistration/file/' + filetobeuploaded + '/key/' + fileid, function(registation) {
                        //console.log(registation);
                        $('#jobsubmission').hide();
                        $('#jobsubmission').parent().append(
                            '<div style="margin-top:10px;font-size:15px;" id="'+ targetUpload +'_result"> <b>Uploaded File:</b> <a href="#">' + registation.filename + '</a> <div>' + 
                            '<div><input type="hidden" name="uploadedfileid" value="'+ registation.key +'"/></div>'
                        );
                    }, 'json');
                    //console.log('I have submitted');
                    window.open('/service/fileupload', targetUpload, 'scrollbars=no,menubar=no,height=150,width=300,resizable=no,toolbar=no,status=no');
                    $( "#" + holderID ).dialog( "destroy" );
                });
            });
            /**/
            $.get('/service/registerfilecontainer/', function(container) {
                 $('#jobsubmission').hide();
                 $('#jobsubmission').parent().append(
                     '<div class="jobsubmissionSelected"style="margin-top:10px;font-size:15px;"> Digital File Upload ... (<a href="#" onclick="return restoreJobOptionSelection();">Change</a>) </div>' + 
                     '<div class="jobsubmissionSelected"><input type="hidden" name="uploadedfileid" value="'+ container.id +'"/></div>'
                 );
                 window.open('/service/fileuploadform/key/' + container.id, '__df__' + container.id);
            }, 'json');
        } else if (submissionType == 'Y') {
            $('#jobsubmission').hide();
            $('#jobsubmission').parent().append(
                 '<div class="jobsubmissionSelected"style="margin-top:10px;font-size:15px;"> Sending File through yousendit.com. (<a href="#" onclick="return restoreJobOptionSelection();">Change</a>) </div>'
                 //'<div class="jobsubmissionSelected"><input type="hidden" name="uploadedfileid" value="'+ container.id +'"/></div>'
            );
            window.open('http://dropbox.yousendit.com/SohoRepro');
        } else if (submissionType == 'F') {
            $('#jobsubmission').hide();
            $('#jobsubmission').parent().append(
                 '<div class="jobsubmissionSelected"style="margin-top:10px;font-size:15px;"> Sending File through FTP. (<a href="#" onclick="return restoreJobOptionSelection();">Change</a>) </div>' + 
                 '<div class="jobsubmissionSelected" style="margin-top:10px;padding:5px;width:350px;background-color:#fffacd">' + 
                    'FTP Host: <br/>' +
                    '<input style="margin-bottom:5px;" type="text" value="" name="uploadedfileftp[host]" />' +
           
                    'FTP User: <br/>' +
                    '<input style="margin-bottom:5px;" type="text" value="" name="uploadedfileftp[user]" />' +
                
                    'FTP Password: <br/>' +
                    '<input style="margin-bottom:5px;" type="text" value="" name="uploadedfileftp[pass]" />' +
                
                    'File / Location: <br/>' +
                    '<input style="margin-bottom:5px;" type="text" value="" name="uploadedfileftp[file]" />' +
           
                '</div>'
            );
            
        }
        //console.log('I have been changed to ' + submissionType);
    });    
}

function restoreJobOptionSelection()
{
    //alert('Job selection option will be restored');
    $('.jobsubmissionSelected').css('display', 'none');
    $('.jobsubmissionSelected').html('');
    $('#jobsubmission').show();
    $('#jobsubmission').val('NA');
    return false;
}

function procesorginalOrdermetaDetails()
{
    //orginalOrdermetaDetails    
}

function listenAddNewAddress()
{
    $('.add_new_address').unbind('click');
    $('.add_new_address').click(function () {
        //alert('Will add new address');
        var holderID = Math.floor(Math.random()*1000001) + '_dialog';
        var setcount = $(this).attr('setcount');
        $('#dynamicAppender').append('<div id="' + holderID + '"></div>');
        $('#' + holderID).load('/user/newaddress/sc/' + setcount, function() {
            $(".ui-dialog:hidden, .ui-dialog:hidden div").remove();
            $( "#" + holderID ).dialog( "destroy" );
            $( "#" + holderID ).dialog({
                 width:  450, 
                 modal: true,
                 title: 'Add New Address', 
                 resizable: false
            });
        });
        return false;
    });
}

function listenNewaddressSubmission()
{
    $('#newaddress').unbind('submit');
    $('#newaddress').submit(function() {
       //alert('I was about to be saved');
       //console.log()
       var dialogObject = $(this).parent();
       /**/
       $.post($(this).attr('action'), $(this).serialize(), function (data) {
           //console.log(data);
           var addressholderid = 'dynaddresselem_' + data.setcount;
           $('#' + addressholderid + ' .addressName').append('<option value="'+data.name.id+'">'+data.name.data+'</option>');
           $('#' + addressholderid + ' .addressData').html('');
           $('#' + addressholderid + ' .addressData').append('<option value="'+data.address.id+'">'+data.address.data+'</option>');
           $('#' + addressholderid + ' .addressName').val(data.name.id);
           $('#' + addressholderid + ' .addressData').val(data.address.id);
           dialogObject.dialog( "destroy" );
       }, 'json');
       /**/
       return false;
    });
}

function manageservformdbfileds()
{
    $('.dbfields').each(function (key, value) {
        $(value).parents('li').width(240)
        .css('float', 'left')
        .css('clear', 'none');
    })
    $('.mdbfields').parents('label').width(360)
    .css('float', 'left')
    .css('clear', 'none')
    .css('margin-top', '5px');
}


function listenjsoselect()
{
    $('.jsoselect').unbind('change');
    $('.jsoselect').change(function () {
        var effect_div = $(this).attr('effectdiv');
        var joption = $(this).val();
        var order_id = $(this).attr('oid');
        //console.log(effect_div);
        $('#' + effect_div).css('background-color', '#fff');
        if(joption == 'UF') {
             $('#' + effect_div).html('<input type="file" id="'+ effect_div +'_file_upload" name="file_upload" /><input class="'+ effect_div +'_orderJobSubmissionActionLink" type="submit" value="Upload" style="cursor: pointer;font-size:12px; padding:1.5px; width: 100px;margin-top:14px; float:right; -moz-border-radius: 5px; -webkit-border-radius: 5px;border:1px solid #8f8f8f;"><div style="clear:both;"></div>');
             $('#' + effect_div +'_file_upload').uploadify({
                 'uploader'    : '/public/script/plugins/uploadify/uploadify.swf',
                 'script'      : '/public/script/plugins/uploadify/uploadify.php?oid=' + order_id, //'http://srepro.dc/service/jouploadfile/order/'+order_id+'/oindex/'+effect_div,
                 'cancelImg'   : '/public/script/plugins/uploadify/cancel.png',
                 'folder'      : 'public/script/plugins/uploads',
                 'multi'       : true
            });
            $('.'+ effect_div +'_orderJobSubmissionActionLink').click(function () {
                $('#' + effect_div +'_file_upload').uploadifyUpload();
                return false;
            });
        }
        if(joption == 'YS') {
            $('#' + effect_div).html('You have selected to send your job file through yousendit.com. Please remember to mention the order number (which is given on the top of this page), in your subject or message.');
            window.open('http://dropbox.yousendit.com/SohoRepro');
        }
        if(joption == 'FT') {
            $('#' + effect_div).html(
                 '<div class="jobsubmissionSelected" style="margin-top:10px;padding:5px;width:350px;background-color:#fffacd">' + 
                    'FTP Host: <br/>' +
                    '<input style="margin-bottom:5px;border:1px solid #ccc" type="text" value="" name="uploadedfileftp[host]" /> <br/>' +
           
                    'FTP User: <br/>' +
                    '<input style="margin-bottom:5px;border:1px solid #ccc" type="text" value="" name="uploadedfileftp[user]" /> <br/>' +
                
                    'FTP Password: <br/>' +
                    '<input style="margin-bottom:5px;border:1px solid #ccc" type="text" value="" name="uploadedfileftp[pass]" /> <br/>' +
                
                    'File / Location: <br/>' +
                    '<input style="margin-bottom:5px;border:1px solid #ccc" type="text" value="" name="uploadedfileftp[file]" />' +
           
                    '<input class="'+ effect_div +'_orderJobSubmissionActionLink" type="submit" value="Save" style="cursor: pointer;font-size:12px; padding:1.5px; width: 100px;margin-top:14px; float:right; -moz-border-radius: 5px; -webkit-border-radius: 5px;border:1px solid #8f8f8f;"><div style="clear:both;"></div>' +
           
                '</div>'
            );
        }
        if(joption == 'EM') {
            $('#' + effect_div).html('Email you job file at jobs@sohorepro.com. Please remember to mention the order number (which is given on the top of this page), in your subject or message.');
        }
        if(joption == 'ID') {
            $('#' + effect_div).html('You have selected the drop the job files at SohoRepro. Plesae bring a printed copy of the order along with the job file');
        }
        if(joption == 'PU') {
            $('#' + effect_div).html('We will collect the job file(s) from you. Our Representative will call you regarding the pickup.');
        }
    });    
}

function autocompleteCompanySearch()
{
    $('#companySearch').unbind('autocomplete');
    $('#companySearch').unbind('focus');
    $('#companySearch').autocomplete({
	source: "user/searchcompany/",
        minLength: 0
    });
    $('#companySearch').focus(function () {
        //$(this).autocomplete( "search", "showall" );
    })
}

function pingServer()
{
    $.get("/system/ping");
}


function shippingaddresssameasbillinaddress()
{
	$('#shipping_addressLineOne').parents('li').children('label').append('<a class="adresssameasbillingtoo" href="#">Same as Billing Address</a>');
	$('.adresssameasbillingtoo').click(function () {
		//alert('Hello World !!!');
		
		$('#shipping_addressLineOne').val($('#billing_addressLineOne').val());
		$('#shipping_addressLineTwo').val($('#billing_addressLineTwo').val());
		$('#shipping_addressLineThree').val($('#billing_addressLineThree').val());
		$('#shipping_addressLineFour').val($('#billing_addressLineFour').val());
		$('#shipping_addressCity').val($('#billing_addressCity').val());
		$('#shipping_addressState').val($('#billing_addressState').val());
		$('#shipping_addressZipCode').val($('#billing_addressZipCode').val());
		$('#shipping_addressCountry').val($('#billing_addressCountry').val());
		
		return false;
	});
}


/**
 * Loads all the requred listenrs and satisfies other requerments for initiating
 * Web 2.0 Browser Level Display Framework.
 */
function initBaseDisplay()
{
   shippingaddresssameasbillinaddress();
   listenSystemFormInstance();
   listenDialogLoad();
   listenGridLoad();
   listenTabLoad();
   listenAjaxLoad();
   hideUserMessgeOnClick();
   activateDatePicker();
   listenDeleteAddressEntry();
   listenAddressNameChange();
   listenproductdelete();
   updateOrderStatus();
   autocompleteJobrefference();
   listenAccordionLoad();
   setupServiceDistributionPage();
   listenJobSubmissionOptions();
   procesorginalOrdermetaDetails();
   listenAddNewAddress();
   listenNewaddressSubmission();
   manageservformdbfileds();
   listenjsoselect();
   autocompleteCompanySearch();
   
   
   setInterval("pingServer()",45000);
}

/**
 * Initiates Web 2.0 Browser Level Display Framework
 */
$(document).ready(function() {
    initBaseDisplay(); 
   // $.getScript("http://code.jquery.com/jquery-latest.js");
});