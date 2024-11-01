<?php
/* Generated on 14.02.18 14:28 by globalsync
 * $Id: $
 * $Log: $
 */

require_once 'EbatNs_FacetType.php';

class VeROReportPacketStatusCodeType extends EbatNs_FacetType
{
	const CodeType_Received = 'Received';
	const CodeType_InProcess = 'InProcess';
	const CodeType_Processed = 'Processed';
	const CodeType_CustomCode = 'CustomCode';

	/**
	 * @return 
	 **/
	function __construct()
	{
		parent::__construct('VeROReportPacketStatusCodeType', 'urn:ebay:apis:eBLBaseComponents');
	}
}
$Facet_VeROReportPacketStatusCodeType = new VeROReportPacketStatusCodeType();
?>