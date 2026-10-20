<?php

declare(strict_types=1);

namespace Contenir\Extension\Social\Field;

use Contenir\Social\Network;
use Override;

/**
 * A field holding the site's Pinterest profile: social:pinterest.
 *
 * @api
 */
final class PinterestField extends AbstractProfileField
{
    public const string NAME = 'pinterest';

    #[Override]
    public function network(): Network
    {
        return Network::Pinterest;
    }
}
