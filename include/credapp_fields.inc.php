<?php
define("COLSPAN", 0x00);
define("LABEL", 0x01);
define("NAME", 0x02);
define("TYPE", 0x03);
define("VALUE", 0x04);
define("REQD", 0x05);
define("ONCHG", 0x06);

$orgtype = array(
	"P" => "Proprietorship",
	"I" => "Individual",
	"2" => "Partnership",
	"C" => "Corporation"
);

$employees = array(
	"5" => "1-5 employees",
	"15" => "6-15 employees",
	"50" => "16-50 employees",
	"100" => "51-100 employees",
	"101" => "over 100 employees"
);

$btype = array(
	"1" => "Architect",
	"2" => "Ad or Design",
	"3" => "Industrial",
	"4" => "Engineering",
	"5" => "Municipal/Federal",
	"6" => "Schools/Universities",
	"7" => "General Office",
	"8" => "Construction",
	"9" => "Printing/News/Pub.",
	"10" => "Miscellaneous"
);

$field_list = array(
	array(array(8, "Company Information", "", "heading", "", false)),
	array(array(8, "Company", "company-name", "text", "", true)),
	array(array(4, "Address", "company-address", "text", "", true),array(4, "Room/Floor", "company-roomfloor", "text", "")),
	array(array(4, "City", "company-city", "text", "", true),array(2, "State", "company-state", "text", "", true),array(2, "ZIP", "company-zip", "text", "", true)),
	array(array(4, "Tel", "company-phone", "text", "", true),array(4, "Fax", "company-fax", "text", "", false)),
	array(array(8, "Accounts Payable Manager", "apmanager", "text", "", true)),
	array(array(8, "E-Mail", "company-email", "text", "", true)),
	array(array(8, "Years At This Location", "company-years", "text", "", true)),
	array(array(8, "Billing Address if different", "sep-billing", "checkbox", "1", false, "sepBilling()")),
	array(array(8, "<strong>Billing Address</strong>", "company-baddress", "text", "", false)),
	array(array(4, "City", "company-bcity", "text", "", false),array(2, "State", "company-bstate", "text", "", false),array(2, "ZIP", "company-bzip", "text", "", false)),
	array(array(4, "Tel", "company-bphone", "text", "", false),array(4, "Fax", "company-bfax", "text", "", false)),
	array(array(8, "Tax Exempt <a target='_blank' style='color:#00f;' href='/downloads/st121_1009_fill_in.pdf'>download form</a>", "tax-exempt", "checkbox", "", false)),
	array(array(8, "Resale Certificate <a target='_blank' style='color:#00f;' href='/downloads/ST120fillin.pdf'>download form</a>", "resale-certificate", "checkbox", "", false)),	
	array(array(8, "Type Of Organization", "", "heading", "", true)),
	array(array(2, "Proprietorship", "orgtype", "radio", "P", false), array(2, "Individual", "orgtype", "radio", "I", false), array(2, "Partnership", "orgtype", "radio", "2", false), array(2, "Corporation", "orgtype", "radio", "C", false)),
	array(array(8, "If division or subdivision, name of parent corp.", "parent", "text", "", false)),
	array(array(8, "Year of founding or incorporation", "founded", "text", "", false)),
	array(array(8, "President, Owner or Administrator", "president", "text", "", false)),
	array(array(8, "Owner's Home Address", "oaddress", "text", "", false)),
	array(array(8, "Owner's Home Telephone Number", "ophone", "text", "", false)),
	array(array(8, "Treasurer/Controller", "treasurer", "text", "", false)),
	array(array(8, "Approximate number in firm", "", "heading", "", false)),
	array(array(3, "Employees", "", "subheading", "", false), array(1, "1-5", "employees", "radio", "5", false), array(1, "6-15", "employees", "radio", "15", false), array(1, "16-50", "employees", "radio", "50", false), array(1, "51-100", "employees", "radio", "100", false), array(1, "over 100", "employees", "radio", "101", false)),
	array(array(8, "Business Type", "", "heading", "", false)),
	array(array(8, "Please check the category that best reflects the primary business of your company", "", "subheading", "", false)),
	array(array(4, "Architect", "btype", "radio", "1", false), array(4, "Schools/Universities", "btype", "radio", "6", false)),
	array(array(4, "Ad or Design", "btype", "radio", "2", false), array(4, "General Office", "btype", "radio", "7", false)),
	array(array(4, "Industrial", "btype", "radio", "3", false), array(4, "Construction", "btype", "radio", "8", false)),
	array(array(4, "Engineering", "btype", "radio", "4", false), array(4, "Printing/News/Pub.", "btype", "radio", "9", false)),
	array(array(4, "Municipal/Federal", "btype", "radio", "5", false), array(4, "Miscellaneous", "btype", "radio", "10", false)),
	array(array(8, "Please list the following individuals where applicable", "", "subheading", "", false)),
	array(array(4, "Marketing Mgr", "mmanager", "text", "", false),array(4, "Email", "mmanager-Email", "text", "", false)),
	array(array(4, "Design Mgr", "dmanager", "text", "", false),array(4, "Email", "dmanager-Email", "text", "", false)),
	array(array(4, "Office Mgr", "omanager", "text", "", false),array(4, "Email", "omanager-Email", "text", "", false)),
	array(array(4, "Facilities Mgr", "fmanager", "text", "", false),array(4, "Email", "fmanager-Email", "text", "", false)),
	array(array(8, "Trade Reference", "", "heading", "", false)),
	array(array(8, "Please do not use oil companies, credit cards, IBM, Xerox or public utilities as these firms will not confirm such information.", "", "subheading", "", false)),
	array(array(8, "Firm", "tr-firm-1", "text", "", false)),
	array(array(8, "Street", "tr-street-1", "text", "", false)),
	array(array(4, "City", "tr-city-1", "text", "", false), array(2, "State", "tr-state-1", "text", "", false), array(2, "ZIP", "tr-zip-1", "text", "", false)),
	array(array(4, "Telephone No.", "tr-phone-1", "text", "", false), array(4, "Account #", "tr-acct-1", "text", "", false)),
	array(array(4, "", "", "hr", "", false)),	
	array(array(8, "Firm", "tr-firm-2", "text", "", false)),
	array(array(8, "Street", "tr-street-2", "text", "", false)),
	array(array(4, "City", "tr-city-2", "text", "", false), array(2, "State", "tr-state-2", "text", "", false), array(2, "ZIP", "tr-zip-2", "text", "", false)),
	array(array(4, "Telephone No.", "tr-phone-2", "text", "", false), array(4, "Account #", "tr-acct-2", "text", "", false)),
	array(array(4, "", "", "hr", "", false)),
	array(array(8, "Firm", "tr-firm-3", "text", "", false)),
	array(array(8, "Street", "tr-street-3", "text", "", false)),
	array(array(4, "City", "tr-city-3", "text", "", false), array(2, "State", "tr-state-3", "text", "", false), array(2, "ZIP", "tr-zip-3", "text", "", false)),
	array(array(4, "Telephone No.", "tr-phone-3", "text", ""), array(4, "Account #", "tr-acct-3", "text", "", false)),	
	array(array(8, "Bank Reference", "", "heading", "", false)),
	array(array(8, "Name of Bank", "br-name", "text", "", false)),
	array(array(8, "Street", "br-street", "text", "", false)),
	array(array(4, "City", "br-city", "text", "", false), array(2, "State", "br-state", "text", "", false), array(2, "ZIP", "br-zip", "text", "", false)),
	array(array(8, "Telephone No.", "br-phone", "text", "", false)),
	array(array(8, "Bank Officer", "br-officer", "text", "", false)),
	array(array(8, "Date", "br-date", "text", "", false)),
	array(array(8, "Authorization for Bank Credit Inquiry", "", "heading", "", false)),
	array(array(8, "I hereby authorize", "bank-name", "text", "", false)),
	array(array(8, "to reveal normal credit information to the Credit Manager of Soho Reprograpics for the purpose of the establishment of trade credit.", "", "subheading", "", false)),
	array(array(8, "Name of Account", "bci-name", "text", "", false)),
	array(array(8, "Account Number", "bci-account", "text", "", false))
);
?>
