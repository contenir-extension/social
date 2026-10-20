<?php

declare(strict_types=1);

namespace Contenir\Extension\Social\Tests\Integration;

use Contenir\Extension\Api\Event\Outcome;
use Contenir\Extension\Api\Testing\FrozenClock;
use Contenir\Extension\Api\Testing\InMemoryHost;
use Contenir\Extension\Social\SocialExtension;
use DateTimeImmutable;
use Nyholm\Psr7\Factory\Psr17Factory;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

/**
 * The add-on on the API's in-memory host: both sections load with their
 * defaults and save as the settings screen saves them.
 */
#[Group('integration')]
final class InMemoryHostTest extends TestCase
{
    private static function host(): InMemoryHost
    {
        $http = new Psr17Factory();
        $host = new InMemoryHost($http, $http, new FrozenClock(new DateTimeImmutable('2026-10-21T09:00:00+00:00')));
        $host->boot(['social' => new SocialExtension()], ['social']);

        return $host;
    }

    #[Test]
    public function loadsBothSectionsWithTheirDefaults(): void
    {
        $host = self::host();

        static::assertSame(
            [null, null, true, false],
            [
                $host->context('social')->settings('social')->get('instagram'),
                $host->context('social')->settings('social-share')->get('share_networks'),
                $host->context('social')->settings('social-share')->get('share_labels'),
                $host->context('social')->settings('social-share')->get('share_utm'),
            ],
        );
    }

    #[Test]
    public function loadsCleanly(): void
    {
        static::assertSame([], self::host()->problems());
    }

    #[Test]
    public function savesProfilesAndButtons(): void
    {
        $context = self::host()->context('social');

        static::assertSame(
            [Outcome::Done, Outcome::Done, 'https://www.instagram.com/houses/', [['fields' => ['network' => 'x']]]],
            [
                $context->settings('social')->set(['instagram' => 'https://www.instagram.com/houses/'])->outcome,
                $context->settings('social-share')->set([
                    'share_networks' => [['fields' => ['network' => 'x']]],
                ])->outcome,
                $context->settings('social')->get('instagram'),
                $context->settings('social-share')->get('share_networks'),
            ],
        );
    }
}
