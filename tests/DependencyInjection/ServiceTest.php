<?php

namespace Euro\tests\DependencyInjection;

use Euro\DependencyInjection\Service;
use Euro\UsualClass;
use PHPUnit\Framework\TestCase;

class ServiceTest extends TestCase
{

    public function testAutoAlias()
    {
        $service = new Service(UsualClass::class);
        $service -> autoAlias();
        self::assertEquals('usual_class', $service -> getAlias());
    }
}
