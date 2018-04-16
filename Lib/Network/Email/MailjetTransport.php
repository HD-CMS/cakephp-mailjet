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

use Mailjet\Client;
use Mailjet\Resources;

/**
 * MailjetTransport class
 * Enables sending of email via Mailjet PHPv3 SDK
 */
class MailjetTransport extends AbstractTransport
{



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
    public function send(CakeEmail $email)
    {
        $mailjetClient = new Client(
            $this->_config['mj_api_key'],
            $this->_config['mj_secret_key'],
            TRUE,
            ['version' => 'v3.1']
        );

        $message = ['Subject' => $email->subject()];
        foreach ($email->from() as $fromEmail => $name)
        {
            $message['From'] = ['Email' => $fromEmail, 'Name' => $name];
        }

        foreach ($email->to() as $toEmail => $name)
        {
            $message['To'][] = ['Email' => $toEmail, 'Name' => $name];
        }

        foreach ($email->attachments() as $name => $info)
        {
            $message['Attachments'][] = [
                'ContentType'   => $info['mimetype'],
                'Filename'      => $name,
                'Base64Content' => base64_encode(file_get_contents($info['file']))
            ];
        }

        $headers = $email->getHeaders(['TemplateID']);

        /**
         * Mailjet TemplateID used, set TemplateID, TemplateVars
         * and TemplateLanguage
         */
        if (isset($headers['TemplateID']) && intval($headers['TemplateID']) > 0)
        {
            $message['TemplateLanguage'] = TRUE;
            $message['TemplateID']       = intval($headers['TemplateID']);
            $message['Variables']        = $email->viewVars();
        }
        else
        {
            $message['TextPart'] = $email->message(CakeEmail::MESSAGE_TEXT);
            $message['HTMLPart'] = $email->message(CakeEmail::MESSAGE_HTML);
        }

        $body = [
            'Messages' => [$message]
        ];


        try
        {
            $result = $mailjetClient->post(Resources::$Email, ['body' => $body]);
            if ($result->success() != TRUE)
            {
                throw new Exception($result->getReasonPhrase());
            }
        }
        catch (Exception $e)
        {
            throw $e;
        }

        return $result->getBody();
    }
}
