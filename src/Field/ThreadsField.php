<?php

declare(strict_types=1);

namespace Contenir\Extension\Social\Field;

use Contenir\Social\Network;
use Override;

/**
 * A field holding the site's Threads profile: social:threads.
 *
 * @api
 */
final class ThreadsField extends AbstractProfileField
{
    public const string NAME = 'threads';

    #[Override]
    public function network(): Network
    {
        return Network::Threads;
    }
}
