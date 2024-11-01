<?php
/* Generated on 14.02.18 14:28 by globalsync
 * $Id: $
 * $Log: $
 */

require_once 'EbatNs_FacetType.php';

class ItemSpecificSourceCodeType extends EbatNs_FacetType
{
	const CodeType_ItemSpecific = 'ItemSpecific';
	const CodeType_Attribute = 'Attribute';
	const CodeType_Product = 'Product';
	const CodeType_CustomCode = 'CustomCode';

	/**
	 * @return 
	 **/
	function __construct()
	{
		parent::__construct('ItemSpecificSourceCodeType', 'urn:ebay:apis:eBLBaseComponents');
	}
}
$Facet_ItemSpecificSourceCodeType = new ItemSpecificSourceCodeType();
?>