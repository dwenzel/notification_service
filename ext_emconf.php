<?php

/***************************************************************
 * Extension Manager/Repository config file for ext "notification_service".
 *
 *
 * Manual updates:
 * Only the data in the array - everything else is removed by next
 * writing. "version" and "dependencies" must not be touched!
 ***************************************************************/

$EM_CONF[$_EXTKEY] = array(
    'title' => 'Notification Service',
    'description' => 'Notification service',
    'category' => 'plugin',
    'version' => '0.1.0-dev',
    'state' => 'beta',
    'uploadfolder' => 0,
    'createDirs' => '',
    'clearcacheonload' => 0,
    'author' => 'Dirk Wenzel',
    'author_email' => 't3events@gmx.de',
    'author_company' => 'Consulting Piezunka Schamoni - Information Technologies GmbH',
    'constraints' =>
        array(
            'depends' =>
                array(
                    'typo3' => '6.2.0-8.99.99',
                    'php' => '5.5.0-0.0.0',
                ),
            'conflicts' =>
                array(),
            'suggests' =>
                array(),
        ),
    '_md5_values_when_last_written' => 'foo',
);

