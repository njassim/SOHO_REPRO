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

function comfirmUserProfileSuspend()
{
    $('.userprofilesuspend').unbind('click');
    $('.userprofilesuspend').click(function() {
        var username = $(this).parents('ul').attr('user');
        var responce = confirm(
             'You are about to supend the account of ' + username + '. On doing so '
           + 'the mentioned user won\'t be able to login to his/her account. Are you '
           + 'sure you want to suspend this user\'s account? '
        );
        return responce;
    });
}

function comfirmUserProfileDelete()
{
    $('.userprofiledelete').unbind('click');
    $('.userprofiledelete').click(function() {
        var username = $(this).parents('ul').attr('user');
        var responce = confirm(
             'You are about to delete the account of ' + username + '. Data related '
           + 'to the mentioned user will be removed. This can\'t be undone. Are you '
           + 'sure you want to delete this user\'s account? '
        );
        return responce;
    });
}

function initSohoRepro()
{
    comfirmUserProfileSuspend();
    comfirmUserProfileDelete();
}

$(document).ready(function() {
    initSohoRepro();
});