<?php
/* Generated on 14.02.18 14:28 by globalsync
 * $Id: $
 * $Log: $
 */

require_once 'EbatNs_FacetType.php';

class RefundFailureCodeType extends EbatNs_FacetType
{
	const CodeType_PaypalBillingAgreementCanceled = 'PaypalBillingAgreementCanceled';
	const CodeType_PaypalRiskDeclinesTransaction = 'PaypalRiskDeclinesTransaction';
	const CodeType_CustomCode = 'CustomCode';

	/**
	 * @return 
	 **/
	function __construct()
	{
		parent::__construct('RefundFailureCodeType', 'urn:ebay:apis:eBLBaseComponents');
	}
}
$Facet_RefundFailureCodeType = new RefundFailureCodeType();
?>