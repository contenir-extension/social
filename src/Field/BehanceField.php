<?php

declare(strict_types=1);

namespace Contenir\Extension\Social\Field;

use Contenir\Social\Network;
use Override;

/**
 * A field holding the site's Behance profile: social:behance.
 *
 * @api
 */
final class BehanceField extends AbstractProfileField
{
    public const string NAME = 'behance';

    #[Override]
    public function network(): Network
    {
        return Network::Behance;
    }
}
