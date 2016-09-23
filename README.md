# Processor
Mechanism to process a work from a request

## Installation

You can install Processor with Composer
```bash
$ composer require meuhmeuhconcept/processor
```

## How to use it ?
The main interest of this library is the `ChainProcessor`. It contains multiple processors
who can procced a particular work from a request and generate a response.

The `ChainProcessor` ask to each processors contains on it if it can proceed the job for a particular request.
The first processor who awser that it can do it will be use.
The response contains several things like the request itself, the status code, name of processor who do the job and obviously the output of the job.

### Build a __Request__
Before use the processor you have to build your request. You Request has to contain the object your demand.
This object will be use to determine if processor can do the job and to do it.

#### Example
```php
<?php

use Mmc\Processor\Request;

$object; // The object is the reason of your request.

$request = new Request($object);
```

#### Expected Output
You can specify the class (or interface) of the output that you expected. It can help to determine which processor will be able to do the job.
The object return in the response will necessary be an instance of this class (or implement the interface).
```php
<?php

use Mmc\Processor\Request;

$object; // The object is the reason of your request.

$request = new Request($object, 'Foo\Bar'); // The output object will be an Foo\Bar object
```

### Proceed the job
You just have to use a `Processor` to try to do the job. The best way is to use a `ChainProcessor` who contains several processors.
```php
<?php

$chainProcessor; // We considere that this processors is already init with several processors

$request; // We considere thath you already build the request

if ($chainProcessor->supports($request) { // Test if the processor can do the job
    $response = $chainProcessor->proccess($request); //Do the job
}
```

In fact you can directly tyr to do the job with a `ChainProcessor`.
If the job can't be done the processor return a response with the special status code `Mmc\Processor\ResponseStatusCode::NOT_IMPLEMENTED`.

### Use the __Response__
The fisrt thing that you have to do with a `Response` is to consult the status code to know how the job is done.
```php
<?php

use Mmc\Processor\ResponseStatusCode;

if ($response->getStatusCode() == ResponseStatusCode::OK) {
    // the job had been correctly done.
} else {
    $reasonPhrase = $response->getReasonPhrase();
    // The message who explain the cause of the status code
}
```

You can also know which `Processor` had done the job (when you use a `ChainProcessor`) with the next method :
```php
<?php

$response->getExtra('name');
```

Obviously you can get the initial `Request` (i.e. to get the input) with the method `$response->getRequest()`.

And the more important is to get the result of the job.
```php
<?php

$response->getOutput();
```

## Build your own __Processor__
This library is not ready to play because there is no `Processor` define in it.
You have to create them to do the job that you want.

To do it you just have to create a class who implements `Mmc\Processor\Processor` interface.
```php
<?php

use Mmc\Processor\Processor;
use Mmc\Processor\Request;
use Mmc\Processor\Response;
use Mmc\Processor\ResponseStatusCode;

class CustomProcessor implements Processor
{
    public function supports(Request $request)
    {
        // With the $request you have to decide if this processor can do the job
        // You can use the input to do this
        $input = $request->getInput();
        // Don't forget to check the 'expectedOuput', if this processor can't
        // produce that object you have to return false
        $expectedOuput = $request->getExpectedOutput();
    }

    public function process(Request $request)
    {
        // Advice : check the method 'supports'
        if (!$this->supports($request)) {
            return new Response($request, null, ResponseStatusCode::NOT_SUPPORTED);
        }

        // do the job
        
        // and return the Response

        return Resposne($request, $output); // $output had been create during the job was doing
    }
}
```

Now, you just have to add it on a `ChainProcessor`.
```php
<?php

$chainProcessor->add(new CustomProcessor());
```

## What now ?
The input of the `Request` if no constraint by a type hinting, so you can use really what you want to create your request.
The `ChainProcessor` can do what you want... if it contains `Processor` can do it.

