# SlabPHP Controllers

This library houses the three main base SlabPHP Controllers employed by SlabPHP applications.

Yes, we know you may disagree with the abuse of protected methods in this architecture. Please see the main SlabPHP documentation for more information about SlabPHP, architecture concerns, or anything else.  

## Installation

Include this library

    composer require slabphp/controllers

## General Architecture of a Controller

Generally speaking a controller from this library will have three call sequences. The first is the input sequence, the second is the operations sequence, and the third is outputs. Functions get queued up in the appropriate sequences and then they all get called sequentially at once. This allows child classes to add more methods to the sequences. To accomplish this, you'll see a lot of protected methods. If this offends you, we apologize but SlabPHP is not for you. 

### Inputs

The input sequence is generally used for determing the values that will be used in the operations phase.

### Operations

This is usually where you will query for data based on inputs you determined in the input phase.

### Outputs

This is usually where you process data you queried in the operations phase into fields you can add to the $this->data member.

### Response

The response of a controller should be a class that adopts the \Slab\Components\Output\ControllerResponseInterface interface. The SlabPHP framework will then deal with it based on the logic of the display resolver that the controller prescribes.   
    
## Usage

Generally you should extend your controller class from \Slab\Controllers\Page for a web page, \Slab\Controllers\Feed for a JSON or XML feed, and \Slab\Controllers\POSTBack for a controller you will POST data to and then redirect to another one.

### \Slab\Controllers\Page

Extend your controller from here if you are making an HTML webpage or anything that will use the SlabPHP template display renderer.

For example,

    <?php
    namespace My\Site\Controllers\Homepage;
    
    class Homepage extends \Slab\Controllers\Page
    {
        protected $title = "Homepage!";
        
        protected $description = "Page Description!";
    }
    
By creating this class SlabPHP will automatically attempt to render the template ~\src\views\shell.php with ~\src\views\pages\homepage.php as the subTemplateName for the content area.

The Page controller accepts the following parameters from routes.

 * pageTitle - specifies the page's title
 * pageDescription - specifies the page's description
 * contentType - specifies the content-type header, defaults to text/html;charset=utf-8
 * displayResolver - specifies the slabphp display resolver class to use, defaults to \Slab\Display\Resolvers\Template
 * template - specifies the main shell template to use
 * subTemplate - specifies the sub template file to insert into the shell

It is possible to create pages completely from the routing parameters using the Page class as your controller.

### \Slab\Controllers\Feed

Extend your controller from here if you are making an XML or JSON feed. This controller will read the feedType parameter and if it's "json" or "xml" it will encode the output properly.

JSON feeds will also respond to the ?callback= query parameter and format the output as JSONP.

### \Slab\Controllers\POSTBack

Extend your controller from here if you are making an controller that gets data posted to it and needs to redirect back to another controller afterwards. Do your logic and set $this->redirectRoute and $this->redirectParameters to automatically query the router for the correct URL and redirect to it.

The POSTBack controller will manage session flash data for you based on the constants in the class.

### Whatever

SlabPHP mostly operates based on interfaces. Adopt the interfaces and make your own controllers if you want, we're not the police.

