<?php

namespace Tests\GoIP\Sms;

use Tests\GoIP\Integration\GoipPhpTestCase;

class SmsMapperTest extends GoipPhpTestCase
{
    public function testFindAll(): void
    {
        $messages = parent::$smsMapper->findAll();
        $this->assertIsArray($messages);
    }

    public function testFindByLine(): void
    {
        $messages = parent::$smsMapper->findByLine(intval($_ENV['GOIP_CLIENT_DEFAULT_LINE']));
        $this->assertIsArray($messages);
    }
}
