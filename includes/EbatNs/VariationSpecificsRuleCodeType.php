<?php
/* Generated on 14.02.18 14:28 by globalsync
 * $Id: $
 * $Log: $
 */

require_once 'EbatNs_FacetType.php';

class VariationSpecificsRuleCodeType extends EbatNs_FacetType
{
	const CodeType_Enabled = 'Enabled';
	const CodeType_Disabled = 'Disabled';
	const CodeType_CustomCode = 'CustomCode';

	/**
	 * @return 
	 **/
	function __construct()
	{
		parent::__construct('VariationSpecificsRuleCodeType', 'urn:ebay:apis:eBLBaseComponents');
	}
}
$Facet_VariationSpecificsRuleCodeType = new VariationSpecificsRuleCodeType();
?>