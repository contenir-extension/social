<?php

declare(strict_types=1);

namespace Contenir\Extension\Social\Tests\Unit;

use Contenir\Extension\Api\Form\Field;
use Contenir\Extension\Api\Form\FieldType;
use Contenir\Extension\Api\Settings\SettingsCategory;
use Contenir\Extension\Social\ShareSection;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[Group('unit')]
final class ShareSectionTest extends TestCase
{
    /**
     * @return list<mixed>
     */
    private static function describe(?Field $field): array
    {
        return [
            $field?->label,
            $field?->type,
            $field?->setting,
            $field?->description,
            $field?->default,
        ];
    }

    #[Test]
    public function asksForTheButtonsAsRowsToDrag(): void
    {
        static::assertSame(
            [
                'Buttons',
                FieldType::Multilink->value,
                'extensions.social.share_networks',
                'The buttons on each page, in order; drag a row to move it. Leave empty for Facebook, X, LinkedIn,'
                    . ' Email, Copy link and Share…. Pinterest shows only on pages with an image, and Share… only where'
                    . ' the visitor\'s browser has a share sheet, which is mostly phones.',
                null,
            ],
            self::describe(ShareSection::define()->form->field('share_networks')),
        );
    }

    #[Test]
    public function leavesAddressesUntaggedByDefault(): void
    {
        static::assertSame(
            [
                'Add UTM tags',
                FieldType::Checkbox->value,
                'extensions.social.share_utm',
                'Tag shared addresses with utm_source (the button), utm_medium and utm_campaign=share, so visits from'
                    . ' shares show as such in analytics.',
                false,
            ],
            self::describe(ShareSection::define()->form->field('share_utm')),
        );
    }

    #[Test]
    public function offersEveryButtonInEachRow(): void
    {
        $row = ShareSection::define()->form->field('share_networks')?->fields[0];

        static::assertSame(
            [
                'network',
                'Button',
                FieldType::Select->value,
                true,
                [
                    'facebook'  => 'Facebook',
                    'x'         => 'X',
                    'linkedin'  => 'LinkedIn',
                    'whatsapp'  => 'WhatsApp',
                    'email'     => 'Email',
                    'bluesky'   => 'Bluesky',
                    'threads'   => 'Threads',
                    'reddit'    => 'Reddit',
                    'pinterest' => 'Pinterest',
                    'telegram'  => 'Telegram',
                    'copy'      => 'Copy link',
                    'share'     => 'Share…',
                ],
            ],
            [$row?->name, $row?->label, $row?->type, $row?->required, $row?->options],
        );
    }

    #[Test]
    public function showsNamesBesideIconsByDefault(): void
    {
        static::assertSame(
            [
                'Show names beside icons',
                FieldType::Checkbox->value,
                'extensions.social.share_labels',
                'Off shows icons alone. Each button still has its name for screen readers.',
                true,
            ],
            self::describe(ShareSection::define()->form->field('share_labels')),
        );
    }

    #[Test]
    public function sitsUnderSocialAsShareButtons(): void
    {
        $section = ShareSection::define();

        static::assertSame(
            ['social-share', 'Share Buttons', SettingsCategory::Social],
            [$section->name, $section->title, $section->category],
        );
    }
}
