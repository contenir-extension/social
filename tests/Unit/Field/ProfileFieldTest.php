<?php

declare(strict_types=1);

namespace Contenir\Extension\Social\Tests\Unit\Field;

use Contenir\Extension\Api\Context\ExtensionContextInterface;
use Contenir\Extension\Api\Form\FieldType;
use Contenir\Extension\Social\Field\AbstractProfileField;
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
use Contenir\Social\Network;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[Group('unit')]
final class ProfileFieldTest extends TestCase
{
    /**
     * @return array<string, array{AbstractProfileField, Network, string}>
     */
    public static function fieldProvider(): array
    {
        return [
            'facebook'  => [new FacebookField(), Network::Facebook, 'facebook'],
            'instagram' => [new InstagramField(), Network::Instagram, 'instagram'],
            'linkedin'  => [new LinkedInField(), Network::LinkedIn, 'linkedin'],
            'x'         => [new XField(), Network::X, 'x'],
            'youtube'   => [new YouTubeField(), Network::YouTube, 'youtube'],
            'tiktok'    => [new TikTokField(), Network::TikTok, 'tiktok'],
            'pinterest' => [new PinterestField(), Network::Pinterest, 'pinterest'],
            'threads'   => [new ThreadsField(), Network::Threads, 'threads'],
            'bluesky'   => [new BlueskyField(), Network::Bluesky, 'bluesky'],
            'mastodon'  => [new MastodonField(), Network::Mastodon, 'mastodon'],
        ];
    }

    /**
     * @return array<string, array{AbstractProfileField, mixed, mixed}>
     */
    public static function normalisedProvider(): array
    {
        return [
            'a handle the core stored'   => [
                new InstagramField(),
                'housesmagazine',
                'https://www.instagram.com/housesmagazine/',
            ],
            'a handle with an @'         => [new XField(), ' @HousesMag ', 'https://x.com/HousesMag'],
            'an address in another form' => [new XField(), 'twitter.com/HousesMag', 'https://x.com/HousesMag'],
            'a mastodon account'         => [new MastodonField(), '@houses@aus.social', 'https://aus.social/@houses'],
            'not a profile, kept'        => [
                new FacebookField(),
                ' https://www.instagram.com/x/ ',
                'https://www.instagram.com/x/',
            ],
            'nothing'                    => [new LinkedInField(), '', ''],
            'not text'                   => [new LinkedInField(), ['x'], ''],
        ];
    }

    /**
     * @return array<string, array{AbstractProfileField, mixed, list<string>}>
     */
    public static function validatedProvider(): array
    {
        return [
            'a profile'         => [new InstagramField(), 'https://www.instagram.com/housesmagazine/', []],
            'nothing'           => [new InstagramField(), ' ', []],
            'not text'          => [new InstagramField(), null, []],
            'another network'   => [
                new FacebookField(),
                'https://www.instagram.com/x/',
                [
                    'That address is on www.instagram.com, not Facebook. Enter the profile\'s address, such as'
                        . ' https://www.facebook.com/yourpage.',
                ],
            ],
            'a linkedin handle' => [
                new LinkedInField(),
                'houses',
                [
                    'That isn\'t a profile on LinkedIn. Enter its address, such as'
                        . ' https://www.linkedin.com/company/yourname/.',
                ],
            ],
        ];
    }

    #[Test]
    #[DataProvider('validatedProvider')]
    public function explainsAValueThatIsNotAProfile(AbstractProfileField $field, mixed $value, array $messages): void
    {
        static::assertSame($messages, $field->validate($value));
    }

    #[Test]
    #[DataProvider('fieldProvider')]
    public function holdsOneNetworksProfileInATextControl(
        AbstractProfileField $field,
        Network $network,
        string $name,
    ): void {
        static::assertSame(
            [$network, $name, FieldType::Text, null, []],
            [
                $field->network(),
                $field::NAME,
                $field->control(),
                $field->component(),
                $field->options($this->createStub(ExtensionContextInterface::class)),
            ],
        );
    }

    #[Test]
    #[DataProvider('normalisedProvider')]
    public function storesTheProfilesCanonicalAddress(AbstractProfileField $field, mixed $value, mixed $stored): void
    {
        static::assertSame($stored, $field->normalise($value));
    }
}
