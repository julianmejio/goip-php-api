<?php

namespace GoIP\Sms;

class Sms
{
    /**
     * @var int
     */
    private $line;

    /**
     * @var null|\DateTime
     */
    private $date;

    /**
     * @var null|string
     */
    private $sender;

    /**
     * @var null|string
     */
    private $receiver;

    /**
     * @var null|string
     */
    private $message;

    /**
     * Makes a new {@link Sms} from its array state
     *
     * @param array $state SMS state
     *
     * @return Sms Returns an SMS model instance.
     *
     * @throws \Exception
     */
    public static function fromState(array $state): Sms
    {
        return (new self())
            ->setDate((isset($state['date'])) ? new \DateTime($state['date']) : null)
            ->setSender((isset($state['sender'])) ? $state['sender'] : null)
            ->setMessage((isset($state['text'])) ? $state['text'] : null);
    }

    public function getLine(): int
    {
        return $this->line;
    }

    public function setLine(int $line): Sms
    {
        $this->line = $line;
        return $this;
    }

    public function getDate(): ?\DateTime
    {
        return $this->date;
    }

    public function setDate(?\DateTime $date): Sms
    {
        $this->date = $date;
        return $this;
    }

    public function getSender(): ?string
    {
        return $this->sender;
    }

    public function setSender(?string $sender): Sms
    {
        $this->sender = $sender;
        return $this;
    }

    public function getReceiver(): ?string
    {
        return $this->receiver;
    }

    public function setReceiver(?string $receiver): Sms
    {
        $this->receiver = $receiver;
        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(?string $message): Sms
    {
        $this->message = $message;
        return $this;
    }
}
