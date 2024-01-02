<?php

use BeastBytes\Mermaid\EntityRelationshipDiagram\Attribute;
use BeastBytes\Mermaid\EntityRelationshipDiagram\Cardinality;
use BeastBytes\Mermaid\EntityRelationshipDiagram\Entity;
use BeastBytes\Mermaid\EntityRelationshipDiagram\Key;
use BeastBytes\Mermaid\EntityRelationshipDiagram\Relationship;
use BeastBytes\Mermaid\EntityRelationshipDiagram\RelationshipType;
use BeastBytes\Mermaid\Mermaid;

test('Relationship with one entity', function () {
    $entity = new Entity('PERSON');
    $relationship = new Relationship($entity);

    expect($relationship->render(''))
        ->toBe('PERSON')
    ;
});

test('Relationship with missing parameter throws exception', function (
    ?Cardinality $cardinality,
    ?Entity $entity1,
    ?Cardinality $cardinality1,
    ?RelationshipType $relationshipType,
    ?string $label
) {
    $entity = new Entity('PERSON');
    new Relationship($entity, $cardinality, $entity1, $cardinality1, $relationshipType, $label);
})
    ->throws(
        InvalidArgumentException::class,
        'If any of the optional parameters are not NULL, all parameters are required'
    )
    ->with('missingParameter')
;

test('Relationship types', function (
    Cardinality $cardinality,
    Cardinality $cardinality1,
    RelationshipType $relationshipType,
    string $label
) {
    $entity = new Entity('PERSON');
    $entity1 = new Entity('HOUSE');
    $relationship = new Relationship($entity, $cardinality, $entity1, $cardinality1, $relationshipType, $label);

    expect($relationship->render(''))
        ->toBe('PERSON '
            . $cardinality->value
            . $relationshipType->value
            . str_replace('}', '{', strrev($cardinality1->value))
            . ' HOUSE : "'
            . $label
            . '"'
        )
    ;
})
    ->with('cardinalities')
    ->with('cardinalities')
    ->with('relationshipTypes')
    ->with('labels')
;

dataset('missingParameter', [
    [null, new Entity('HOUSE'), Cardinality::ExactlyOne, RelationshipType::Identifying, 'label'],
    [Cardinality::ExactlyOne, null, Cardinality::ExactlyOne, RelationshipType::Identifying, 'label'],
    [Cardinality::ExactlyOne, new Entity('HOUSE'), null, RelationshipType::Identifying, 'label'],
    [Cardinality::ExactlyOne, new Entity('HOUSE'), Cardinality::ExactlyOne, null, 'label'],
    [Cardinality::ExactlyOne, new Entity('HOUSE'), Cardinality::ExactlyOne, RelationshipType::Identifying, null],
]);

dataset('cardinalities', [
    Cardinality::ExactlyOne,
    Cardinality::OneOrMore,
    Cardinality::ZeroOrMore,
    Cardinality::ZeroOrOne,
]);

dataset('relationshipTypes', [
    RelationshipType::Identifying,
    RelationshipType::NonIdentifying,
]);

dataset('labels', [
    'label',
    'label with more than one word',
]);
