<?php

declare(strict_types=1);

namespace Contenir\Extension\Social\Field;

use Contenir\Social\Network;
use Override;

/**
 * A field holding the site's X profile: social:x.
 *
 * @api
 */
final class XField extends AbstractProfileField
{
    public const string NAME = 'x';

    #[Override]
    public function network(): Network
    {
        return Network::X;
    }
}
