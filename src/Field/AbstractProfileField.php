<?php

declare(strict_types=1);

namespace Contenir\Extension\Social\Field;

use Contenir\Extension\Api\Context\ExtensionContextInterface;
use Contenir\Extension\Api\Field\FieldTypeInterface;
use Contenir\Extension\Api\Form\FieldType;
use Contenir\Social\Network;
use Contenir\Social\ProfileUrl;
use Override;

use function is_string;
use function trim;

/**
 * A text field holding a site's profile on one network: its address in any
 * form the network serves it in, or just the account (@yourname). The value
 * is stored as the editor gave it, so templates that build a link from a
 * stored handle keep working; contenir/social builds the full address when
 * a page is written. Anything that isn't a profile on the network is refused
 * with a message saying why.
 *
 * @api
 */
abstract class AbstractProfileField implements FieldTypeInterface
{
    private static function text(mixed $value): string
    {
        return is_string($value) ? trim($value) : '';
    }

    /**
     * The network whose profiles the field holds.
     */
    abstract public function network(): Network;

    #[Override]
    public function component(): ?string
    {
        return null;
    }

    /**
     * Text rather than an address field, so a handle shows, and saves,
     * without the browser refusing it.
     */
    #[Override]
    public function control(): FieldType
    {
        return FieldType::Text;
    }

    /**
     * The value as the editor gave it, without surrounding spaces.
     */
    #[Override]
    public function normalise(mixed $value): mixed
    {
        return self::text($value);
    }

    #[Override]
    public function options(ExtensionContextInterface $context): array
    {
        return [];
    }

    #[Override]
    public function validate(mixed $value): array
    {
        $problem = ProfileUrl::problem($this->network(), self::text($value));

        return null === $problem ? [] : [$problem];
    }
}
