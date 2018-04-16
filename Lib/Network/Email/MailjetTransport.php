<?php
/**
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @author        HD-CMS - https://github.com/hd-cms
 * @link          https://github.com/hd-cms/cakephp-mailjet
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

use \Mailjet\Client;
use \Mailjet\Resources;

/**
 * MailjetTransport class
 * Enables sending of email via Mailjet PHPv3 SDK
 */
class MailjetTransport extends AbstractTransport {

/**
 * Configurations
 *
 * @var array
 */
    protected $_config = array();

/**
 * Send email via Mailjet
 *
 * @param CakeEmail $email
 * @return array
 * @throws Exception
 */
    public function send(CakeEmail $email) {
        $mailjetClient = new Client($this->_config['mj_api_key'], $this->_config['mj_secret_key']);

        $body = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => "pilot@mailjet.com",
                        'Name' => "Mailjet Pilot"
                    ],
                    'To' => [
                        [
                            'Email' => "passenger1@mailjet.com",
                            'Name' => "passenger 1"
                        ]
                    ],
                    'Subject' => "Your email flight plan!",
                    'TextPart' => CakeEmail::MESSAGE_TEXT,
                    'HTMLPart' => CakeEmail::MESSAGE_HTML
                ]
            ]
        ];

        try {
            $result = $mailjetClient->post(Resources::$Email, ['body' => $body]);
            if ($result->success() != TRUE) {
                throw new Exception($result->getReasonPhrase());
            }
        } catch (Exception $e) {
            throw $e;
        }

        return $result->getBody();
    }
}
