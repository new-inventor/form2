<?php
return [
    'templates' => [
        'default' => [
            'form' => '{result}{errors}{label}<div>{start}{children}{end}</div>{scripts}',
            'block' => '{label}<div>{children}</div>',
            'field' => /** @lang text */
                '<div><label {forField}>{title}</label>{field}</div>{errors}',
            'errors' => [
                'default' => '<span>{errorsStr}</span>',
                'form' => '<div>{errorsStr}</div>',
            ],
            'label' => [
                'default' => '<span>{title}</span>',
                'form' => '<div>{title}</div>',
            ],
            'result' => '<div class="{className}">{message}</div>',
            'checkSet' => '{label}<div>{options}</div>{errors}',
            'checkSetOption' => '<span><label>{optionTitle}{option}</label></span>',
            'repeatFiled' => /** @lang text */
                '<div {blockSelector}>{field}{actions}{errors}</div>',
            'repeatBlock' => /** @lang text */
                '<div {blockSelector}>{children}{actions}</div>',
            'repeatContainer' => /** @lang text */
                '<div {containerSelector}>{label}{children}</div>{repeatScript}',
            'repeatActionsBlock' => /** @lang text */
                '<div {actionsBlockSelector}="{name}">{deleteButton}{addButton}</div>',
            'deleteButton' => /** @lang text */
                '<span {deleteActionSelector}>-</span>',
            'addButton' => /** @lang text */
                '<span {addActionSelector}>+</span>',
            'attribute' => '{name}="{value}"',
            'shortAttribute' => '{name}'
        ],
    ],
    'repeat' => [
        'block' => 'data-repeat-block',
        'container' => 'data-repeat-container',
        'actionsBlock' => 'data-repeat-actions',
        'deleteAction' => 'data-delete',
        'addAction' => 'data-add',
    ],
    'errors' => [
        'delimiter' => '<br>',
    ],
    'alias' => [
        \NewInventor\Form\Form::getClass() => 'form',
        \NewInventor\Form\Block::getClass() => 'block',
        \NewInventor\Form\Field\AbstractField::getClass() => 'field',
    ]
];