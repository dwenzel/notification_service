<?php
namespace DWenzel\NotificationService\Domain\Model;
/**
 * This file is part of the TYPO3 CMS project.
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 * The TYPO3 project - inspiring people to share!
 */

/**
 * Notification
 */
interface NotificationInterface
{
    /**
     * Returns the recipient
     *
     * @return string
     */
    public function getRecipient();

    /**
     * Sets the recipient
     *
     * @var string $recipient
     */
    public function setRecipient($recipient);

    /**
     * Returns the subject
     *
     * @return string
     */
    public function getSubject();

    /**
     * Sets the subject
     *
     * @var string $subject
     */
    public function setSubject($subject);

    /**
     * Returns the bodytext
     *
     * @return string
     */
    public function getBodytext();

    /**
     * Sets the bodytext
     *
     * @var string $bodytext
     */
    public function setBodytext($bodytext);

    /**
     * Returns the format
     *
     * @return string
     */
    public function getFormat();

    /**
     * Sets the format
     *
     * @var string $format
     */
    public function setFormat($format);

    /**
     * Returns the time when notification was send
     *
     * @return \DateTime
     */
    public function getSentAt();

    /**
     * Sets send at
     *
     * @var \DateTime $sentAt
     */
    public function setSentAt($sentAt);

    /**
     * Gets the sender name
     * @return string
     */
    public function getSenderName();

    /**
     * Sets the sender name
     * @param string $senderName
     */
    public function setSenderName($senderName);
}
