<?php
/* Generated on 14.02.18 14:28 by globalsync
 * $Id: $
 * $Log: $
 */

require_once 'EbatNs_FacetType.php';

class SortOrderCodeType extends EbatNs_FacetType
{
	const CodeType_Ascending = 'Ascending';
	const CodeType_Descending = 'Descending';
	const CodeType_CustomCode = 'CustomCode';

	/**
	 * @return 
	 **/
	function __construct()
	{
		parent::__construct('SortOrderCodeType', 'urn:ebay:apis:eBLBaseComponents');
	}
}
$Facet_SortOrderCodeType = new SortOrderCodeType();
?>