<?php

declare(strict_types=1);

namespace Contenir\Extension\Social\Field;

use Contenir\Social\Network;
use Override;

/**
 * A field holding the site's LinkedIn profile: social:linkedin.
 *
 * @api
 */
final class LinkedInField extends AbstractProfileField
{
    public const string NAME = 'linkedin';

    #[Override]
    public function network(): Network
    {
        return Network::LinkedIn;
    }
}
