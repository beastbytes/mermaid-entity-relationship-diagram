<?php
/**
 * @copyright Copyright © 2024 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Mermaid\EntityRelationshipDiagram;

final class Attribute
{
    public function __construct(
        private readonly string $name,
        private readonly string $type,
        private readonly null|array|Key $key = null,
        private readonly string $comment = ''
    )
    {
    }

    public function render(string $indentation): string
    {
        return $indentation . $this->type . ' ' . $this->name
            . ($this->key === null ? '' : ' ' . $this->key($this->key))
            . ($this->comment === '' ? '' : ' "' . $this->comment . '"')
        ;
    }

    /**
     * @psalm-param Key|Key[] $key
     * @param array|Key $key
     * @return string
     */
    private function key(array|Key $key): string
    {
        if (is_array($key)) {
            array_walk($key, static function(Key &$k) {
                $k = $k->value;
            });
            return implode(',', $key);
        }

        return $key->value;
    }
}
