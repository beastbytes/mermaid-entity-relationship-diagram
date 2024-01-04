<?php
/**
 * @copyright Copyright © 2024 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Mermaid\EntityRelationshipDiagram;

use InvalidArgumentException;

final class Relationship
{
    public function __construct(
        private readonly Entity $entity,
        private readonly ?Cardinality $cardinality = null,
        private readonly ?Entity $entity1 = null,
        private readonly ?Cardinality $cardinality1 = null,
        private readonly ?RelationshipType $relationshipType = null,
        private readonly ?string $label = null
    )
    {
        if (
            (
                $this->cardinality !== null
                || $this->entity1 !== null
                || $this->cardinality1 !== null
                || $this->relationshipType !== null
                || $this->label !== null
            )
            && (
                $this->cardinality === null
                || $this->entity1 === null
                || $this->cardinality1 === null
                || $this->relationshipType === null
                || $this->label === null
            )
        ) {
            throw new InvalidArgumentException(
                'If any of the optional parameters are not NULL, all parameters are required'
            );
        }
    }

    /** @internal */
    public function render(string $indentation): string
    {
        $output = $indentation . $this->entity->getName();

        /** @psalm-suppress PossiblyNullArgument,PossiblyNullOperand,PossiblyNullPropertyFetch */
        if ($this->cardinality !== null) {
            $output .= ' '
                . $this->cardinality->value
                . $this->relationshipType->value
                . str_replace('}', '{', strrev($this->cardinality1->value))
                . ' '
                . $this->entity1?->getName()
                . ' : "'
                . $this->label
                . '"'
            ;
        }

        return $output;
    }
}
