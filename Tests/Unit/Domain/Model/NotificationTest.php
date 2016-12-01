<?php
namespace DWenzel\NotificationService\Tests\Unit\Domain\Model;


use DWenzel\NotificationService\Domain\Model\Notification;
use TYPO3\CMS\Core\Tests\UnitTestCase;

/**
 * Class NotificationTest
 *
 * @package DWenzel\NotificationService\Tests\Unit\Domain\Model
 */
class NotificationTest extends UnitTestCase
{

    /**
     * @var \DWenzel\NotificationService\Domain\Model\Notification
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
}

