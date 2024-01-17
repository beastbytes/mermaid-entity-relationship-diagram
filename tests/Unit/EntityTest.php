<?php

use BeastBytes\Mermaid\EntityRelationshipDiagram\Attribute;
use BeastBytes\Mermaid\EntityRelationshipDiagram\Entity;
use BeastBytes\Mermaid\EntityRelationshipDiagram\Key;
use BeastBytes\Mermaid\Mermaid;

defined('COMMENT') or define('COMMENT', 'comment');

test('Simple entity', function () {
    $entity = (new Entity('PERSON'))
        ->withAttribute(new Attribute('email', 'string'))
    ;

    expect($entity->render(''))
        ->toBe("PERSON {\n"
            . "  string email\n"
            . '}'
        )
    ;
});

test('Entity with alias', function () {
    $entity = (new Entity('p', 'PERSON'))
        ->withAttribute(new Attribute('email', 'string'))
    ;

    expect($entity->render(''))
        ->toBe("p[\"PERSON\"] {\n"
               . "  string email\n"
               . '}'
        )
    ;
});

test('Entity with comment', function () {
    $entity = (new Entity('p', 'PERSON'))
        ->withAttribute(new Attribute('email', 'string'))
        ->withComment(COMMENT)
    ;

    expect($entity->render(''))
        ->toBe('%% ' . COMMENT . "\n"
            . "p[\"PERSON\"] {\n"
            . "  string email\n"
            . '}'
        )
    ;
});

test('Entity with bad name throws exception', function (string $name) {
    new Entity($name);
})
    ->throws(
        InvalidArgumentException::class,
        '`$name` must begin with an alphabetic character or an underscore, and may also contain digits and hyphens'
    )
    ->with('badEntityNames')
;

test('Entity get Name', function () {
    $entity = new Entity('p', 'PERSON');

    expect($entity->getName())
        ->toBe('p')
    ;
    $entity = new Entity('p', 'PERSON');

    expect($entity->getName())
        ->toBe('p')
    ;
});

dataset('badEntityNames', [
    '', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '-',
    '!', '$', '%', '^', '&', '*', '(', ')', '[', ']', '#', '~', '\'', ':', ';', '.', ',',
    'a!', 'a$', 'a%', 'a^', 'a&', 'a*', 'a(', 'a)', 'a[', 'a]', 'a#', 'a~', 'a\'', 'a:', 'a;', 'a.', 'a,',
]);
