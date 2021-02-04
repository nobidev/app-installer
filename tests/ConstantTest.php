<?php
/*
 * Copyright (c) 2021 NobiDev
 */

declare(strict_types=1);

namespace NobiDev\AppInstaller\Tests;

use NobiDev\AppInstaller\Constant;
use PHPUnit\Framework\TestCase;

/**
 * @package NobiDev\AppInstaller\Tests
 */
class ConstantTest extends TestCase
{
    public function testNameNotEmpty(): void
    {
        self::assertNotEmpty(Constant::getName());
    }
}
