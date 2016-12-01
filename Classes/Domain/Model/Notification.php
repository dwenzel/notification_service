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

use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

/**
 * Notification
 */
class Notification extends AbstractEntity
{

    /**
     * @var string $recipient
     */
    protected $recipient;

    /**
     * @var string $sender
     */
    protected $sender;

    /**
     * @var string
     */
    protected $senderEmail;

    /**
     * @var string
     */
    protected $senderName;

    /**
     * @var string $subject
     * @validate NotEmpty
     */
    protected $subject;

    /**
     * Body text
     *
     * @var string $bodytext
     * @validate NotEmpty
     */
    protected $bodytext;

    /**
     * @var string|null $format
     */
    protected $format;

    /**
     * Send time
     *
     * @var \DateTime $sentAt
     */
    protected $sentAt;

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference>
     * @lazy
     */
    protected $attachments;

    /**
     * Returns the recipient
     *
     * @return string
     */
    public function getRecipient()
    {
        return $this->recipient;
    }

    /**
     * Sets the recipient
     *
     * @var string $recipient
     */
    public function setRecipient($recipient)
    {
        $this->recipient = $recipient;
    }

    /**
     * Returns the subject
     *
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Sets the subject
     *
     * @var string $subject
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
    }

    /**
     * Returns the bodytext
     *
     * @return string
     */
    public function getBodytext()
    {
        return $this->bodytext;
    }

    /**
     * Sets the bodytext
     *
     * @var string $bodytext
     */
    public function setBodytext($bodytext)
    {
        $this->bodytext = $bodytext;
    }

    /**
     * Returns the format
     *
     * @return string
     */
    public function getFormat()
    {
        return $this->format;
    }

    /**
     * Sets the format
     *
     * @var string $format
     */
    public function setFormat($format)
    {
        $this->format = $format;
    }

    /**
     * Returns the time when notification was send
     *
     * @return \DateTime
     */
    public function getSentAt()
    {
        return $this->sentAt;
    }

    /**
     * Sets send at
     *
     * @var \DateTime $sentAt
     */
    public function setSentAt($sentAt)
    {
        $this->sentAt = $sentAt;
    }

    /**
     * Gets the attachments
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference>
     */
    public function getAttachments()
    {
        return $this->attachments;
    }

    /**
     * Sets the attachments
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference> $attachments
     */
    public function setAttachments($attachments)
    {
        $this->attachments = $attachments;
    }

    /**
     * Adds an attachment
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $fileReference
     */
    public function addAttachment(FileReference $fileReference)
    {
        $this->attachments->attach($fileReference);
    }

    /**
     * Removes an attachment
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $fileReference
     */
    public function removeAttachment(FileReference $fileReference)
    {
        $this->attachments->detach($fileReference);
    }

    /**
     * Gets the sender email
     *
     * @return string
     */
    public function getSenderEmail()
    {
        if (!isset($this->senderEmail)) {
            return ($this->sender);
        }

        return $this->senderEmail;
    }

    /**
     * Sets the sender email
     * @param string $senderEmail
     */
    public function setSenderEmail($senderEmail)
    {
        $this->senderEmail = $senderEmail;
        $this->sender = $senderEmail;
    }

    /**
     * Gets the sender name
     * @return string
     */
    public function getSenderName()
    {
        return $this->senderName;
    }

    /**
     * Sets the sender name
     * @param string $senderName
     */
    public function setSenderName($senderName)
    {
        $this->senderName = $senderName;
    }
}
