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

use DWenzel\NotificationService\Domain\Model\Notification;
use TYPO3\CMS\Core\Mail\MailMessage;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Extbase\Reflection\ObjectAccess;
use TYPO3\CMS\Fluid\View\StandaloneView;

/**
 * Class NotificationService
 *
 * @package DWenzel\NotificationService\Service
 */
class NotificationService
{

    /**
     * Object Manager
     *
     * @var \TYPO3\CMS\Extbase\Object\ObjectManagerInterface
     * @inject
     */
    protected $objectManager;

    /**
     * Configuration Manager
     *
     * @var ConfigurationManagerInterface
     * @inject
     */
    protected $configurationManager;

    /**
     * Notify using the given data
     *
     * @param string $recipient
     * @param string $sender
     * @param $subject
     * @param string $templateName
     * @param null|string $format
     * @param $folderName
     * @param array $variables
     * @param array|null $attachments Variables which are passed to the template for rendering
     * @param array $attachments
     * @return \bool
     */
    public function notify($recipient, $sender, $subject, $templateName, $format = NULL, $folderName, $variables = [], $attachments = NULL)
    {
        $templateView = $this->buildTemplateView($templateName, $format, $folderName);
        $templateView->assignMultiple($variables);
        $body = $templateView->render();
        $recipient = GeneralUtility::trimExplode(',', $recipient, true);

        /** @var $message \TYPO3\CMS\Core\Mail\MailMessage */
        $message = $this->objectManager->get(MailMessage::class);
        $message->setTo($recipient)
            ->setFrom($sender)
            ->setSubject($subject);
        $mailFormat = ($format == 'plain') ? 'text/plain' : 'text/html';

        $message->setBody($body, $mailFormat);
        if ($attachments) {
            foreach ($attachments as $attachment) {
                $fileToAttach = $this->buildAttachmentFromTemplate($attachment);
                $message->attach($fileToAttach);
            }
        }
        $message->send();

        return $message->isSent();
    }

    /**
     * Renders the body of a notification using a given template
     *
     * @param string $templateName
     * @param string|null $format
     * @param string $folderName
     * @param array $variables
     * @return string
     */
    public function render($templateName, $format = NULL, $folderName, $variables = [])
    {
        $templateView = $this->buildTemplateView($templateName, $format, $folderName);
        $templateView->assignMultiple($variables);

        return $templateView->render();
    }

    /**
     * Sends a prepared notification
     * Returns true on success and false on failure.
     *
     * @param \DWenzel\NotificationService\Domain\Model\Notification $notification
     * @return bool
     */
    public function send(&$notification)
    {
        /** @var $message \TYPO3\CMS\Core\Mail\MailMessage */
        $message = $this->objectManager->get(MailMessage::class);
        $recipients = GeneralUtility::trimExplode(',', $notification->getRecipient(), true);

        $message->setTo($recipients)
            ->setFrom($notification->getSenderEmail(), $notification->getSenderName())
            ->setSubject($notification->getSubject());
        $mailFormat = ($notification->getFormat() == 'plain') ? 'text/plain' : 'text/html';

        $message->setBody($notification->getBodytext(), $mailFormat);
        if ($files = $notification->getAttachments()) {
            /** @var FileReference $file */
            foreach ($files as $file) {
                $message->attach(\Swift_Attachment::fromPath($file->getOriginalResource()->getPublicUrl(true)));
            }
        }
        $message->send();
        if ($message->isSent()) {
            $notification->setSentAt(new \DateTime());
        }

        return $message->isSent();
    }

    /**
     * Get a template view
     * Uses the given template name
     *
     * @param string $templateName
     * @param null|string $format
     * @param null|string $folderName
     * @return \TYPO3\CMS\Fluid\View\StandaloneView
     * @internal param string $templateName
     * @internal param string $format Format for content. Default is html
     */
    protected function buildTemplateView($templateName, $format = NULL, $folderName = NULL)
    {
        /** @var \TYPO3\CMS\Fluid\View\StandaloneView $emailView */
        $emailView = $this->objectManager->get(StandaloneView::class);
        $emailView->setTemplatePathAndFilename(
            $this->getTemplatePathAndFileName($templateName, $folderName)
        );
        $emailView->setPartialRootPaths(
            $this->getPartialRootPaths()
        );
        if ($format == 'plain') {
            $emailView->setFormat('txt');
        }

        return $emailView;
    }

    /**
     * @var array $data An array containing data for attachement generation
     * @return \Swift_Attachment
     */
    protected function buildAttachmentFromTemplate($data)
    {
        $attachmentView = $this->buildTemplateView(
            $data['templateName'],
            NULL,
            $data['folderName']
        );
        $attachmentView->assignMultiple($data['variables']);
        $content = $attachmentView->render();
        $attachment = \Swift_Attachment::newInstance(
            $content,
            $data['fileName'],
            $data['mimeType']
        );

        return $attachment;
    }

    /**
     * Get template path and file name
     *
     * @var string $templateName File name (without extension)
     * @var string $folderName Optional folder name, default 'Email'
     * @return string
     */
    protected function getTemplatePathAndFileName($templateName, $folderName = 'Email')
    {
        $extbaseFrameworkConfiguration = $this->configurationManager->getConfiguration(ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK);
        $templateRootPath = GeneralUtility::getFileAbsFileName($extbaseFrameworkConfiguration['view']['templateRootPath']);
        $templatePathAndFilename = $templateRootPath . $folderName . '/' . $templateName . '.html';

        return $templatePathAndFilename;
    }

    /**
     * Get the partial root path from framework configuration
     *
     * @return string
     */
    protected function getPartialRootPaths()
    {
        $extbaseFrameworkConfiguration = $this->configurationManager->getConfiguration(ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK);

        return GeneralUtility::getFileAbsFileName($extbaseFrameworkConfiguration['view']['partialRootPaths']);
    }

    /**
     * Clones a given notification
     *
     * @param \DWenzel\NotificationService\Domain\Model\Notification $oldNotification
     * @return \DWenzel\NotificationService\Domain\Model\Notification
     */
    public function duplicate($oldNotification)
    {
        $notification = $this->objectManager->get(Notification::class);
        $accessibleProperties = ObjectAccess::getSettablePropertyNames($notification);
        foreach ($accessibleProperties as $property) {
            ObjectAccess::setProperty(
                $notification,
                $property,
                $oldNotification->_getProperty($property));
        }

        return $notification;
    }
}
