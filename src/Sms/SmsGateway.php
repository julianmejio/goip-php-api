<?php

namespace GoIP\Sms;

use GoIP\Exception\SmsNotSentException;
use GoIP\Exception\SmsResponseTimeoutException;
use Symfony\Component\Stopwatch\Stopwatch;

/**
 * High-level functions to send and receive SMS.
 *
 * @package GoIP\Sms
 */
class SmsGateway
{
    /**
     * Time in seconds to check the response for a sent SMS.
     */
    const CHECK_RESPONSE_INTERVAL = 1;
    /**
     * @var \GoIP\Sms
     */
    private $sms;

    public function __construct(\GoIP\Sms $sms)
    {
        $this->sms = $sms;
    }

    /**
     * Sends a SMS.
     *
     * @param string $addressee Destination
     * @param string $message   Message
     * @param int    $line      Slot used to send the SMS
     *
     * @return bool Returns true if the SMS was send, and false otherwise.
     */
    public function sendSms(string $addressee, string $message, int $line = 1): bool
    {
        $sendResult = $this->sms->sendSms($line, $addressee, $message);

        return !$sendResult['error'];
    }

    /**
     * Gets the SMS stored for a specific line.
     *
     * @param int $line Line.
     *
     * @return Sms[] Returns the list of the SMS of the line.
     *
     * @throws \Exception
     */
    public function getSms(int $line = 1): array
    {
        $mapper = new SmsMapper(new SmsAdapter($this->sms));

        return $mapper->findByLine($line);
    }

    /**
     * Sends a SMS and waits for a response.
     *
     * @param string $addressee       Destination
     * @param string $message         Message
     * @param int    $line            Slot used to send the SMS
     * @param int    $responseTimeout Time to wait for a response.
     *
     * @return Sms Returns the SMS that is considered the response to the SMS.
     *
     * @throws \Exception Thrown when the initial SMS is not sent or when first
     *                    occurs the timeout before receiving the response.
     */
    public function sendSmsAndWaitResponse(string $addressee, string $message, int $line = 1, int $responseTimeout = 60): Sms
    {
        $sendResult = $this->sendSms($addressee, $message, $line);

        if (!$sendResult) {
            throw new SmsNotSentException($line, $addressee);
        }

        $mapper = new SmsMapper(new SmsAdapter($this->sms));
        /** @var Sms $latestMessage */
        $latestMessage = ($mapper->findByLine($line))[0];
        $stopwatch = new Stopwatch();
        $stopwatch->start('check_response');
        do {
            sleep(self::CHECK_RESPONSE_INTERVAL);
            /** @var Sms $responseCheckMessage */
            $responseCheckMessage = ($mapper->findByLine($line))[0];
            if ($responseCheckMessage->getDate()->format('Y-m-d H:i:s') === $latestMessage->getDate()->format('Y-m-d H:i:s')) {
                continue;
            }
            $stopwatch->stop('check_response');
            return $responseCheckMessage;
        } while ($stopwatch->lap('check_response')->getDuration() > $responseTimeout);

        throw new SmsResponseTimeoutException($line);
    }
}
