<?php

declare(strict_types=1);

namespace Contenir\Extension\Social\Tests\Unit;

use Contenir\Extension\Api\Field\FieldTypeDeclaration;
use Contenir\Extension\Api\Registry;
use Contenir\Extension\Api\Settings\SettingsSection;
use Contenir\Extension\Social\Field\BlueskyField;
use Contenir\Extension\Social\Field\FacebookField;
use Contenir\Extension\Social\Field\InstagramField;
use Contenir\Extension\Social\Field\LinkedInField;
use Contenir\Extension\Social\Field\MastodonField;
use Contenir\Extension\Social\Field\PinterestField;
use Contenir\Extension\Social\Field\ThreadsField;
use Contenir\Extension\Social\Field\TikTokField;
use Contenir\Extension\Social\Field\XField;
use Contenir\Extension\Social\Field\YouTubeField;
use Contenir\Extension\Social\SocialExtension;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

use function array_map;
use function array_values;

#[Group('unit')]
final class SocialExtensionTest extends TestCase
{
    private static function registry(): Registry
    {
        $registry = new Registry('social');
        (new SocialExtension())->register($registry);

        return $registry;
    }

    #[Test]
    public function registersAFieldTypeForEachNetwork(): void
    {
        static::assertSame(
            [
                ['social:facebook',  FacebookField::class],
                ['social:instagram', InstagramField::class],
                ['social:linkedin',  LinkedInField::class],
                ['social:x',         XField::class],
                ['social:youtube',   YouTubeField::class],
                ['social:tiktok',    TikTokField::class],
                ['social:pinterest', PinterestField::class],
                ['social:threads',   ThreadsField::class],
                ['social:bluesky',   BlueskyField::class],
                ['social:mastodon',  MastodonField::class],
            ],
            array_map(
                static fn(FieldTypeDeclaration $type): array => [$type->type, $type->class],
                array_values(self::registry()->registration()->fieldTypes),
            ),
        );
    }

    #[Test]
    public function registersNothingElse(): void
    {
        $registration = self::registry()->registration();

        static::assertSame(
            [[], [], [], [], [], []],
            [
                $registration->diagnostics,
                $registration->listeners,
                $registration->handlers,
                $registration->webhooks,
                $registration->schedules,
                $registration->scripts,
            ],
        );
    }

    #[Test]
    public function registersSocialMediaLinksAndShareButtons(): void
    {
        static::assertSame(
            ['social', 'social-share'],
            array_map(
                static fn(SettingsSection $section): string => $section->name,
                array_values(self::registry()->registration()->settingsSections),
            ),
        );
    }
}
