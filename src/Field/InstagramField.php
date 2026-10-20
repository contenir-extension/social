<?php

declare(strict_types=1);

namespace Contenir\Extension\Social\Field;

use Contenir\Social\Network;
use Override;

/**
 * A field holding the site's Instagram profile: social:instagram.
 *
 * @api
 */
final class InstagramField extends AbstractProfileField
{
    public const string NAME = 'instagram';

    #[Override]
    public function network(): Network
    {
        return Network::Instagram;
    }
}
