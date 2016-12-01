<?php
namespace DWenzel\NotificationService\Tests\Unit\Service;

/**
 * This file is part of the TYPO3 CMS project.
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 * The TYPO3 project - inspiring people to share!
 */

use TYPO3\CMS\Core\Mail\MailMessage;
use TYPO3\CMS\Core\Tests\UnitTestCase;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Fluid\View\StandaloneView;
use DWenzel\NotificationService\Domain\Model\Notification;
use DWenzel\NotificationService\Service\NotificationService;

/**
 * Class NotificationServiceTest
 * @package DWenzel\NotificationService\Tests\Unit\Service
 */
class NotificationServiceTest extends UnitTestCase
{
    /**
     * @var NotificationService
     */
    protected $subject;

    /**
     * set up subject
     */
    public function setUp()
    {
        $this->subject = $this->getAccessibleMock(
            NotificationService::class, ['dummy']
        );
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject | ObjectManager
     */
    protected function mockObjectManager()
    {
        $mockObjectManager = $this->getMock(
            ObjectManager::class, ['get']
        );
        $this->inject(
            $this->subject,
            'objectManager',
            $mockObjectManager
        );

        return $mockObjectManager;
    }

    /**
     * Provides recipients
     *
     * @return array
     */
    public function recipientDataProvider()
    {
        return [
            ['foo@bar.baz', ['foo@bar.baz']],
            ['foo,bar', ['foo', 'bar']]
        ];

    }

    /**
     * @test
     * @param string $recipientArgument
     * @param array $expectedRecipients
     * @dataProvider recipientDataProvider
     */
    public function sendSetsRecipients($recipientArgument, $expectedRecipients)
    {
        $notification = new Notification();
        $notification->setRecipient($recipientArgument);

        $mockMessage = $this->getMock(
            MailMessage::class, ['setTo', 'send']
        );
        $mockObjectManager = $this->mockObjectManager();
        $mockObjectManager->expects($this->once())
            ->method('get')
            ->with(MailMessage::class)
            ->will($this->returnValue($mockMessage));

        $mockMessage->expects($this->once())
            ->method('setTo')
            ->with($expectedRecipients)
            ->will($this->returnValue($mockMessage));

        $this->subject->send($notification);
    }

    /**
     * @test
     * @param string $recipient
     * @param array $expectedRecipients
     * @dataProvider recipientDataProvider
     */
    public function notifySetsRecipients($recipient, $expectedRecipients)
    {
        $this->subject = $this->getAccessibleMock(
            NotificationService::class, ['dummy', 'buildTemplateView']
        );

        $mockTemplateView = $this->getMock(
            StandaloneView::class, [], [], '', false
        );

        $this->subject->expects($this->once())
            ->method('buildTemplateView')
            ->will($this->returnValue($mockTemplateView));

        $mockMessage = $this->getMock(
            MailMessage::class, ['setTo', 'send']
        );
        $mockObjectManager = $this->mockObjectManager();
        $mockObjectManager->expects($this->once())
            ->method('get')
            ->with(MailMessage::class)
            ->will($this->returnValue($mockMessage));

        $mockMessage->expects($this->once())
            ->method('setTo')
            ->with($expectedRecipients)
            ->will($this->returnValue($mockMessage));

        $this->subject->notify(
            $recipient,
            'bar@baz.foo',
            'foo',
            'bar',
            null,
            'baz'
        );
    }
}
