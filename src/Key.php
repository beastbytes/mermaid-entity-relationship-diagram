<?php
/**
 * @copyright Copyright © 2024 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Mermaid\EntityRelationshipDiagram;

enum Key: string
{
    case ForeignKey = 'FK';
    case PrimaryKey = 'PK';
    case UniqueKey = 'UK';
}
