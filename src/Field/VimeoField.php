<?php

declare(strict_types=1);

namespace Contenir\Extension\Social\Field;

use Contenir\Social\Network;
use Override;

/**
 * A field holding the site's Vimeo profile: social:vimeo.
 *
 * @api
 */
final class VimeoField extends AbstractProfileField
{
    public const string NAME = 'vimeo';

    #[Override]
    public function network(): Network
    {
        return Network::Vimeo;
    }
}
