<?php

declare(strict_types=1);

namespace Contenir\Extension\Social\Field;

use Contenir\Social\Network;
use Override;

/**
 * A field holding the site's Facebook profile: social:facebook.
 *
 * @api
 */
final class FacebookField extends AbstractProfileField
{
    public const string NAME = 'facebook';

    #[Override]
    public function network(): Network
    {
        return Network::Facebook;
    }
}
