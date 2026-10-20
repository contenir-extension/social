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
 * A text field holding a site's profile on one network. What an editor
 * gives, an address in any form or just the account, is stored as the
 * profile's canonical address; anything that isn't a profile on the network
 * is refused with a message saying why. A handle stored by the CMS's Social
 * Media Links plugin shows in the field as it is, and becomes an address
 * when the section is next saved.
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
     * Text rather than an address field, so a handle saved before shows,
     * and saves, without the browser refusing it.
     */
    #[Override]
    public function control(): FieldType
    {
        return FieldType::Text;
    }

    #[Override]
    public function normalise(mixed $value): mixed
    {
        $text = self::text($value);

        return ProfileUrl::tryParse($this->network(), $text)->url ?? $text;
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
