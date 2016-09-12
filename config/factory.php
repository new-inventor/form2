<?php
return [
    'base' => [
        stdClass::class => null
    ],
    'render' => [
        \NewInventor\Form\Renderer\FormRenderer::class => [['is_a|$$|"' . \NewInventor\Form\Interfaces\FormInterface::class . '"']],
        \NewInventor\Form\Renderer\FieldRenderer::class => [['is_a|$$|"' . \NewInventor\Form\Interfaces\FieldInterface::class . '"']],
        \NewInventor\Form\Renderer\BlockRenderer::class => [['is_a|$$|"' . \NewInventor\Form\Interfaces\BlockInterface::class . '"']],
        \NewInventor\Form\Renderer\AttributeRenderer::class => [['is_a|$$|"' . \NewInventor\Form\Abstraction\KeyValue::class . '"']],
    ],
    'validator' => [
        \NewInventor\Form\Validator\Validators\EmailValidator::class => 'email',
        \NewInventor\Form\Validator\Validators\IntegerValidator::getClass() => 'integer',
        \NewInventor\Form\Validator\Validators\StringValidator::getClass() => 'string',
        \NewInventor\Form\Validator\Validators\RequiredValidator::getClass() => 'required',
    ],
    'field' => [
        \NewInventor\Form\Field\Input::class => 'input',
        \NewInventor\Form\Field\CheckBox::class => 'checkBox',
        \NewInventor\Form\Field\CheckBoxSet::class => 'checkBoxSet',
        \NewInventor\Form\Field\RadioSet::class => 'radioSet',
        \NewInventor\Form\Field\Select::class => 'select',
        \NewInventor\Form\Field\TextArea::class => 'textArea',
    ]
];