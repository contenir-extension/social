<?php

declare(strict_types=1);

namespace Contenir\Extension\Social\Field;

use Contenir\Social\Network;
use Override;

/**
 * A field holding the site's TikTok profile: social:tiktok.
 *
 * @api
 */
final class TikTokField extends AbstractProfileField
{
    public const string NAME = 'tiktok';

    #[Override]
    public function network(): Network
    {
        return Network::TikTok;
    }
}
