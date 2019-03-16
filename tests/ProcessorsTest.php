<?php
namespace MonologTap\Test;

use Mockery;
use Illuminate\Log\Logger;
use Monolog\Logger as Monolog;
use PHPUnit\Framework\TestCase;
use MonologTap\MonologProcessors;
use Monolog\Processor\UidProcessor;

class ProcessorsTest extends TestCase
{
    public function tearDown()
    {
        Mockery::close();
    }

    /**
     * @test
     */
    public function it_pushes_processors_to_handler()
    {
        app()->shouldReceive('make')
            ->once()
            ->with('\Monolog\Processor\UidProcessor')
            ->andReturn('uid-processor');

        $logger     = Mockery::mock(new Logger(new Monolog('foo')));
        $handler    = Mockery::mock('handler');

        $logger->shouldReceive('getHandlers')->andReturn([$handler]);
        $handler->shouldReceive('pushProcessor')->with('uid-processor');

        (new MonologProcessors)->__invoke($logger,...['uid']);
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Processor [FooProcessor] is not defined
     */
    public function it_throws_an_exception_when_providing_invalid_processors()
    {
        $logger = new Logger(
            new Monolog('foo')
        );

        (new MonologProcessors)->__invoke($logger,...['foo']);
    }
}
