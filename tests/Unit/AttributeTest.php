<?php

use BeastBytes\Mermaid\EntityRelationshipDiagram\Attribute;
use BeastBytes\Mermaid\EntityRelationshipDiagram\Key;

test('Simple entity', function () {
    $attribute = new Attribute('email', 'string');

    expect($attribute->render(''))
        ->toBe('string email')
    ;
});

test('Attribute with comment', function () {
    $attribute = new Attribute(
        name: 'licenseNumber',
        type: 'string(12)',
        comment: 'Must 12 characters'
    );

    expect($attribute->render(''))
        ->toBe('string(12) licenseNumber "Must 12 characters"')
    ;
});

test('Attribute with key', function () {
    $attribute = new Attribute(
       'licenseNumber',
       'string(12)',
        Key::UniqueKey
    );

    expect($attribute->render(''))
        ->toBe('string(12) licenseNumber UK')
    ;
});

test('Attribute with multiple keys', function () {
    $attribute = new Attribute(
        'licenseNumber',
        'string(12)',
        [Key::ForeignKey, Key::UniqueKey]
    );

    expect($attribute->render(''))
        ->toBe('string(12) licenseNumber FK,UK')
    ;
});

test('Attribute with everything', function () {
    $attribute = new Attribute(
        'licenseNumber',
        'string(12)',
        [Key::ForeignKey, Key::UniqueKey],
        'Must 12 characters'
    );

    expect($attribute->render(''))
        ->toBe('string(12) licenseNumber FK,UK "Must 12 characters"')
    ;
});
