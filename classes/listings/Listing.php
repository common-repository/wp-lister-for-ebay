<?php

namespace WPLab\Ebay\Listings;

use WPLab\Ebay\Listings;

class Listing {

	const STATUS_PREPARED   = 'prepared';
	const STATUS_ONLINE     = 'online';
	const STATUS_CHANGED    = 'changed';
	const STATUS_ARCHIVED   = 'archived';

	const TYPE_AUCTION = 'Chinese';
	const TYPE_FIXED_PRICE = 'FixedPriceItem';
	const TYPE_CLASSIFIED_AD = 'ClassifiedAd';

	const DURATION_DAYS_1 = 'Days_1';
	const DURATION_DAYS_3 = 'Days_3';
	const DURATION_DAYS_5 = 'Days_5';
	const DURATION_DAYS_7 = 'Days_7';
	const DURATION_DAYS_10 = 'Days_10';
	const DURATION_DAYS_14 = 'Days_14';
	const DURATION_DAYS_28 = 'Days_28';
	const DURATION_DAYS_30 = 'Days_30';
	const DURATION_DAYS_60 = 'Days_60';
	const DURATION_DAYS_90 = 'Days_90';
	const DURATION_GTC = 'GTC';


	protected $data = array(
		'id' => 0,
		'ebay_id' => '',
		'title' => '',
		'content' => '',
		'type' => '',
		'duration' => '',
		'date_created' => '',
		'date_published' => '',
		'date_finished' => '',
		'end_date' => '',
		'relist_date' => '',
		'price' => '',
		'quantity' => '',
		'quantity_sold' => '',
		'status' => '',
		'locked' => '',
		'details' => '',
		'product_properties' => '',
		'variations' => '',
		'view_item_url' => '',
		'gallery_url' => '',
		'post_id' => '',
		'parent_id' => '',
		'profile_id' => '',
		'profile_data' => [],
		'template' => '',
		'fees' => '',
		'history' => '',
		'last_errors' => '',
		'eps' => '',
		'account_id' => '',
		'site_id' => ''
	);

	protected $product_props = [
		'_sku' => 'SKU',
		'_ebay_title' => 'Listing Title',
		'_ebay_subtitle' => 'Listing Subtitle',
		'_ebay_global_shipping' => 'Global Shipping',
		'_ebay_ebayplus_enabled'    => 'eBay Plus',
		'_ebay_payment_instructions'    => 'Payment Instructions',
		'_ebay_condition_id' => 'Condition',
		'_ebay_condition_description'   => 'Condition Description',
		'_ebay_professional_grader' => 'Professional Grader',
		'_ebay_grade'   => 'Grade',
		'_ebay_certification_number'    => 'Certification Number',
		'_ebay_listing_duration'    => 'Listing Duration',
		'_ebay_auction_type'    => 'Listing Type',
		'_ebay_start_price' => 'Start Price',
		'_ebay_reserve_price'   => 'Reserve Price',
		'_ebay_buynow_price' => 'Buy It Now Price',
		'_ebay_upc' => 'UPC',
		'_ebay_ean' => 'EAN',
		'_ebay_isbn'    => 'ISBN',
		'_ebay_mpn' => 'MPN',
		'_ebay_brand'   => 'Brand',
		'_ebay_epid'    => 'EPID',
		'_ebay_category_1_id'   => 'Primary eBay Category',
		'_ebay_category_2_id'   => 'Secondary eBay Category',
		'_ebay_store_category_1_id' => 'Primary Store Category',
		'_ebay_store_category_2_id' => 'Secondary Store Category',
		'_ebay_gallery_image_url'  => 'Custom Gallery URL',
		'_ebay_seller_payment_profile_id'   => 'Payment Profile ID',
		'_ebay_seller_return_profile_id'    => 'Return Profile ID',
		'_ebay_bestoffer_enabled'   => 'Best Offer',
		'_ebay_bo_autoaccept_price' => 'Auto-Accept Price',
		'_ebay_bo_minimum_price'    => 'Minimum Price',
		'_ebay_item_specifics'      => 'Item Specifics',
		'_ebay_autopay' => 'Auto Pay'
	];

	/**
	 * @var array List of changes to be saved
	 */
	private $changes = [];

	private array $listingData;

	/**
	 * @var \ListingsModel
	 */
	private \ListingsModel $listingModel;

	private ProfileData $profileData;

	private ?\WC_Product $product = null;

	/**
	 * @param int $id The Listing ID
	 */
	public function __construct( $id = null ) {
		if ( $id ) {
			$this->loadListing( $id );
		}

		$this->listingModel = new \ListingsModel();
	}

	private function loadListing( $id ) {
		$item_array = \ListingsModel::getItem( $id );

		if ( $item_array ) {
			$this->setId( $id );
			$this->populateData( $item_array );
		}
	}

	private function populateData( $data_array ) {
		//$profile = new Profile($data_array['profile_id']);
		$details = wple_json_validate($data_array['details']) ? json_decode( $data_array['details'], true ) : maybe_unserialize( $data_array['details'] );
		$this->data = [
			'id'                => $data_array['id'],
			'ebay_id'           => $data_array['ebay_id'],
			'title'             => $data_array['auction_title'],
			'content'           => $data_array['post_content'],
			'type'              => $data_array['auction_type'],
			'duration'          => $data_array['listing_duration'],
			'date_created'      => $data_array['date_created'],
			'date_published'    => $data_array['date_published'],
			'date_finished'     => $data_array['date_finished'],
			'end_date'          => $data_array['end_date'],
			'relist_date'       => $data_array['relist_date'],
			'price'             => $data_array['price'],
			'quantity'          => $data_array['quantity'],
			'quantity_sold'     => $data_array['quantity_sold'],
			'status'            => $data_array['status'],
			'locked'            => $data_array['locked'],
			'details'           => $details,
			'product_properties'=> $this->loadProductProperties( $data_array['post_id'] ),
			'variations'        => maybe_unserialize( $data_array['variations'] ),
			'view_item_url'     => $data_array['ViewItemURL'],
			'gallery_url'       => $data_array['GalleryURL'],
			'post_id'           => $data_array['post_id'],
			'parent_id'         => $data_array['parent_id'],
			'profile_id'        => $data_array['profile_id'],
			'profile_data'      => $data_array['profile_data'],
			'template'          => $data_array['template'],
			'fees'              => $data_array['fees'],
			'history'           => $data_array['history'],
			'last_errors'       => maybe_unserialize( $data_array['last_errors'] ),
			'eps'               => $data_array['eps'],
			'account_id'        => $data_array['account_id'],
			'site_id'           => $data_array['site_id'],
		];
	}

	public function getId() {
		return $this->data['id'];
	}

	public function setId( $id ) {
		$this->data['id'] = $id;
		//$this->markChanged( 'id' );
		return $this;
	}

	public function getEbayId() {
		return $this->data['ebay_id'];
	}

	public function setEbayId( $ebay_id ) {
		$this->data['ebay_id'] = $ebay_id;
		$this->markChanged( 'ebay_id' );
		return $this;
	}

	public function getTitle() {
		return $this->data['title'];
	}

	public function setTitle( $title ) {
		$this->data['title'] = $title;
		$this->markChanged( 'title' );
		return $this;
	}

	public function getType() {
		return $this->data['type'];
	}

	public function setType( $type ) {
		$this->data['type'] = $type;
		$this->markChanged( 'type' );
		return $this;
	}

	public function getDuration() {
		return $this->data['duration'];
	}

	public function setDuration( $duration ) {
		$this->data['duration'] = $duration;
		$this->markChanged( 'duration' );
		return $this;
	}

	public function getDateCreated() {
		return $this->data['date_created'];
	}

	public function setDateCreated( $date ) {
		$this->data['date_created'] = $date;
		$this->markChanged( 'date_created' );
		return $this;
	}

	public function getDatePublished() {
		return $this->data['date_published'];
	}

	public function setDatePublished( $date ) {
		$this->data['date_published'] = $date;
		$this->markChanged( 'date_published' );
		return $this;
	}

	public function getDateFinished() {
		return $this->data['date_finished'];
	}

	public function setDateFinished( $date ) {
		$this->data['date_finished'] = $date;
		$this->markChanged('date_finished');
		return $this;
	}

	public function getEndDate() {
		return $this->data['end_date'];
	}

	public function setEndDate( $date ) {
		$this->data['end_date'] = $date;
		$this->markChanged('end_date');
		return $this;
	}

	public function getRelistDate() {
		return $this->data['relist_date'];
	}

	public function setRelistDate( $date ) {
		$this->data['relist_date'] = $date;
		$this->markChanged('relist_date');
		return $this;
	}

	public function getPrice() {
		return $this->data['price'];
	}

	public function setPrice( $price ) {
		$this->data['price'] = $price;
		$this->markChanged('price');
		return $this;
	}

	/**
	 * Get the final Start Price for the listing
	 * @return float
	 */
	public function getStartPrice() {
		$start_price = \ProductWrapper::getPrice( $this->getProductId() );

		$profile_details = $this->getProfileDetails();

		// support for WooCommerce Name Your Price plugin
		$nyp_enabled = get_post_meta( $this->getProductId(), '_nyp', true ) == 'yes';
		$nyp_enabled = apply_filters( 'wple_name_your_price_enabled', $nyp_enabled, $this->getProductId() );
		if ( $nyp_enabled ) {
			$suggested_price = get_post_meta( $this->getProductId(), '_suggested_price', true );

			if ( $suggested_price ) {
				$start_price = $suggested_price;
				WPLE()->logger->info( 'NYP price: '. $suggested_price );
			}
		}

		// handle StartPrice on product level
		if ( get_option( 'wplister_enable_custom_product_prices', 1 ) ) {
			if ( $product_start_price = get_post_meta( $this->getProductId(), '_ebay_start_price', true ) ) {
				$start_price = $product_start_price;
				WPLE()->logger->info( 'Custom product price: '. $product_start_price );

				if ( get_option( 'wplister_apply_profile_to_ebay_price', 0 ) ) {
					// default behavior - always use the _ebay_start_price if present
					$start_price = \ListingsModel::applyProfilePrice( $start_price, $profile_details['start_price'] );
					WPLE()->logger->info( 'applied profile price: '. $start_price );
				}
			} else {
				// Since the custom _ebay_start_price isnt set, apply the profile pricing rule on the product price instead #40129
				//$start_price = ListingsModel::applyProfilePrice( $start_price, $profile_details['start_price'] );
				$start_price = \ListingsModel::applyProfilePrice( $start_price, $profile_details['start_price'] );
				WPLE()->logger->info( 'Custom product price from profile: '. $start_price );
			}
		} else {
			// apply the profile pricing rule on the product price directly
			//$start_price = ListingsModel::applyProfilePrice( $start_price, $profile_details['start_price'] );
			$start_price = \ListingsModel::applyProfilePrice( $start_price, $profile_details['start_price'] );
			WPLE()->logger->info( 'product price from profile: '. $start_price );
		}

		return $start_price;
	}

	/**
	 * Get the listing's Buy It Now price
	 * @return float|int
	 */
	public function getBuyItNowPrice() {
		$profile_details = $this->getProfileDetails();
		$buynow_price = 0;

		if ( $this->getType() == Listing::TYPE_AUCTION ) {
			if ( $buynow_price = get_post_meta( $this->getProductId(), '_ebay_buynow_price', true ) ) {
				WPLE()->logger->info( 'BIN Price from Product: '. $buynow_price );
			}
		}

		if ( !$buynow_price && intval($profile_details['fixed_price']) != 0) {
			$buynow_price = \ListingsModel::applyProfilePrice( $this->getPrice(), $profile_details['fixed_price'] );
			WPLE()->logger->info( 'BIN Price from profile: '. $buynow_price );
		}

		return $buynow_price;
	}

	public function getReservePrice() {
		$reserve_price = get_post_meta( $this->getProductId(), '_ebay_reserve_price', true );

		if ( !$reserve_price ) {
			$reserve_price = 0;
		}

		return $reserve_price;
	}

	public function getMsrpPrice() {
		return get_post_meta( $this->listing->getProductId(), '_msrp_price', true ); // simple product
	}

	/**
	 * Get the listing's final stock quantity. The listing's stock quantity is initially based on the product's stock quantity.
	 *
	 * The returned value is the result of several stock-altering settings and operations such as WC's out-of-stock threshold
	 * and WPLE's quantity override settings
	 *
	 * @return int
	 */
	public function getStockQuantity() {

		WPLE()->logger->info( 'getStockQuantity for Listing #'. $this->getId() .'; WC #'. $this->getProductId() );

		// get current quantity from WooCommerce
		$woocom_stock   = \ProductWrapper::getStock( $this->getProductId() );
		WPLE()->logger->info( 'stock from ProductWrapper::getStock: '. $woocom_stock );

		// regard WooCommerce's Out Of Stock Threshold option - if enabled
		if ( $out_of_stock_threshold = get_option( 'woocommerce_notify_no_stock_amount' ) ) {
			if ( 1 == get_option( 'wplister_enable_out_of_stock_threshold' ) ) {
				$woocom_stock = $woocom_stock - $out_of_stock_threshold;
				WPLE()->logger->info( 'oos threshold enabled. new stock: '. $woocom_stock );
			}
		}

		// get max_quantity from profile
		$profile_details    = $this->getProfileDetails();
		$max_quantity       = ( isset( $profile_details['max_quantity'] ) && intval( $profile_details['max_quantity'] )  > 0 ) ? $profile_details['max_quantity'] : PHP_INT_MAX ;

		WPLE()->logger->info( 'max_quantity: '. $max_quantity );
		WPLE()->logger->info( 'Quantity: '. min( $max_quantity, intval( $woocom_stock ) ) );
		$quantity = min( $max_quantity, intval( $woocom_stock ) );

		// handle fixed quantity
		$fixed_quantity = intval( $profile_details['quantity'] );

		if ( $fixed_quantity > 0 ) {

			if ( $this->getProduct() && intval( $profile_details['restrict_fixed_quantity'] ) > 0 ) {
				if ( $profile_details['restrict_fixed_quantity'] == 1 ) {
					// only do this if the WC product is not out of stock #49283
					if ( $this->getProduct()->is_in_stock() ) {
						$quantity = $profile_details['quantity'];
						WPLE()->logger->info( 'Quantity from profile_details: '. $quantity );
					}
				} elseif ( $profile_details['restrict_fixed_quantity'] == 2 ) {
					// only apply to WC products not using Manage Stock #49660
					if ( ! $this->getProduct()->managing_stock() ) {
						$quantity = $profile_details['quantity'];
						WPLE()->logger->info( 'Quantity from profile_details: '. $quantity );
					}
				}

			} else {
				$quantity = $profile_details['quantity'];
				WPLE()->logger->info( 'Quantity from profile_details: '. $quantity );
			}
		}

		if ( $quantity < 0 ) $quantity = 0; // prevent error for negative qty

		return $quantity;
	}

	public function getQuantity() {
		return $this->data['quantity'];
	}

	public function setQuantity( $quantity ) {
		$this->data['quantity'] = $quantity;
		$this->markChanged('quantity');
		return $this;
	}

	public function getQuantitySold() {
		return $this->data['quantity_sold'];
	}

	public function setQuantitySold( $quantity ) {
		$this->data['quantity_sold'] = $quantity;
		$this->markChanged('quantity_sold');
		return $this;
	}

	public function getStatus() {
		return $this->data['status'];
	}

	public function setStatus( $status ) {
		$this->data['status'] = $status;
		$this->markChanged('status');
		return $this;
	}

	public function isLocked() {
		return $this->getLockedStatus();
	}

	public function getLockedStatus() {
		return $this->data['locked'];
	}

	public function setLockedStatus( $locked ) {
		$this->data['locked'] = $locked;
		$this->markChanged('locked');
		return $this;
	}

	public function getListingDetails() {
		return $this->data['details'];
	}

	public function setListingDetails( $details ) {
		$this->data['details'] = $details;
		$this->markChanged('details');
		return $this;
	}

	public function getVariations() {
		return $this->data['variations'];
	}

	public function setVariations( $variations ) {
		$this->data['variations'] = $variations;
		$this->markChanged('variations');
		return $this;
	}

	public function getViewItemUrl() {
		return $this->data['view_item_url'];
	}

	public function setViewItemUrl( $url ) {
		$this->data['view_item_url'] = $url;
		$this->markChanged('view_item_url');
		return $this;
	}

	public function getGalleryUrl() {
		return $this->data['gallery_url'];
	}

	public function setGalleryUrl( $url ) {
		$this->data['gallery_url'] = $url;
		$this->markChanged('gallery_url');
		return $this;
	}

	public function getProductProperty( $prop ) {
		return $this->data['product_properties'][ $prop ] ?? '';
	}

	public function loadProductProperties( $product_id ) {
		$meta = [];

		foreach ( $this->product_props as $key => $label ) {
			$meta[ $key ] = get_post_meta( $product_id, $key, true );
		}

		return $meta;
	}

	public function updateProductProperties( $props ) {
		foreach ( $props as $key => $value ) {
			if ( isset( $this->product_props[ $key ] ) ) {
				update_post_meta( $this->getProductId(), $key, $value );
			}
		}
	}

	/**
	 * @param int $product_id Used for getting categories based on mapping
	 *
	 * @return int
	 */
	public function getPrimaryCategory( $product_id ) {
		$profile_details    = $this->getProfileDetails();
		$mapped_categories  = $this->getMappedCategories( $product_id, $this->getAccountId() );
		$found_category     = 0;

		// handle primary category
		$ebay_category_1_id = get_post_meta( $product_id, '_ebay_category_1_id', true );
		if ( intval( $ebay_category_1_id ) > 0 ) {
			$found_category = $ebay_category_1_id;
		} elseif ( $mapped_categories['primary'] ) {
			WPLE()->logger->info('mapped primary_category_id: '.$mapped_categories['primary']);

			if ( intval( $mapped_categories['primary'] ) > 0 ) {
				$found_category = $mapped_categories['primary'];
			}
		} elseif ( intval($profile_details['ebay_category_1_id']) > 0 ) {
			$found_category = $profile_details['ebay_category_1_id'];
		}

		return $found_category;
	}

	/**
	 * @param int $product_id Used for getting categories based on mapping
	 *
	 * @return int
	 */
	public function getSecondaryCategory($product_id) {
		$profile_details    = $this->getProfileDetails();
		$mapped_categories  = $this->getMappedCategories( $product_id, $this->getAccountId() );
		$found_category     = 0;

		if ( ( intval( $mapped_categories['secondary'] ) > 0 ) && ( $mapped_categories['secondary'] != $mapped_categories['primary'] ) ) {
			$found_category = $mapped_categories['secondary'];
		} else {
			// optional secondary category
			$ebay_category_2_id = get_post_meta( $product_id, '_ebay_category_2_id', true );
			if ( intval( $ebay_category_2_id ) > 0 ) {
				$found_category = $ebay_category_2_id;
			} elseif ( intval($profile_details['ebay_category_2_id']) > 0 ) {
				$found_category = $profile_details['ebay_category_2_id'];
			}
		}

		return $found_category;
	}

	/**
	 * @param int $product_id Used for getting categories based on mapping
	 *
	 * @return int
	 */
	public function getPrimaryStoreCategory( $product_id ) {
		$profile_details    = $this->getProfileDetails();
		$found_category     = 0;

		// handle optional store category
		$store_category_1_id = get_post_meta( $product_id, '_ebay_store_category_1_id', true );

		if ( intval( $store_category_1_id ) > 0 ) {
			$found_category = $store_category_1_id;
		} elseif ( intval($profile_details['store_category_1_id']) > 0 ) {
			$found_category = $profile_details['store_category_1_id'];
		} else {
			// get store categories map
			// load the store categories map from the WPLE account details #19744
			if ( $this->getAccountId() ) {
				$categories_map_store = maybe_unserialize( WPLE()->accounts[ $this->getAccountId() ]->categories_map_store );
			}

			// fetch products local category terms
			$terms = wp_get_post_terms( $product_id, \ProductWrapper::getTaxonomy() );
			// WPLE()->logger->info('terms: '.print_r($terms,1));

			$store_category_id = false;
			foreach ( $terms as $term ) {

				// look up store category
				if ( isset( $categories_map_store[ $term->term_id ] ) ) {
					$store_category_id = @$categories_map_store[ $term->term_id ];
				}

				// check store category
				if ( intval( $store_category_id ) > 0 ) {
					$found_category = $store_category_id;
				}

			}

		}

		return $found_category;
	}

	/**
	 * @param int $product_id Used for getting categories based on mapping
	 *
	 * @return int
	 */
	public function getSecondaryStoreCategory($product_id) {
		$profile_details    = $this->getProfileDetails();
		$found_category     = 0;

		// optional secondary store category - from profile
		if ( intval($profile_details['store_category_2_id']) > 0 ) {
			$found_category = $profile_details['store_category_2_id'];
		}

		// optional secondary store category - from product
		$store_category_2_id = get_post_meta( $product_id, '_ebay_store_category_2_id', true );

		if ( intval($store_category_2_id) > 0 ) {
			$found_category = $store_category_2_id;
		} elseif ( intval( $profile_details['store_category_2_id'] ) > 0 ) {
			$found_category = $profile_details['store_category_2_id'];
		} else {
			// get store categories map
			// load the store categories map from the WPLE account details #19744
			if ( $this->getAccountId() ) {
				$categories_map_store = maybe_unserialize( WPLE()->accounts[ $this->getAccountId() ]->categories_map_store );
			}

			// fetch products local category terms
			$terms = wp_get_post_terms( $product_id, \ProductWrapper::getTaxonomy() );
			// WPLE()->logger->info('terms: '.print_r($terms,1));

			$store_category_id = false;
			$found_first_category = false;
			foreach ( $terms as $term ) {

				// look up store category
				if ( isset( $categories_map_store[ $term->term_id ] ) ) {
					$store_category_id = @$categories_map_store[ $term->term_id ];
				}

				// check store category
				if ( intval( $store_category_id ) > 0 ) {
					if ( !$found_first_category ) {
						$found_first_category = true;
					} else {
						$found_category = $store_category_id;
					}
				}
			}
		}

		return $found_category;

	}

	public function getPrimaryImage( $product_id, $allow_https = false, $currently_checking_parent = false ) {
		// check if custom post meta field '_ebay_gallery_image_url' exists
		if ( get_post_meta( $product_id, '_ebay_gallery_image_url', true ) ) {
			return wple_normalize_url( get_post_meta( $product_id, '_ebay_gallery_image_url', true ), $allow_https );
		}
		// check if custom post meta field 'ebay_image_url' exists
		if ( get_post_meta( $product_id, 'ebay_image_url', true ) ) {
			return wple_normalize_url( get_post_meta( $product_id, 'ebay_image_url', true ), $allow_https );
		}

		// get main product image (post thumbnail)
		$image_url = \ProductWrapper::getImageURL( $product_id );

		// check if featured image comes from nextgen gallery
		if ( $this->listingModel->is_plugin_active('nextgen-gallery/nggallery.php') ) {
			$thumbnail_id = get_post_meta($product_id, '_thumbnail_id', true);
			if ( 'ngg' == substr($thumbnail_id, 0, 3) ) {
				$imageID   = str_replace('ngg-', '', $thumbnail_id);
				$picture   = nggdb::find_image($imageID);
				$image_url = $picture->imageURL;
				WPLE()->logger->info( "NGG - image_url: " . print_r($image_url,1) );
			}
		}

		// check for the WP Intense External Images plugin #30840
		if ( function_exists( 'ei_get_external_image' ) ) {
			$image_url = ei_get_external_image( $product_id );
		}

		// filter image_url hook
		$image_url = apply_filters_deprecated( 'wplister_get_product_main_image', array($image_url, $product_id), '2.8.4', 'wple_get_product_main_image' );
		$image_url = apply_filters( 'wple_get_product_main_image', $image_url, $product_id );

		// if no main image found, check parent product
		if ( ( $image_url == '' ) && ( ! $currently_checking_parent ) ) {
			$parent_id = $this->getParentId();
			if ( $parent_id ) {
				return $this->getPrimaryImage( $parent_id, $allow_https, true );
			}
		}

		// ebay doesn't accept https - only http and ftp
		$image_url = wple_normalize_url( $image_url, $allow_https );

		WPLE()->logger->debug( "getProductMainImageURL( $product_id $allow_https ) returned: " . print_r($image_url,1) );
		return $image_url;
	}

	public function getImages( $allow_https = false ) {
		$product_id = $this->getProductId();
		$images = $this->getProductImages( $product_id );

		$product_image_gallery = $this->getCustomImageGallery( $product_id );

		// use parent product for single (split) variation
		if ( \ProductWrapper::isSingleVariation( $product_id ) ) {
			$parent_id = \ProductWrapper::getVariationParent( $product_id );

			$product_image_gallery = $this->getCustomImageGallery( $parent_id );

			// check for additional variation images (WooCommerce Additional Variation Images Addon)
			if ( class_exists('WC_Additional_Variation_Images') ) {

				$additional_var_images = get_post_meta( $product_id, '_wc_additional_variation_images', true );
				$additional_var_images = empty($additional_var_images) ? false : explode( ',', $additional_var_images );

				if ( is_array( $additional_var_images ) ) {
					// Unset the $product_image_gallery and use the additional variation images instead #44939
					if ( apply_filters( 'wple_exclusive_split_variation_gallery', true ) ) {
						// clear the image gallery so the main product gallery doesn't get included in the split variation's
						$product_image_gallery = array();
					} else {
						// merge gallery with the parent product
						$product_image_gallery = implode( ',', $additional_var_images) .','. $product_image_gallery;
					}

					$size = get_option( 'wplister_default_image_size', 'full' );

					// use the main variation image as the first/primary image
					$images[] = \ProductWrapper::getImageURL( $product_id );
					foreach ( $additional_var_images as $attachment_id ) {

						// get URL from attachment ID

						$large_image_url = wp_get_attachment_image_src( $attachment_id, $size );
						$image_url = wple_encode_url( $large_image_url[0] );
						$images[] = $image_url;
						WPLE()->logger->info( "found additional variation image: ".$image_url );

					}
				}
			}
		}

		if ( $product_image_gallery ) {

			// build clean array with main image as first item
			$images = array();
			$images[] = $this->getPrimaryImage( $product_id, $allow_https );

			$image_ids = explode(',', $product_image_gallery );
			foreach ( $image_ids as $image_id ) {
				$url = wp_get_attachment_url( $image_id );
				if ( $url && ! in_array($url, $images) ) $images[] = $url;
			}

			WPLE()->logger->info( "found WC2 product gallery images for product #$product_id " . print_r($images,1) );
		}

		$product_images = array();
		foreach( $images as $imageurl ) {
			$product_images[] = wple_normalize_url( $imageurl, $allow_https );
		}

		// call wplister_product_images filter
		// hook into this from your WP theme's functions.php - this won't work in listing templates!
		$product_images = apply_filters_deprecated( 'wplister_product_images', array($product_images, $product_id), '2.8.4', 'wple_product_images' );
		$product_images = apply_filters( 'wple_product_images', $product_images, $product_id );

		WPLE()->logger->debug( "getProductImagesURL( $product_id $allow_https ) returned: " . print_r($product_images,1) );
		return $product_images;
	}

	private function getProductImages( $product_id ) {
		$product = wc_get_product( $product_id );
		$results = $product ? $product->get_gallery_image_ids() : array();

		WPLE()->logger->debug( "getProductImagesURL( $product_id ) : " . print_r($results,1) );

		$images = array();
		foreach($results as $row) {
			$url = wp_get_attachment_url( $row );
			// $url = $row->guid ? $row->guid : wp_get_attachment_url( $row->id ); // disabled due to SSL issues #19164
			$images[] = $url;
		}

		// support for WooCommerce 2.0 Product Gallery
		if ( get_option( 'wplister_wc2_gallery_fallback','none' ) == 'none' ) $images = array(); // discard images if fallback is disabled

		return $images;
	}

	private function getCustomImageGallery( $product_id ) {
		// H.Nieri : Check if _ebay_image_gallery meta field exists and set $product_image_gallery if _ebay_image_gallery field exists
		$product_image_gallery = get_post_meta( $product_id, '_ebay_image_gallery', true );

		if ( empty ( $product_image_gallery ) ) {
			$product_image_gallery = get_post_meta( $product_id, '_product_image_gallery', true );
		}

		return $product_image_gallery;
	}

	public function getProductId() {
		return $this->data['post_id'];
	}

	public function setProductId( $post_id ) {
		$this->data['post_id'] = $post_id;
		$this->markChanged('post_id');
		return $this;
	}

	public function getParentId() {
		return $this->data['parent_id'];
	}

	public function setParentId( $parent_id ) {
		$this->data['parent_id'] = $parent_id;
		$this->markChanged('parent_id');
		return $this;
	}

	public function getProfileId() {
		return $this->data['profile_id'];
	}

	public function setProfileId( $profile_id ) {
		$this->data['profile_id'] = $profile_id;
		$this->markChanged('profile_id');
		return $this;
	}

	public function getTemplate() {
		return $this->data['template'];
	}

	public function setTemplate( $template ) {
		$this->data['template'] = $template;
		$this->markChanged('template');
		return $this;
	}

	public function getFees() {
		return $this->data['fees'];
	}

	public function setFees( $fees ) {
		$this->data['fees'] = $fees;
		$this->markChanged('fees');
		return $this;
	}

	public function getHistory() {
		return $this->data['history'];
	}

	public function setHistory( $history ) {
		$this->data['history'] = $history;
		$this->markChanged('history');
		return $this;
	}

	public function getLastErrors() {
		return $this->data['last_errors'];
	}

	public function setLastErrors( $errors ) {
		$this->data['last_errors'] = $errors;
		$this->markChanged('last_errors');
		return $this;
	}

	public function getEps() {
		return $this->data['eps'];
	}

	public function setEps( $eps ) {
		$this->data['eps'] = $eps;
		$this->markChanged('eps');
		return $this;
	}

	public function getAccountId() {
		return $this->data['account_id'];
	}

	public function setAccountId( $account_id ) {
		$this->data['account_id'] = $account_id;
		$this->markChanged( 'account_id' );
		return $this;
	}

	public function getSiteId() {
		return $this->data['site_id'];
	}

	public function setSiteId( $site_id ) {
		$this->data['site_id'] = $site_id;
		$this->markChanged( 'site_id' );
		return $this;
	}

	/**
	 * @return \WC_Product|null
	 */
	public function getProduct() {
		if ( empty( $this->getProductId() ) ) {
			return null;
		}

		if ( is_null( $this->product ) ) {
			$product = wc_get_product( $this->getProductId() );

			if ( $product ) {
				$this->product = $product;
			}
		}

		return $this->product;
	}

	/**
	 * @return bool
	 */
	public function isVariable() {
		return $this->getProduct() && $this->getProduct()->is_type('variable');
	}

	/**
	 * There's no real way of checking for split variations except that WP-Lister only processes
	 * Simple or Variable products. If a product's type is Variation, then it's safe to assume
	 * that it is a split variation listing
	 *
	 * @return bool
	 */
	public function isSplitVariation() {
		return ( $this->getProduct() && $this->getProduct()->is_type( 'variation') );
	}

	/**
	 * @return array
	 */
	public function getProfileData() {
		return $this->data['profile_data'] ?? [];
	}

	/**
	 * @return Profile
	 */
	public function getProfile() {
		return new Profile( $this->getProfileId() );
	}

	public function getProfileDetails() {
		return $this->getProfile()->getProductProfileDetails( $this );
	}

	/**
	 * @param array $profile_data
	 *
	 * @return $this
	 */
	public function setProfileData( $profile_data ) {
		$this->data['profile_data'] = $profile_data;
		$this->markChanged( 'profile_data' );
		return $this;
	}

	/**
	 * Get the mapped categories for the given product.
	 *
	 * @param int $product_id
	 *
	 * @return array
	 */
	public function getMappedCategories( $product_id ) {
		// get ebay categories map
		$categories_map_ebay = get_option( 'wplister_categories_map_ebay' );
		$account_id = $this->getAccountId();

		if ( $account_id && !empty( WPLE()->accounts[ $account_id ] ) ) {
			$categories_map_ebay  = maybe_unserialize( WPLE()->accounts[ $account_id ]->categories_map_ebay );
		}

		// fetch products local category terms
		$terms = wp_get_post_terms( $product_id, \ProductWrapper::getTaxonomy() );
		// WPLE()->logger->info('terms: '.print_r($terms,1));

		$ebay_category_id = false;
		$primary_category_id = false;
		$secondary_category_id = false;
		foreach ( $terms as $term ) {

			// look up ebay category
			if ( isset( $categories_map_ebay[ $term->term_id ] ) ) {
				$ebay_category_id = @$categories_map_ebay[ $term->term_id ];
				$ebay_category_id = apply_filters_deprecated( 'wplister_apply_ebay_category_map', array($ebay_category_id, $product_id), '2.8.4', 'wple_apply_ebay_category_map' );
				$ebay_category_id = apply_filters( 'wple_apply_ebay_category_map', $ebay_category_id, $product_id );
			}

			// check ebay category
			if ( intval( $ebay_category_id ) > 0 ) {

				if ( ! $primary_category_id ) {
					$primary_category_id = $ebay_category_id;
				} else {
					$secondary_category_id = $ebay_category_id;
				}
			}
		}

		return array(
			'ebay_category_id'  => $ebay_category_id,
			'primary'           => $primary_category_id,
			'secondary'         => $secondary_category_id
		);
	}

	public function applyProfile() {

	}

	public function save() {
		global $wpdb;

		$current_id = $this->getId();

		$data = [];

		$serialized_keys = ['eps', 'variations', 'last_errors'];
		$json_keys = ['details','profile_data'];
		foreach ( $this->changes as $prop ) {
			$prop_value = $this->data[ $prop ];
			if ( in_array( $prop, $serialized_keys ) ) {
				$prop_value = maybe_serialize( $this->data[ $prop ] );
			}

			if ( in_array( $prop, $json_keys ) ) {
				$prop_value = json_encode( $this->data[ $prop ] );
			}

			$data[ $prop ] = $prop_value;
		}

		// update listing
		if ( !empty( $data['product_properties'] ) ) {
			$this->updateProductProperties( $data['product_properties'] );
		}

		$data = \ListingsModel::mapListingToDB( $data );

		if ( $current_id ) {

			unset( $data['id'] );
			$wpdb->update( $wpdb->prefix.'ebay_auctions', $data,
				array( 'id' => $current_id )
			);

			if ( $wpdb->last_error ) {
				return new \WP_Error( 'save_listing_failed', __('There was an error saving this listing. MySQL said "'. $wpdb->last_error .'"') );
			}

			return true;
		} else {
			$wpdb->insert( $wpdb->prefix .'ebay_auctions', $data );

			if ( $wpdb->last_error ) {
				return new \WP_Error( 'save_listing_failed', __('There was an error saving this listing. MySQL said "'. $wpdb->last_error .'"') );
			}

			$id = $wpdb->insert_id;
			$this->setId( $id );
			return true;
		}

	}

	private function markChanged( $prop ) {
		if ( in_array( $prop, $this->changes ) ) {
			return;
		}

		$this->changes[] = $prop;
	}

}