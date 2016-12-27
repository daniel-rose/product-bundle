<?php
/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */
namespace Spryker\Zed\ProductBundle\Business;

use Generated\Shared\Transfer\CartChangeTransfer;
use Generated\Shared\Transfer\CheckoutResponseTransfer;
use Generated\Shared\Transfer\OrderTransfer;
use Generated\Shared\Transfer\ProductConcreteTransfer;
use Generated\Shared\Transfer\QuoteTransfer;

/**
 * @method \Spryker\Zed\ProductBundle\Business\ProductBundleBusinessFactory getFactory()
 */
interface ProductBundleFacadeInterface
{

    /**
     *
     * Specification:
     *
     * - Takes all items to be added to cart and checks if any is bundle item
     * - If bundle item then it is removed, and added to QuoteTransfer::bundleItems, the identifier assigned
     * - Finds all bundled items from that bundle and puts into add to cart operation, assign bundle identifier they belong to.
     * - The price amount is assigned, proportionaly split through items quantity = 1
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\CartChangeTransfer $cartChangeTransfer
     *
     * @return \Generated\Shared\Transfer\CartChangeTransfer
     */
    public function expandBundleItems(CartChangeTransfer $cartChangeTransfer);

    /**
     *
     * Specification:
     *
     * - The group key is build to uniquely identify bundled items.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\CartChangeTransfer $cartChangeTransfer
     *
     * @return \Generated\Shared\Transfer\CartChangeTransfer
     */
    public function expandBundleCartItemGroupKey(CartChangeTransfer $cartChangeTransfer);

    /**
     *
     * Specification:
     *
     * - Updates QuoteTransfer::bundleItems to be in sync with current existing bundled items in cart.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    public function postSaveCartUpdateBundles(QuoteTransfer $quoteTransfer);

    /**
     *
     * Specification:
     *
     * - Checks if items which being added to cart is available, for bundle it checks bundled items.
     * - Even if same item added separatelly from bundle availability is checked together.
     * - Sets error message if not available
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\CartChangeTransfer $cartChangeTransfer
     *
     * @return \Generated\Shared\Transfer\CartPreCheckResponseTransfer
     */
    public function preCheckCartAvailability(CartChangeTransfer $cartChangeTransfer);

    /**
     *
     * Specification:
     *
     * - Checks if items which being added to checkout is available, for bundle it checks bundled items.
     * - Even if same item added separatelly from bundle availability is checked together.
     * - Sets error message if not available
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     * @param \Generated\Shared\Transfer\CheckoutResponseTransfer $checkoutResponseTransfer
     *
     * @return void
     */
    public function preCheckCheckoutAvailability(QuoteTransfer $quoteTransfer, CheckoutResponseTransfer $checkoutResponseTransfer);

    /**
     * * Specification:
     *
     *  - Calculates QuoteTransfer::bundleItems prices
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    public function calculateBundlePrice(QuoteTransfer $quoteTransfer);

    /**
     *
     * Specification:
     *
     *  - Aggregates OrderTransfer::bundleItems prices
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     *
     * @return \Generated\Shared\Transfer\OrderTransfer
     */
    public function aggregateBundlePrice(OrderTransfer $orderTransfer);

    /**
     * Specification:
     *
     * - Gets all items which belong to bundle
     * - Updates bundle products with new availability, given sku belong
     * - Touch abstract availability for bundle product
     *
     * @api
     *
     * @param string $concreteSku
     *
     * @return void
     */
    public function updateAffectedBundlesAvailability($concreteSku);

    /**
     *
     * Specification:
     *
     *  - Calculated bundle availability based on bundled items
     *  - Persists availability
     *  - Touches availability abstract collector for bundle
     *
     * @api
     *
     * @param string $productBundleSku
     *
     * @return void
     */
    public function updateBundleAvailability($productBundleSku);

    /**
     *
     * Specification:
     *
     * - Persists bundled product to sales database tables, from QuoteTransfer
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     * @param \Generated\Shared\Transfer\CheckoutResponseTransfer $checkoutResponse
     *
     * @return void
     */
    public function saveSalesOrderBundleItems(QuoteTransfer $quoteTransfer, CheckoutResponseTransfer $checkoutResponse);

    /**
     *
     * Specification:
     *
     * - Persists bundled products within ProductConcrete
     * - Updates product bundle available stock
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ProductConcreteTransfer $productConcreteTransfer
     *
     * @return \Generated\Shared\Transfer\ProductConcreteTransfer
     */
    public function saveBundledProducts(ProductConcreteTransfer $productConcreteTransfer);

    /**
     *
     * Specification:
     *
     * - Finds all bundled products to given concrete product
     *
     * @api
     *
     * @param int $idProductConcrete
     *
     * @return \ArrayObject
     */
    public function findBundledProductsByIdProductConcrete($idProductConcrete);

    /**
     *
     * Specification:
     *
     * - Assigns bundled products to ProductConcreteTransfer::productBundle
     * - Returns modified ProductConcreteTransfer
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ProductConcreteTransfer $productConcreteTransfer
     *
     * @return \Generated\Shared\Transfer\ProductConcreteTransfer
     */
    public function assignBundledProductsToProductConcrete(ProductConcreteTransfer $productConcreteTransfer);

}