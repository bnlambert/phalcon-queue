<?php namespace BNLambert\Phalcon\Queue;

// include_once(__DIR__ . '/../vendor/autoload.php');

use Phalcon\Di\Injectable;
use Enqueue\Dbal\DbalConnectionFactory;
use Enqueue\Dbal\ManagerRegistryConnectionFactory;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
*  A Queue class
*
*  Implementation of  auth methods
*
*  @author BN Lambert
*/
class Queue  extends Injectable {

    public $test = 'hello queue';
    public $context = NULL;
    public $consumer = NULL;
    protected $factory = NULL;

    public function __construct()
    {

        if(!$this->factory) $this->factory = new DbalConnectionFactory('mysql://root:@localhost:3306/theresia_app');

        if(!$this->context) {
            $this->context = $this->factory->createContext();
            $this->context->createDataBaseTable();
        }


        $fooQueue = $this->context->createQueue('aQueue');
        $this->consumer = $this->context->createConsumer($fooQueue);
        $message = $this->context->createMessage('Hello world! 123123');

        $this->context->createProducer()->send($fooQueue, $message);
    }


    public function testCase()
    {
        //$fooQueue = $this->context->createQueue('aQueue');


        $message = $this->consumer->receive();

        // process a message
        print_r($message->getBody());

        $this->consumer->acknowledge($message);
        //$consumer->reject($message);
    }


}
