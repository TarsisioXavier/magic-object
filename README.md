# Installation
composer require tarsisioxavier/magic-object

# Usage
MagicObject it's a abstract class, which means it cannot be instantiated. You'll need to create another class and extend from it.

~~~~PHP
<?php

use TarsisioXavier\MagicObject\MagicObject;

class ExampleClass extends MagicObject
{
  // Your code here...
}

$exampleObject = new ExampleClass();

var_dump($exampleObject);
~~~~

### Attributes

MagicObject contains a property which holds all the attributes of the class - *except the ones matching some class' property* - making them accessable like the property exists within the class.

You may notice an "original" property in your objects, that's just to hold the attributes passed to the class' contructor.

This is usefull when you're encapsulating data comming from APIs to log some stuff and debug when needed.
~~~~PHP
<?php

// This property doesn't exist.
$exampleObject->name = 'Dolores Abernathy';

// Will print: Dolores Abernathy.
print $exampleObject->name;

// You can also pass an array when creating the object defining the object's attributes.
$anotherExampleObject = new ExampleClass(['name' => 'Dolores Abernathy', 'email' => 'dolores.abernathy@hosts.ww']);

// Will print: Dolores Abernathy (dolores.abernathy@hosts.ww)
print $anotherExampleObject->name;
print ' ';
print '(' . $anotherExampleObject->email . ')';
~~~~

### Attributes Accessors

~~~~PHP
<?php

use TarsisioXavier\MagicObject\MagicObject;

class ExampleClass extends MagicObject
{
  public function getDocumentAttribute()
  {
    return $this->cpf ?? $this->cnpj;
  }
}

// CPF and CNPJ are types of civilian registers in Brazil.
// These were randomly generated in the website: https://www.4devs.com.br/gerador_de_pessoas
$exampleObject = new ExampleClass([
  'name' => 'Dolores Abernathy',
  'cnpj' => '38.789.452/0001-77',
]);

// The object don't have any CPF, so it'll print the CNPJ instead.
print_r($exampleObject->document);

~~~~

### Attributes Mutators (Work in progress...)

### Bootable Traits (Work in progress...)

# Testing
Run all the tests executing `composer test` or use phpunit `./vendor/bin/phpunit`.
