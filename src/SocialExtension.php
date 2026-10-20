<?php

declare(strict_types=1);

namespace Contenir\Extension\Social;

use Contenir\Extension\Api\ExtensionInterface;
use Contenir\Extension\Api\Registry;
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
use Override;

/**
 * The Social add-on: Social Media Links, with a field type for each network
 * that checks a profile and stores its canonical address, and Share Buttons.
 * Sites write both with a site adapter, such as contenir/social-laminas-mvc's
 * socialProfiles() and share().
 *
 * @api
 */
final class SocialExtension implements ExtensionInterface
{
    /**
     * The field type for each network, by name.
     */
    public const array FIELDS = [
        FacebookField::NAME  => FacebookField::class,
        InstagramField::NAME => InstagramField::class,
        LinkedInField::NAME  => LinkedInField::class,
        XField::NAME         => XField::class,
        YouTubeField::NAME   => YouTubeField::class,
        TikTokField::NAME    => TikTokField::class,
        PinterestField::NAME => PinterestField::class,
        ThreadsField::NAME   => ThreadsField::class,
        BlueskyField::NAME   => BlueskyField::class,
        MastodonField::NAME  => MastodonField::class,
    ];

    #[Override]
    public function register(Registry $registry): void
    {
        foreach (self::FIELDS as $name => $class) {
            $registry->fieldType((string) $name, $class);
        }

        $registry->settingsSection(ProfilesSection::define($registry->handle()));
        $registry->settingsSection(ShareSection::define());
    }
}
