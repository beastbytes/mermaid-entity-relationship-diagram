<?php
/**
 * @copyright Copyright © 2024 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Mermaid\EntityRelationshipDiagram;

use BeastBytes\Mermaid\Mermaid;
use InvalidArgumentException;

final class Entity
{
    private const NAME_REGEX = '/^[_a-zA-Z][\w-]*$/';
    /**
     * @psalm-var Attribute[] $attributes
     */
    private array $attributes = [];

    /**
     * @throws \Safe\Exceptions\PcreException
     */
    public function __construct(private readonly string $name, private readonly string $alias = '')
    {
        if (\Safe\preg_match(self::NAME_REGEX, $this->name) === 0) {
            throw new InvalidArgumentException(
                '`$name` must begin with an alphabetic character or an underscore, and may also contain digits and hyphens'
            );
        }
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function addAttribute(Attribute ...$attribute): self
    {
        $new = clone $this;
        $new->attributes = array_merge($new->attributes, $attribute);
        return $new;
    }

    public function withAttribute(Attribute ...$attribute): self
    {
        $new = clone $this;
        $new->attributes = $attribute;
        return $new;
    }

    public function render(string $indentation): string
    {
        $output = [];

        $output[] = $indentation . $this->name . ($this->alias === '' ? '' : '["' . $this->alias . '"]') . ' {';

        foreach ($this->attributes as $attribute) {
            $output[] = $attribute->render($indentation . Mermaid::INDENTATION);
        }

        $output[] = $indentation . '}';

        return implode("\n", $output);
    }
}
