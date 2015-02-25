<?php
	// Updated 04.18.2003
	// use this include to pull the values from ENOM object into local php page variables
	// assumes that the object has been created and the command GetContacts has been issued
	
	// REGISTRANT CONTACT INFORMATION
		
	$RegistrantOrganizationName		= $Enom->Values[ "RegistrantOrganizationName" ];
	$RegistrantFirstName			= $Enom->Values[ "RegistrantFirstName" ];
	$RegistrantLastName				= $Enom->Values[ "RegistrantLastName" ];
	$RegistrantJobTitle				= $Enom->Values[ "RegistrantJobTitle" ];
	$RegistrantAddress1				= $Enom->Values[ "RegistrantAddress1" ];
	$RegistrantAddress2				= $Enom->Values[ "RegistrantAddress1" ];
	$RegistrantCity					= $Enom->Values[ "RegistrantCity" ];
	$RegistrantStateProvince		= $Enom->Values[ "RegistrantStateProvince" ];
	$RegistrantStateProvinceChoice	= $Enom->Values[ "RegistrantStateProvinceChoice" ];
	$RegistrantPostalCode			= $Enom->Values[ "RegistrantPostalCode" ];
	$RegistrantCountry				= $Enom->Values[ "RegistrantCountry" ];
	$RegistrantPhone				= $Enom->Values[ "RegistrantPhone" ];
	$RegistrantFax					= $Enom->Values[ "RegistrantFax" ];
	$RegistrantEmailAddress			= $Enom->Values[ "RegistrantEmailAddress" ];
	
	// ADMIN CONTACT INFORMATION
		
	$AdminOrganizationName		= $Enom->Values[ "AdminOrganizationName" ];
	$AdminFirstName				= $Enom->Values[ "AdminFirstName" ];
	$AdminLastName				= $Enom->Values[ "AdminLastName" ];
	$AdminJobTitle				= $Enom->Values[ "AdminJobTitle" ];
	$AdminAddress1				= $Enom->Values[ "AdminAddress1" ];
	$AdminAddress2				= $Enom->Values[ "AdminAddress1" ];
	$AdminCity					= $Enom->Values[ "AdminCity" ];
	$AdminStateProvince			= $Enom->Values[ "AdminStateProvince" ];
	$AdminStateProvinceChoice	= $Enom->Values[ "AdminStateProvinceChoice" ];
	$AdminPostalCode			= $Enom->Values[ "AdminPostalCode" ];
	$AdminCountry				= $Enom->Values[ "AdminCountry" ];
	$AdminPhone					= $Enom->Values[ "AdminPhone" ];
	$AdminFax					= $Enom->Values[ "AdminFax" ];
	$AdminEmailAddress			= $Enom->Values[ "AdminEmailAddress" ];

	// TECHNICAL CONTACT INFORMATION
	$TechOrganizationName		= $Enom->Values[ "TechOrganizationName" ];
	$TechFirstName				= $Enom->Values[ "TechFirstName" ];
	$TechLastName				= $Enom->Values[ "TechLastName" ];
	$TechJobTitle				= $Enom->Values[ "TechJobTitle" ];
	$TechAddress1				= $Enom->Values[ "TechAddress1" ];
	$TechAddress2				= $Enom->Values[ "TechAddress1" ];
	$TechCity					= $Enom->Values[ "TechCity" ];
	$TechStateProvince			= $Enom->Values[ "TechStateProvince" ];
	$TechStateProvinceChoice	= $Enom->Values[ "TechStateProvinceChoice" ];
	$TechPostalCode				= $Enom->Values[ "TechPostalCode" ];
	$TechCountry				= $Enom->Values[ "TechCountry" ];
	$TechPhone					= $Enom->Values[ "TechPhone" ];
	$TechFax					= $Enom->Values[ "TechFax" ];
	$TechEmailAddress			= $Enom->Values[ "TechEmailAddress" ];

	// AUX BILLING CONTACT INFORMATION
	$AuxBillingOrganizationName				= $Enom->Values[ "AuxBillingOrganizationName" ];
	$AuxBillingFirstName					= $Enom->Values[ "AuxBillingFirstName" ];
	$AuxBillingLastName						= $Enom->Values[ "AuxBillingLastName" ];
	$AuxBillingJobTitle						= $Enom->Values[ "AuxBillingJobTitle" ];
	$AuxBillingAddress1						= $Enom->Values[ "AuxBillingAddress1" ];
	$AuxBillingAddress2						= $Enom->Values[ "AuxBillingAddress1" ];
	$AuxBillingCity							= $Enom->Values[ "AuxBillingCity" ];
	$AuxBillingStateProvince				= $Enom->Values[ "AuxBillingStateProvince" ];
	$AuxBillingStateProvinceChoice			= $Enom->Values[ "AuxBillingStateProvinceChoice" ];
	$AuxBillingPostalCode					= $Enom->Values[ "AuxBillingPostalCode" ];
	$AuxBillingCountry						= $Enom->Values[ "AuxBillingCountry" ];
	$AuxBillingPhone						= $Enom->Values[ "AuxBillingPhone" ];
	$AuxBillingFax							= $Enom->Values[ "AuxBillingFax" ];
	$AuxBillingEmailAddress					= $Enom->Values[ "AuxBillingEmailAddress" ];
	
	//US NEXUS INFO
	$foo = $Enom->Values[ "Nexus" ];
	$nexusC = strlen($foo);
	if ($nexusC > 3) {
		$foobar = substr($foo,0,3);
		$NexusCategory					= $foobar;
	}	
	else {
		$NexusCategory					= $foo;
	}
	$AppPurpose							= $Enom->Values[ "Purpose" ];
	
	//CA INFO
	$cira_legal_type					= $Enom->Values[ "cira_legal_type" ];
	
	//UK NEXUS INFO
	$uk_reg_co_no					= $Enom->Values[ "uk_reg_co_no" ];
	$uk_legal_type					= $Enom->Values[ "uk_legal_type" ];
?>
