<?php
namespace DWenzel\NotificationService\Tests\Unit\Domain\Model;


use DWenzel\NotificationService\Domain\Model\Notification;
use DWenzel\NotificationService\Domain\Model\NotificationInterface;
use TYPO3\CMS\Core\Tests\UnitTestCase;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/**
 * Class NotificationTest
 *
 * @package DWenzel\NotificationService\Tests\Unit\Domain\Model
 */
class NotificationTest extends UnitTestCase
{

    /**
     * @var NotificationInterface
     */
    protected $subject;

    public function setUp()
    {
        $this->subject = $this->getAccessibleMock(
            Notification::class, ['dummy']
        );
    }

    /**
     * @test
     */
    public function initializeObjectsSetsObjectStorage()
    {
        $this->subject->initializeObject();
        $this->assertInstanceOf(
            ObjectStorage::class,
            $this->subject->getAttachments()
        );
    }

    /**
     * @test
     */
    public function getRecipientReturnsInitialValueForString()
    {
        $this->assertNull(
            $this->subject->getRecipient()
        );
    }

    /**
     * @test
     */
    public function setRecipientForStringSetsRecipient()
    {
        $this->subject->setRecipient('Conceived at T3CON10');

        $this->assertSame(
            'Conceived at T3CON10',
            $this->subject->getRecipient()
        );
    }

    /**
     * @test
     */
    public function getSubjectReturnsInitialValueForString()
    {
        $this->assertNull(
            $this->subject->getSubject()
        );
    }

    /**
     * @test
     */
    public function setSubjectForStringSetsSubject()
    {
        $this->subject->setSubject('Conceived at T3CON10');

        $this->assertSame(
            'Conceived at T3CON10',
            $this->subject->getSubject()
        );
    }

    /**
     * @test
     */
    public function getBodytextReturnsInitialValueForString()
    {
        $this->assertNull(
            $this->subject->getBodytext()
        );
    }

    /**
     * @test
     */
    public function setBodytextForStringSetsBodytext()
    {
        $this->subject->setBodytext('Conceived at T3CON10');

        $this->assertSame(
            'Conceived at T3CON10',
            $this->subject->getBodytext()
        );
    }

    /**
     * @test
     */
    public function getFormatReturnsInitialValueForString()
    {
        $this->assertNull(
            $this->subject->getFormat()
        );
    }

    /**
     * @test
     */
    public function setFormatForStringSetsFormat()
    {
        $this->subject->setFormat('Conceived at T3CON10');

        $this->assertSame(
            'Conceived at T3CON10',
            $this->subject->getFormat()
        );
    }

    /**
     * @test
     */
    public function getSentAtForDateTimeInitiallyReturnsNull()
    {
        $this->assertNull(
            $this->subject->getSentAt()
        );
    }

    /**
     * @test
     */
    public function sentAtCanBeSet()
    {
        $sentAt = new \DateTime();
        $this->subject->setSentAt($sentAt);

        $this->assertSame(
            $sentAt,
            $this->subject->getSentAt()
        );
    }

    /**
     * @test
     */
    public function getSenderEmailInitiallyReturnsNull()
    {
        $this->assertNull(
            $this->subject->getSenderEmail()
        );
    }

    /**
     * @test
     */
    public function senderEmailCanBeSet()
    {
        $email = 'foo';
        $this->subject->setSenderEmail($email);
        $this->assertSame(
            $email,
            $this->subject->getSenderEmail()
        );
    }

    /**
     * @test
     */
    public function getSenderNameInitiallyReturnsNull()
    {
        $this->assertNull(
            $this->subject->getSenderName()
        );
    }

    /**
     * @test
     */
    public function senderNameCanBeSet()
    {
        $name = 'bar';
        $this->subject->setSenderName($name);
        $this->assertSame(
            $name,
            $this->subject->getSenderName()
        );
    }

    /**
     * @test
     */
    public function setAttachmentForObjectStorageContainingAttachmentSetsAttachment()
    {
        $attachment = new FileReference();
        $objectStorageHoldingExactlyOneAttachment = new ObjectStorage();
        $objectStorageHoldingExactlyOneAttachment->attach($attachment);
        $this->subject->setAttachments($objectStorageHoldingExactlyOneAttachment);

        $this->assertSame(
            $objectStorageHoldingExactlyOneAttachment,
            $this->subject->getAttachments()
        );
    }

    /**
     * @test
     */
    public function addAttachmentToObjectStorageHoldingAttachment()
    {
        $this->subject->initializeObject();
        $attachment = new FileReference();
        $objectStorageHoldingExactlyOneAttachment = new ObjectStorage();
        $objectStorageHoldingExactlyOneAttachment->attach($attachment);
        $this->subject->addAttachment($attachment);

        $this->assertEquals(
            $objectStorageHoldingExactlyOneAttachment,
            $this->subject->getAttachments()
        );
    }

    /**
     * @test
     */
    public function removeAttachmentFromObjectStorageHoldingAttachment()
    {
        $this->subject->initializeObject();
        $attachment = new FileReference();
        $localObjectStorage = new ObjectStorage();
        $localObjectStorage->attach($attachment);
        $localObjectStorage->detach($attachment);
        $this->subject->addAttachment($attachment);
        $this->subject->removeAttachment($attachment);

        $this->assertEquals(
            $localObjectStorage,
            $this->subject->getAttachments()
        );
    }
}

