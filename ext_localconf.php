<?php
if (!defined ('TYPO3_MODE')) {
    die ('Access denied.');
}

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addService(
    $_EXTKEY,
    // Service type
    'notification',
    // Service key
    \DWenzel\NotificationService\Service\NotificationService::class,
    array(
        'title' => 'Email Notification',
        'description' => 'Generates emails from template and sends them.',

        'subtype' => 'email,notifyUserBE,notifyGroupBE',

        'available' => true,
        'priority' => 60,
        'quality' => 80,

        'os' => '',
        'exec' => '',

        'className' => \DWenzel\NotificationService\Service\NotificationService::class
    )
);