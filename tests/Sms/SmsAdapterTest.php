<?php

namespace Tests\GoIP\Sms;

use Tests\GoIP\Integration\GoipPhpTestCase;

class SmsAdapterTest extends GoipPhpTestCase
{
    public function testFindAll(): void
    {
        $messages = parent::$smsAdapter->findAll();
        $this->assertIsArray($messages);
    }

    public function testFindByLine(): void
    {
        $messages = parent::$smsAdapter->findByLine(intval($_ENV['GOIP_CLIENT_DEFAULT_LINE']));
        $this->assertIsArray($messages);
    }
}
