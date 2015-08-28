<?php
/*
 * (c) 2008 Gigantic, Inc., All Rights Reserved
 * $Id: user_status.class.php,v 1.3 2009/03/09 05:23:14 tredman Exp $
 */

require_once("include/config.inc.php");
require_once($_SERVER["DOCUMENT_ROOT"] . SOHO_BASE_HREF . "/include/session.class.php");
require_once($_SERVER["DOCUMENT_ROOT"] . SOHO_BASE_HREF . "/include/user.class.php");
require_once($_SERVER["DOCUMENT_ROOT"] . SOHO_BASE_HREF . "/include/order_master.class.php");

class User_Status
{
	var $status_message;

	function User_Status($user_id)
	{
		$user = new User($user_id);
		if ($user->id > 0) {
			$user->get_open_orders_count();
			$user->get_closed_orders_count();
			$this->status_message = sprintf(
				"User %s is logged in<br>" .
				"Signed on since %s on %s.<br>" .
				"You have %d open order%s. %s<br>" .
				"You have %d closed order%s. %s<br>" .
				"<a href=\"view_cart.php\">View Your Cart</a>&nbsp;&nbsp;" .
				"<a href=\"changepw.php\">Change Password</a>&nbsp;&nbsp;" .
				"<a href=\"javascript:if(confirm('Are you sure you want to sign off?')){document.location='logout_process.php'}\">Log Out</a>",
				$user->login_email,
				date("g:i A"),
				date("m/d/Y"),
				$user->open_orders_count,
				($user->open_orders_count) == 1 ? "" : "s",
				($user->open_orders_count > 0) ? "<a href=\"order_details.php\">(Click for details)</a>" : "",
				$user->closed_orders_count,
				($user->closed_orders_count) == 1 ? "" : "s",
				($user->closed_orders_count) > 0 ? "<a href=\"order_details.php?h=1\">(Click for details)</a>" : ""
			);
		}
	}
	
}
?>