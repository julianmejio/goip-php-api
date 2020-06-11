<?php

namespace GoIP\Sms;

/**
 * SMS mapper.
 * It offers a compatible conversion from {@link \GoIP\Sms} to {@link Sms}
 *
 * @package GoIP\Sms
 */
class SmsMapper
{
    /**
     * @var SmsAdapter
     */
    private $adapter;

    public function __construct(SmsAdapter $adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * Get all the SMS from all the lines
     *
     * @return array Returns the list of SMS found in all the lines.
     *
     * @throws \Exception
     */
    public function findAll(): array
    {
        $messagesStates = $this->adapter->findAll();
        $smsList = [];
        foreach ($messagesStates as $lineNumber => $smsStates) {
            foreach ($smsStates as $smsState) {
                $smsList[] = ($this->mapStateToSms($smsState))->setLine($lineNumber);
            }
        }
        return $smsList;
    }

    /**
     * Gets all the SMS from a line slot number
     *
     * @param int $line Line slot number
     *
     * @return array Returns the SMS list of the given line slot number.
     *
     * @throws \Exception
     */
    public function findByLine(int $line): array
    {
        $messagesStates = $this->adapter->findByLine($line);
        $smsList = [];
        foreach ($messagesStates as $smsState) {
            $smsList[] = $this->mapStateToSms($smsState)->setLine($line);
        }
        return $smsList;
    }

    /**
     * Maps the array state to an {@link Sms} model.
     *
     * @param array $state Array state
     *
     * @return Sms Returns the SMS object.
     *
     * @throws \Exception
     */
    private function mapStateToSms(array $state): Sms
    {
        return Sms::fromState($state);
    }
}
