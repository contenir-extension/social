<?php

declare(strict_types=1);

namespace Contenir\Extension\Social\Tests\Unit;

use Contenir\Extension\Api\Form\Field;
use Contenir\Extension\Api\Handle;
use Contenir\Extension\Api\Settings\SettingsCategory;
use Contenir\Extension\Social\ProfilesSection;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

use function array_map;

#[Group('unit')]
final class ProfilesSectionTest extends TestCase
{
    /**
     * @return array<string, array{string, string, string, string, string}>
     */
    public static function fieldProvider(): array
    {
        return [
            'facebook'  => [
                'facebook',
                'Facebook page',
                'social.social_facebook',
                'The profile\'s address, such as https://www.facebook.com/yourpage, or @yourname.',
                'https://www.facebook.com/yourpage',
            ],
            'instagram' => [
                'instagram',
                'Instagram',
                'social.social_instagram',
                'The profile\'s address, such as https://www.instagram.com/yourname/, or @yourname.',
                'https://www.instagram.com/yourname/',
            ],
            'linkedin'  => [
                'linkedin',
                'LinkedIn page',
                'social.social_linkedin',
                'The page\'s address, such as https://www.linkedin.com/company/yourname/ or'
                    . ' https://www.linkedin.com/in/yourname/.',
                'https://www.linkedin.com/company/yourname/',
            ],
            'x'         => [
                'x',
                'X (Twitter)',
                'social.social_twitter',
                'The profile\'s address, such as https://x.com/yourname, or @yourname.',
                'https://x.com/yourname',
            ],
            'youtube'   => [
                'youtube',
                'YouTube channel',
                'social.social_youtube',
                'The profile\'s address, such as https://www.youtube.com/@yourname, or @yourname.',
                'https://www.youtube.com/@yourname',
            ],
            'tiktok'    => [
                'tiktok',
                'TikTok',
                'social.social_tiktok',
                'The profile\'s address, such as https://www.tiktok.com/@yourname, or @yourname.',
                'https://www.tiktok.com/@yourname',
            ],
            'pinterest' => [
                'pinterest',
                'Pinterest',
                'social.social_pinterest',
                'The profile\'s address, such as https://www.pinterest.com/yourname/, or @yourname.',
                'https://www.pinterest.com/yourname/',
            ],
            'threads'   => [
                'threads',
                'Threads',
                'social.social_threads',
                'The profile\'s address, such as https://www.threads.com/@yourname, or @yourname.',
                'https://www.threads.com/@yourname',
            ],
            'bluesky'   => [
                'bluesky',
                'Bluesky',
                'social.social_bluesky',
                'The profile\'s address, such as https://bsky.app/profile/yourname.bsky.social, or'
                    . ' yourname.bsky.social.',
                'https://bsky.app/profile/yourname.bsky.social',
            ],
            'mastodon'  => [
                'mastodon',
                'Mastodon',
                'social.social_mastodon',
                'The profile\'s address on its server, such as https://mastodon.social/@yourname, or'
                    . ' @yourname@mastodon.social.',
                'https://mastodon.social/@yourname',
            ],
        ];
    }

    #[Test]
    #[DataProvider('fieldProvider')]
    public function asksForEachProfileUnderItsKey(
        string $name,
        string $label,
        string $setting,
        string $description,
        string $placeholder,
    ): void {
        $field = ProfilesSection::define(new Handle('social'))->form->field($name);

        static::assertSame(
            [$label, "social:{$name}", $setting, $description, ['placeholder' => $placeholder], false],
            [
                $field?->label,
                $field?->type,
                $field?->setting,
                $field?->description,
                $field?->attributes,
                $field?->local,
            ],
        );
    }

    #[Test]
    public function listsTheNetworksInTheOrderSitesListThem(): void
    {
        static::assertSame(
            [
                'facebook',
                'instagram',
                'linkedin',
                'x',
                'youtube',
                'tiktok',
                'pinterest',
                'threads',
                'bluesky',
                'mastodon',
            ],
            array_map(
                static fn(Field $field): string => $field->name,
                ProfilesSection::define(new Handle('social'))->form->fields,
            ),
        );
    }

    #[Test]
    public function sitsUnderSocialAsSocialMediaLinks(): void
    {
        $section = ProfilesSection::define(new Handle('social'));

        static::assertSame(
            ['social', 'Social Media Links', SettingsCategory::Social],
            [$section->name, $section->title, $section->category],
        );
    }
}
