<?php

use BeastBytes\Mermaid\EntityRelationshipDiagram\Attribute;
use BeastBytes\Mermaid\EntityRelationshipDiagram\Cardinality;
use BeastBytes\Mermaid\EntityRelationshipDiagram\Entity;
use BeastBytes\Mermaid\EntityRelationshipDiagram\EntityRelationshipDiagram;
use BeastBytes\Mermaid\EntityRelationshipDiagram\Key;
use BeastBytes\Mermaid\EntityRelationshipDiagram\Relationship;
use BeastBytes\Mermaid\EntityRelationshipDiagram\RelationshipType;

test('Entity Relationship Diagram', function () {
    $car = (new Entity('c', 'CAR'))
        ->withAttribute(
            new Attribute('registration_number', 'varchar(7)', Key::PrimaryKey),
            new Attribute('make', 'int(11)', Key::ForeignKey),
            new Attribute('model', 'varchar(255)')
        )
    ;

    $manufacturer = (new Entity('m', 'MANUFACTURER'))
        ->withAttribute(
            new Attribute('id', 'int(11)', Key::PrimaryKey),
            new Attribute('name', 'varchar(255)')
        )
    ;

    $person = (new Entity('p', 'PERSON'))
        ->withAttribute(
            new Attribute('licence', 'varchar(255)', Key::PrimaryKey, 'Driver\'s licence number'),
            new Attribute('email', 'varchar(255)', Key::UniqueKey),
            new Attribute('given_name', 'varchar(255)'),
            new Attribute('family_name', 'varchar(255)'),
            new Attribute('dob', 'date', null, 'Date of birth')
        )
    ;

    $namedDriver = (new Entity('nd', 'NAMED DRIVER'))
        ->withAttribute(
            new Attribute('registration_number', 'varchar(255)', [Key::PrimaryKey, Key::ForeignKey]),
            new Attribute('driver_licence', 'varchar(255)', [Key::PrimaryKey, Key::ForeignKey])
        )
    ;

    $manufacturerCar = new Relationship(
        $manufacturer,
        Cardinality::ExactlyOne,
        $car,
        Cardinality::OneOrMore,
        RelationshipType::Identifying,
        'makes'
    );

    $carNamedDriver = new Relationship(
        $car,
        Cardinality::ExactlyOne,
        $namedDriver,
        Cardinality::OneOrMore,
        RelationshipType::Identifying,
        'allows'
    );

    $personNamedDriver = new Relationship(
        $person,
        Cardinality::ExactlyOne,
        $namedDriver,
        Cardinality::OneOrMore,
        RelationshipType::Identifying,
        'is'
    );

    $entityRelationDiagram = (new EntityRelationshipDiagram('Car Drivers'))
        ->withEntity($manufacturer, $car)
        ->addEntity($person, $namedDriver)
        ->withRelationship($manufacturerCar)
        ->addRelationship($carNamedDriver, $personNamedDriver)
    ;

    expect($entityRelationDiagram->render())
        ->toBe("<pre class=\"mermaid\">\n"
            . "---\n"
            . "title: Car Drivers\n"
            . "---\n"
            . "erDiagram\n"
            . "  m[&quot;MANUFACTURER&quot;] {\n"
            . "    int(11) id PK\n"
            . "    varchar(255) name\n"
            . "  }\n"
            . "  c[&quot;CAR&quot;] {\n"
            . "    varchar(7) registration_number PK\n"
            . "    int(11) make FK\n"
            . "    varchar(255) model\n"
            . "  }\n"
            . "  p[&quot;PERSON&quot;] {\n"
            . "    varchar(255) licence PK &quot;Driver&#039;s licence number&quot;\n"
            . "    varchar(255) email UK\n"
            . "    varchar(255) given_name\n"
            . "    varchar(255) family_name\n"
            . "    date dob &quot;Date of birth&quot;\n"
            . "  }\n"
            . "  nd[&quot;NAMED DRIVER&quot;] {\n"
            . "    varchar(255) registration_number PK,FK\n"
            . "    varchar(255) driver_licence PK,FK\n"
            . "  }\n"
            . "  m ||--|{ c : &quot;makes&quot;\n"
            . "  c ||--|{ nd : &quot;allows&quot;\n"
            . "  p ||--|{ nd : &quot;is&quot;\n"
            . '</pre>'
        )
    ;
});
