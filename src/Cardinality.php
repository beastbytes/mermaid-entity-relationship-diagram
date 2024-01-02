<?php
/**
 * @copyright Copyright © 2024 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Mermaid\EntityRelationshipDiagram;

enum Cardinality: string
{
    case ExactlyOne = '||';
    case OneOrMore = '}|';
    case ZeroOrMore = '}o';
    case ZeroOrOne = '|o';
}
