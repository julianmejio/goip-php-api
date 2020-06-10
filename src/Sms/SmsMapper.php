<?php


namespace GoIP\Sms;

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
     */
    public function findAll(): array
    {
        $messagesStates = $this->adapter->findAll();
        $smsList = [];
        foreach ($messagesStates as $state) {
            $smsList[] = $this->mapStateToSms($state);
        }
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
