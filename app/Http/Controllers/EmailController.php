<?php

namespace App\Http\Controllers;

use Brevo\Configuration;
use Brevo\Client;
use Brevo\Model\SendSmtpEmail;
use Brevo\Api\TransactionalEmailsApi;
use Brevo\ApiException;
use Illuminate\Http\Request;

class EmailController extends Controller
{
    public function sendEmail()
    {
        // Your Brevo API key
        $apiKey = env('BREVO_API_KEY');

        // Set up the Brevo API client
        $config = Configuration::getDefaultConfiguration()->setApiKey('api-key', $apiKey);

        // Create an instance of the API client
        $apiInstance = new TransactionalEmailsApi(new Client(), $config);

        // Create the email object
        $sendSmtpEmail = new SendSmtpEmail([
            'sender' => ['email' => 'atamnamohamedslimane@gmail.com'],
            'to' => [['email' => 'kirokirak69@hgmail.com']],
            'subject' => 'Test Email from Brevo',
            'htmlContent' => '<html><body><h1>This is a test email sent via Brevo API.</h1></body></html>'
        ]);

        try {
            // Send the email using Brevo's API
            $result = $apiInstance->sendTransacEmail($sendSmtpEmail);
            return response()->json(['message' => 'Email sent successfully!', 'result' => $result]);
        } catch (ApiException $e) {
            return response()->json(['error' => 'Email failed to send', 'message' => $e->getMessage()]);
        }
    }
}
