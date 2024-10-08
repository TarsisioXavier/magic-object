# Installation 🔌

Installation from composer.

```
composer require tarsisioxavier/magic-object
```

# Usage ⛏️
DataModel it's a abstract class, which means it cannot be instantiated. You'll need to create another class and extend from it.

```PHP
<?php

require('vendor/autoload.php');

use MagicObject\DataModel;

class ExampleClass extends DataModel
{
    // Your code here...
}

$exampleObject = new ExampleClass();

var_dump($exampleObject);
```

### Attributes

DataModel contains a property which holds all the attributes of the class - *except the ones matching some class' property* - making them accessable like the property exists within the class.

You may notice an "original" property in your objects, that's just to hold the attributes passed to the class' contructor.

This is usefull when you're encapsulating data comming from APIs to log some stuff and debug when needed.
```PHP
<?php

require('vendor/autoload.php');

use MagicObject\DataModel;

class ExampleClass extends DataModel
{
    // Your code here...
}

$exampleObject = new ExampleClass();

// This property doesn't exist.
$exampleObject->name = 'Dolores Abernathy';

// Will print: Dolores Abernathy.
print $exampleObject->name . "\n";

// You can also pass an array when creating the object defining the object's attributes.
$anotherExampleObject = new ExampleClass([
    'name' => 'Dolores Abernathy',
    'email' => 'dolores.abernathy@hosts.ww'
]);

// Will print: Dolores Abernathy (dolores.abernathy@hosts.ww)
print $anotherExampleObject->name;
print ' ';
print '(' . $anotherExampleObject->email . ")\n";
```

### Attributes Accessors

If you need to modify the way you access the object's attribute, you can write an accessor in the object extending the DataModel.

The example below creates a object with name and CNPJ. The accessor in the ExampleClass will try to return the CPF of the object, since it doesn't exists a CNPJ will be returned.

```PHP
<?php

require('vendor/autoload.php');

use MagicObject\DataModel;

class ExampleClass extends DataModel
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
print $exampleObject->document . "\n";
```

### Attributes Mutators

When you want to modify the data before filling your object, there is a option to write a mutator to this specific(s) attribute(s).

The example below will receive a DateTime object and will transform it into a simple string carring only the year, month, day, the hour and the minutes from the value (parameter) informed.

```PHP
<?php

require('vendor/autoload.php');

use MagicObject\DataModel;

class ExampleClass extends DataModel
{
    public function setDateAttribute($value)
    {
        $this->attributes['date'] = $value->format('Y-m-d H:i');
    }
}

$datetime = new \DateTime('now');

$object = new ExampleClass(['date' => $datetime]);

// Will print only the the year-month-day hour:minute.
print $object->date . "\n";

$anotherObject = new ExampleClass();
$anotherObject->date = $datetime;

// Same output.
print $object->date . "\n";
```

### Bootable Traits  
You can run any code when your class extending from `DataModel` is instantiated. Look the example below:  
```php
<?php

require('vendor/autoload.php');

use MagicObject\DataModel;

trait SimpleTrait
{
    public string $helloWorld;

    public function bootSimpleTrait()
    {
        $this->helloWorld = 'ZA WARUDO!';
    }
}

class ExampleClass extends DataModel
{
    use SimpleTrait;
}

$object = new ExampleClass();

echo $object->helloWorld . "\n";

// Output:
// ZA WARUDO!
```
Notice that the method must match with the trait's name.  
This is completly optional, if the method for booting it's not implemented the `DataModel` class will just ignore it.  

# Testing 🧪
Run all the tests executing `composer test`, if you want a specific test to run, try: `composer test -- --filter <the_test_you_want>`.  

Composer's script 'test' uses the [Pest PHP](https://pestphp.com).  

You can also check the code coverage by using the command `composer coverage`, this will create a HTML file inside `./.coverage` directory.  

There is also a code quality assurance by PHPStan, run `composer phpstan` whenever you want to check that.  

And last but not least, you can use the Pest Mutation feature by running `composer test -- --mutate --parallel`.  
