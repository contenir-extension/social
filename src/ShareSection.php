<?php

declare(strict_types=1);

namespace Contenir\Extension\Social;

use Contenir\Extension\Api\Form\Field;
use Contenir\Extension\Api\Form\FieldType;
use Contenir\Extension\Api\Form\Form;
use Contenir\Extension\Api\Settings\SettingsCategory;
use Contenir\Extension\Api\Settings\SettingsSection;
use Contenir\Social\SettingKeys;
use Contenir\Social\Share\ShareTarget;

/**
 * Share Buttons, under Social: which buttons share() shows and in what
 * order, as rows an editor drags, whether their names show beside their
 * icons, and whether shared addresses carry UTM tags.
 *
 * @api
 */
final class ShareSection
{
    public const string NAME = 'social-share';

    public const string NETWORKS = 'share_networks';

    public const string NETWORK = 'network';

    public const string LABELS = 'share_labels';

    public const string UTM = 'share_utm';

    public static function define(): SettingsSection
    {
        return new SettingsSection(
            name: self::NAME,
            title: 'Share Buttons',
            category: SettingsCategory::Social,
            form: new Form([
                new Field(
                    name: self::NETWORKS,
                    label: 'Buttons',
                    type: FieldType::Multilink,
                    description: 'The buttons on each page, in order; drag a row to move it. Leave empty for'
                        . ' Facebook, X, LinkedIn, Email, Copy link and Share…. Pinterest shows only on pages with an'
                        . ' image, and Share… only where the visitor\'s browser has a share sheet, which is mostly'
                        . ' phones.',
                    setting: SettingKeys::SHARE_NETWORKS,
                    fields: [
                        new Field(
                            name: self::NETWORK,
                            label: 'Button',
                            type: FieldType::Select,
                            required: true,
                            options: self::targets(),
                        ),
                    ],
                ),
                new Field(
                    name: self::LABELS,
                    label: 'Show names beside icons',
                    type: FieldType::Checkbox,
                    description: 'Off shows icons alone. Each button still has its name for screen readers.',
                    setting: SettingKeys::SHARE_LABELS,
                    default: true,
                ),
                new Field(
                    name: self::UTM,
                    label: 'Add UTM tags',
                    type: FieldType::Checkbox,
                    description: 'Tag shared addresses with utm_source (the button), utm_medium and'
                        . ' utm_campaign=share, so visits from shares show as such in analytics.',
                    setting: SettingKeys::SHARE_UTM,
                    default: false,
                ),
            ]),
        );
    }

    /**
     * Every button, value => name, in the order sites offer them.
     *
     * @return array<string, string>
     */
    private static function targets(): array
    {
        $targets = [];
        foreach (ShareTarget::cases() as $target) {
            $targets[$target->value] = $target->label();
        }

        return $targets;
    }
}
