<?php
/**
 * @copyright Copyright © 2024 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Mermaid\EntityRelationshipDiagram;

use BeastBytes\Mermaid\Mermaid;
use BeastBytes\Mermaid\MermaidInterface;
use BeastBytes\Mermaid\TitleTrait;

final class EntityRelationshipDiagram implements MermaidInterface
{
    use TitleTrait;

    private const TYPE = 'erDiagram';

    /** @var Entity[] $entities */
    private array $entities = [];
    /** @var Relationship[] $relationships */
    private array $relationships = [];

    public function __construct(private readonly string $title = '')
    {
    }

    public function __toString(): string
    {
        return $this->render();
    }

    public function addEntity(Entity ...$entity): self
    {
        $new = clone $this;
        $new->entities = array_merge($new->entities, $entity);
        return $new;
    }

    public function withEntity(Entity ...$entity): self
    {
        $new = clone $this;
        $new->entities = $entity;
        return $new;
    }

    public function addRelationship(Relationship ...$relationship): self
    {
        $new = clone $this;
        $new->relationships = array_merge($new->relationships, $relationship);
        return $new;
    }

    public function withRelationship(Relationship ...$relationship): self
    {
        $new = clone $this;
        $new->relationships = $relationship;
        return $new;
    }

    public function render(): string
    {
        /** @psalm-var list<string> $output */
        $output = [];

        if ($this->title !== '') {
            $output[] = $this->getTitle();
        }

        $output[] = self::TYPE;

        foreach ($this->entities as $entity) {
            $output[] = $entity->render(Mermaid::INDENTATION);
        }

        foreach ($this->relationships as $relationship) {
            $output[] = $relationship->render(Mermaid::INDENTATION);
        }

        return Mermaid::render($output);
    }
}