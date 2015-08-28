<?php
/*
 * (c) 2007 Gigantic, Inc., All Rights Reserved
 * $Id: login_table.inc.php,v 1.2 2007/08/17 03:20:51 tredman Exp $
 */
?>
<div id="mainLoginTable">
	<div class="style8" id="loginSignIn">Sign In</div> 
	<div id="loginLeftInfo" class="style7a">
		<span class="cartCategory style9">Returning Customers</span><br /><br />
		<span class="bodyWhite">Please sign in before continuing for access to convenient features and quick online ordering.</span><br><br>
		<form method="POST" action="login_process.php" onsubmit="return check_fields(this)">
			<input name="try" type="hidden" value="1">
			<table width="330" border="0" cellspacing="2" cellpadding="0">
				<tr>
					<td width="95" align="right" class="style7a">Email Address:</td>
					<td width="229" align="left" style="padding-left:10px">
						<input class="bodyLink" id="email" name="email" type="text" size="25" maxlength="128" <?php printf("value=\"%s\"", $user->login_email); ?>/>
					</td>
				</tr>
				<tr>
					<td align="right" class="style7a">Password:</td>
					<td style="padding-left:10px"><input class="bodyLink" id="passwd" name="passwd" type="password" size="25" maxlength="32" />	</td>
				</tr>
<?php
if (intval($_REQUEST["L"]) == 1) {
?>
				<tr>
					<td><div align="right"><span class="captionbutton">Password Hint:</span></div></td>
					<td>
						<img src="images/spacer.gif" width="10" height="20" />
						<span class="bodyLink"><?php echo($user->pwhint); ?></span>
					</td>
				</tr>
<?php
} else {
?>
				<tr>
					<td><img src="images/spacer.gif" width="83" height="20" /></td>
					<td><img src="images/spacer.gif" width="207" height="20" /></td>
				</tr>
<?php
}
?>
				<tr>
					<td>&nbsp;</td>
<?php
if (intval($_REQUEST["L"]) == 0) {
?>
					<td><span class="captionbutton"><a href="javascript:remindpw()">I forgot my password</a></span></td>
<?php
} elseif (intval($_REQUEST["L"]) == 1) {
?>
					<td><span class="captionbutton"><a href="javascript:resetpw()">I still can't remember my password.</a></span></td>
<?php
}
?>
				</tr>
			</table>
			<div id="loginBottomDotted" align="right"><input type="submit" name="Submit" value="Sign In" /></div>
		</form>
	</div>
	<div id="loginRightInfo">
		<p>
			<span class="cartCategory style9 style10">New Customers</span><br />
			<span class="style11">
				<br />
				<span class="bodyWhite">Register with Soho Repro to use convenient features and quick online ordering.</span>
			</span>
		</p>
		<form method="POST" action="account.php">
			<table width="352" border="0" cellspacing="2" cellpadding="0">
				<tr>
					<td width="109" align="right" class="style7a">Email Address:</td>
					<td width="243" align="left">
						<img src="images/spacer.gif" width="20" height="20" />
						<input class="bodyLink"  name="email" type="text" size="25" />
					</td>
				</tr>
			</table>
			<div id="loginBottomDotted" align="right">
				<input type="submit" name="Submit2" value="Register" />
			</div>
		</form>
	</div>
</div>
