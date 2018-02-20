<?php
namespace Serato\UserProfileSdk\Message;

use Serato\UserProfileSdk\Message\AbstractMessage;

/**
 * A message representing a user starting a trial of a product.
 *
 * The product may be being trialled for the first time, or for successive times
 * in which case the expiry date of the product will be updated.
 */
class TrialProductUpdate extends AbstractMessage
{
    const PRODUCT_NAME = 'trial-product';
    const EXPIRY = 'expiry';

    /**
     * Set the trial Product Type name
     *
     * @param string $productName    Trial Product name
     * @return self
     */
    public function setProductName($productName)
    {
        return $this->setParam(self::PRODUCT_NAME, $productName);
    }

    /**
     * Get trial Product Type name
     *
     * @return string
     */
    public function getProductName()
    {
        return $this->getParam(self::PRODUCT_NAME);
    }

    /**
     * Set expiry date for trial Product.
     *
     * Date format: DATE_ATOM
     * Example: 2017-08-15T15:52:01+00:00
     *
     * @param string $expiryDate    Trial expiry date
     * @return self
     */
    public function setExpiry($expiryDate)
    {
        return $this->setParam(self::EXPIRY, $expiryDate);
    }

    /**
     * Get expiry date for trial Product.
     *
     * @return string
     */
    public function getExpiry()
    {
        return $this->getParam(self::EXPIRY);
    }

    /**
     * Set expiry timestamp for trial
     *
     * @param int $timestamp
     *
     * @return string
     */
    public function setExpiryTimestamp($timestamp)
    {
        return $this->setExpiry(gmdate(DATE_ATOM, $timestamp));
    }
}
