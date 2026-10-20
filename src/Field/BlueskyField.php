<?php

declare(strict_types=1);

namespace Contenir\Extension\Social\Field;

use Contenir\Social\Network;
use Override;

/**
 * A field holding the site's Bluesky profile: social:bluesky.
 *
 * @api
 */
final class BlueskyField extends AbstractProfileField
{
    public const string NAME = 'bluesky';

    #[Override]
    public function network(): Network
    {
        return Network::Bluesky;
    }
}
