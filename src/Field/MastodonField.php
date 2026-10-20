<?php

declare(strict_types=1);

namespace Contenir\Extension\Social\Field;

use Contenir\Social\Network;
use Override;

/**
 * A field holding the site's Mastodon profile: social:mastodon.
 *
 * @api
 */
final class MastodonField extends AbstractProfileField
{
    public const string NAME = 'mastodon';

    #[Override]
    public function network(): Network
    {
        return Network::Mastodon;
    }
}
