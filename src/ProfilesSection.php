<?php

declare(strict_types=1);

namespace Contenir\Extension\Social;

use Contenir\Extension\Api\Form\Field;
use Contenir\Extension\Api\Form\Form;
use Contenir\Extension\Api\Handle;
use Contenir\Extension\Api\Settings\SettingsCategory;
use Contenir\Extension\Api\Settings\SettingsSection;
use Contenir\Social\Network;

use function array_map;

/**
 * Social Media Links, under Social, where the CMS's plugin of that name was:
 * a profile address for each network. Each is stored under the key
 * contenir/social reads (social.social_*), the plugin's own keys for the five
 * networks it had, so sites and the SEO add-on read the same values.
 *
 * @api
 */
final class ProfilesSection
{
    public const string NAME = 'social';

    /**
     * The section, with field types named for the add-on's handle.
     */
    public static function define(Handle $handle): SettingsSection
    {
        return new SettingsSection(
            name: self::NAME,
            title: 'Social Media Links',
            category: SettingsCategory::Social,
            form: new Form(array_map(
                static fn(Network $network): Field => new Field(
                    name: $network->value,
                    label: self::label($network),
                    type: $handle->fieldType($network->value),
                    description: self::description($network),
                    setting: $network->settingKey(),
                    attributes: ['placeholder' => $network->example()],
                ),
                Network::cases(),
            )),
        );
    }

    /**
     * What the editor is asked for.
     */
    private static function description(Network $network): string
    {
        return match ($network) {
            Network::LinkedIn => 'The page\'s address, such as https://www.linkedin.com/company/yourname/ or'
                . ' https://www.linkedin.com/in/yourname/.',
            Network::Mastodon => 'The profile\'s address on its server, such as https://mastodon.social/@yourname,'
                . ' or @yourname@mastodon.social.',
            default           => "The profile's address, such as {$network->example()}, or {$network->handleExample()}.",
        };
    }

    private static function label(Network $network): string
    {
        return match ($network) {
            Network::Facebook, Network::LinkedIn => "{$network->label()} page",
            Network::X                           => 'X (Twitter)',
            Network::YouTube                     => 'YouTube channel',
            default                              => $network->label(),
        };
    }
}
