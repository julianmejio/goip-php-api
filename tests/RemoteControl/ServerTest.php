<?php

namespace Tests\GoIP\RemoteControl;

use GoIP\RemoteControl\Slave;
use Tests\GoIP\Integration\GoipPhpTestCase;

class ServerTest extends GoipPhpTestCase
{
    public function testFindSlaves(): void
    {
        $slaves = parent::$server->findSlaves();
        $this->assertIsArray($slaves);
        foreach ($slaves as $slave) {
            $matchingSlave = parent::$server->findSlave($slave->getName());
            $this->assertInstanceOf(Slave::class, $matchingSlave);
            $matchingSlave = parent::$server->findSlaveByName($slave->getName());
            $this->assertInstanceOf(Slave::class, $matchingSlave);
            $matchingSlave = parent::$server->findSlaveByIpAddress($slave->getExposedIpAddress());
            $this->assertInstanceOf(Slave::class, $matchingSlave);
        }
    }
}
