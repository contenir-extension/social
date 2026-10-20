<?php

declare(strict_types=1);

namespace Contenir\Extension\Social\Field;

use Contenir\Social\Network;
use Override;

/**
 * A field holding the site's YouTube profile: social:youtube.
 *
 * @api
 */
final class YouTubeField extends AbstractProfileField
{
    public const string NAME = 'youtube';

    #[Override]
    public function network(): Network
    {
        return Network::YouTube;
    }
}
