<?php
/**
 * ReturnPolicyDetails
 *
 * PHP version 5
 *
 * @category Class
 * @package  Swagger\Client
 * @author   Swagger Codegen team
 * @link     https://github.com/swagger-api/swagger-codegen
 */

/**
 * Metadata API
 *
 * The Metadata API has operations that retrieve configuration details pertaining to the different eBay marketplaces. In addition to marketplace information, the API also has operations that get information that helps sellers list items on eBay.
 *
 * OpenAPI spec version: v1.5.0
 * 
 * Generated by: https://github.com/swagger-api/swagger-codegen.git
 * Swagger Codegen version: 3.0.32
 */
/**
 * NOTE: This class is auto generated by the swagger code generator program.
 * https://github.com/swagger-api/swagger-codegen
 * Do not edit the class manually.
 */

namespace Swagger\Client\Model;

use \ArrayAccess;
use \Swagger\Client\ObjectSerializer;

/**
 * ReturnPolicyDetails Class Doc Comment
 *
 * @category Class
 * @description This container defines the category policies that relate to domestic and international return policies (the return shipping is made via a domestic or an international shipping service, respectively).
 * @package  Swagger\Client
 * @author   Swagger Codegen team
 * @link     https://github.com/swagger-api/swagger-codegen
 */
class ReturnPolicyDetails implements ModelInterface, ArrayAccess
{
    const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      *
      * @var string
      */
    protected static $swaggerModelName = 'ReturnPolicyDetails';

    /**
      * Array of property to type mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerTypes = [
        'policy_description_enabled' => 'bool',
'refund_methods' => 'string[]',
'return_methods' => 'string[]',
'return_periods' => '\Swagger\Client\Model\TimeDuration[]',
'returns_acceptance_enabled' => 'bool',
'return_shipping_cost_payers' => 'string[]'    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerFormats = [
        'policy_description_enabled' => null,
'refund_methods' => null,
'return_methods' => null,
'return_periods' => null,
'returns_acceptance_enabled' => null,
'return_shipping_cost_payers' => null    ];

    /**
     * Array of property to type mappings. Used for (de)serialization
     *
     * @return array
     */
    public static function swaggerTypes()
    {
        return self::$swaggerTypes;
    }

    /**
     * Array of property to format mappings. Used for (de)serialization
     *
     * @return array
     */
    public static function swaggerFormats()
    {
        return self::$swaggerFormats;
    }

    /**
     * Array of attributes where the key is the local name,
     * and the value is the original name
     *
     * @var string[]
     */
    protected static $attributeMap = [
        'policy_description_enabled' => 'policyDescriptionEnabled',
'refund_methods' => 'refundMethods',
'return_methods' => 'returnMethods',
'return_periods' => 'returnPeriods',
'returns_acceptance_enabled' => 'returnsAcceptanceEnabled',
'return_shipping_cost_payers' => 'returnShippingCostPayers'    ];

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var string[]
     */
    protected static $setters = [
        'policy_description_enabled' => 'setPolicyDescriptionEnabled',
'refund_methods' => 'setRefundMethods',
'return_methods' => 'setReturnMethods',
'return_periods' => 'setReturnPeriods',
'returns_acceptance_enabled' => 'setReturnsAcceptanceEnabled',
'return_shipping_cost_payers' => 'setReturnShippingCostPayers'    ];

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var string[]
     */
    protected static $getters = [
        'policy_description_enabled' => 'getPolicyDescriptionEnabled',
'refund_methods' => 'getRefundMethods',
'return_methods' => 'getReturnMethods',
'return_periods' => 'getReturnPeriods',
'returns_acceptance_enabled' => 'getReturnsAcceptanceEnabled',
'return_shipping_cost_payers' => 'getReturnShippingCostPayers'    ];

    /**
     * Array of attributes where the key is the local name,
     * and the value is the original name
     *
     * @return array
     */
    public static function attributeMap()
    {
        return self::$attributeMap;
    }

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @return array
     */
    public static function setters()
    {
        return self::$setters;
    }

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @return array
     */
    public static function getters()
    {
        return self::$getters;
    }

    /**
     * The original name of the model.
     *
     * @return string
     */
    public function getModelName()
    {
        return self::$swaggerModelName;
    }

    

    /**
     * Associative array for storing property values
     *
     * @var mixed[]
     */
    protected $container = [];

    /**
     * Constructor
     *
     * @param mixed[] $data Associated array of property values
     *                      initializing the model
     */
    public function __construct(array $data = null)
    {
        $this->container['policy_description_enabled'] = isset($data['policy_description_enabled']) ? $data['policy_description_enabled'] : null;
        $this->container['refund_methods'] = isset($data['refund_methods']) ? $data['refund_methods'] : null;
        $this->container['return_methods'] = isset($data['return_methods']) ? $data['return_methods'] : null;
        $this->container['return_periods'] = isset($data['return_periods']) ? $data['return_periods'] : null;
        $this->container['returns_acceptance_enabled'] = isset($data['returns_acceptance_enabled']) ? $data['returns_acceptance_enabled'] : null;
        $this->container['return_shipping_cost_payers'] = isset($data['return_shipping_cost_payers']) ? $data['return_shipping_cost_payers'] : null;
    }

    /**
     * Show all the invalid properties with reasons.
     *
     * @return array invalid properties with reasons
     */
    public function listInvalidProperties()
    {
        $invalidProperties = [];

        return $invalidProperties;
    }

    /**
     * Validate all the properties in the model
     * return true if all passed
     *
     * @return bool True if all properties are valid
     */
    public function valid()
    {
        return count($this->listInvalidProperties()) === 0;
    }


    /**
     * Gets policy_description_enabled
     *
     * @return bool
     */
    public function getPolicyDescriptionEnabled()
    {
        return $this->container['policy_description_enabled'];
    }

    /**
     * Sets policy_description_enabled
     *
     * @param bool $policy_description_enabled If set to <code>true</code>, this flag indicates you can supply a detailed return policy description within your return policy (for example, by populating the <b>returnInstructions</b> field in the Account API's <b>createReturnPolicy</b>). User-supplied return policy details are allowed only in the DE, ES, FR, and IT marketplaces.
     *
     * @return $this
     */
    public function setPolicyDescriptionEnabled($policy_description_enabled)
    {
        $this->container['policy_description_enabled'] = $policy_description_enabled;

        return $this;
    }

    /**
     * Gets refund_methods
     *
     * @return string[]
     */
    public function getRefundMethods()
    {
        return $this->container['refund_methods'];
    }

    /**
     * Sets refund_methods
     *
     * @param string[] $refund_methods A list of refund methods allowed for the associated category.
     *
     * @return $this
     */
    public function setRefundMethods($refund_methods)
    {
        $this->container['refund_methods'] = $refund_methods;

        return $this;
    }

    /**
     * Gets return_methods
     *
     * @return string[]
     */
    public function getReturnMethods()
    {
        return $this->container['return_methods'];
    }

    /**
     * Sets return_methods
     *
     * @param string[] $return_methods A list of return methods allowed for the associated category.
     *
     * @return $this
     */
    public function setReturnMethods($return_methods)
    {
        $this->container['return_methods'] = $return_methods;

        return $this;
    }

    /**
     * Gets return_periods
     *
     * @return \Swagger\Client\Model\TimeDuration[]
     */
    public function getReturnPeriods()
    {
        return $this->container['return_periods'];
    }

    /**
     * Sets return_periods
     *
     * @param \Swagger\Client\Model\TimeDuration[] $return_periods A list of return periods allowed for the associated category.  <br><br>Note that different APIs require you to enter the return period in different ways. For example, the Account API uses the complex <b>TimeDuration</b> type, which takes two values (a <b>unit</b> and a <b>value</b>), whereas the Trading API takes a single value (such as <code>Days_30</code>).
     *
     * @return $this
     */
    public function setReturnPeriods($return_periods)
    {
        $this->container['return_periods'] = $return_periods;

        return $this;
    }

    /**
     * Gets returns_acceptance_enabled
     *
     * @return bool
     */
    public function getReturnsAcceptanceEnabled()
    {
        return $this->container['returns_acceptance_enabled'];
    }

    /**
     * Sets returns_acceptance_enabled
     *
     * @param bool $returns_acceptance_enabled If set to <code>true</code>, this flag indicates the seller can configure how they handle domestic returns.
     *
     * @return $this
     */
    public function setReturnsAcceptanceEnabled($returns_acceptance_enabled)
    {
        $this->container['returns_acceptance_enabled'] = $returns_acceptance_enabled;

        return $this;
    }

    /**
     * Gets return_shipping_cost_payers
     *
     * @return string[]
     */
    public function getReturnShippingCostPayers()
    {
        return $this->container['return_shipping_cost_payers'];
    }

    /**
     * Sets return_shipping_cost_payers
     *
     * @param string[] $return_shipping_cost_payers A list of allowed values for who pays for the return shipping cost.  <br><br>Note that for SNAD returns, the seller is always responsible for the return shipping cost.
     *
     * @return $this
     */
    public function setReturnShippingCostPayers($return_shipping_cost_payers)
    {
        $this->container['return_shipping_cost_payers'] = $return_shipping_cost_payers;

        return $this;
    }
    /**
     * Returns true if offset exists. False otherwise.
     *
     * @param integer $offset Offset
     *
     * @return boolean
     */
    public function offsetExists($offset)
    {
        return isset($this->container[$offset]);
    }

    /**
     * Gets offset.
     *
     * @param integer $offset Offset
     *
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return isset($this->container[$offset]) ? $this->container[$offset] : null;
    }

    /**
     * Sets value based on offset.
     *
     * @param integer $offset Offset
     * @param mixed   $value  Value to be set
     *
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->container[] = $value;
        } else {
            $this->container[$offset] = $value;
        }
    }

    /**
     * Unsets offset.
     *
     * @param integer $offset Offset
     *
     * @return void
     */
    public function offsetUnset($offset)
    {
        unset($this->container[$offset]);
    }

    /**
     * Gets the string presentation of the object
     *
     * @return string
     */
    public function __toString()
    {
        if (defined('JSON_PRETTY_PRINT')) { // use JSON pretty print
            return json_encode(
                ObjectSerializer::sanitizeForSerialization($this),
                JSON_PRETTY_PRINT
            );
        }

        return json_encode(ObjectSerializer::sanitizeForSerialization($this));
    }
}
