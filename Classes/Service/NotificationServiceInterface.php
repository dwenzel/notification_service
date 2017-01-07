<?php
namespace DWenzel\NotificationService\Service;
/**
 * This file is part of the TYPO3 CMS project.
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 * The TYPO3 project - inspiring people to share!
 */

use DWenzel\NotificationService\Domain\Model\NotificationInterface;

/**
 * Class NotificationService
 *
 * @package DWenzel\NotificationService\Service
 */
interface NotificationServiceInterface
{
    /**
     * Notify using the given data
     *
     * @param string $recipients A comma separated list of recipients
     * @param string $sender The sender of the notification
     * @param string $subject The subject
     * @param string|null $templateName
     * @param null|string $format
     * @param string|null $folderName
     * @param array|null $variables An array of variables for rendering
     * @param array|null $attachments Variables which are passed to the template for rendering
     * @param array|null $attachments
     * @return bool Returns true on success, otherwise false
     */
    public function notify($recipients, $sender, $subject, $templateName, $format = NULL, $folderName, $variables = [], $attachments = NULL);

    /**
     * Sends a prepared notification
     * Returns true on success and false on failure.
     *
     * @param NotificationInterface $notification
     * @return bool
     */
    public function send(&$notification);
}