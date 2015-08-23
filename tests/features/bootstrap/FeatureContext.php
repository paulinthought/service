<?php

use Behat\Behat\Context\ClosuredContextInterface,
    Behat\Behat\Context\TranslatedContextInterface,
    Behat\Behat\Context\BehatContext,
    Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode,
    Behat\Gherkin\Node\TableNode;

//
// Require 3rd-party libraries here:
//
//   require_once 'PHPUnit/Autoload.php';
//   require_once 'PHPUnit/Framework/Assert/Functions.php';
//

/**
 * Features context.
 */
class FeatureContext extends BehatContext
{
    /**
     * Initializes context.
     * Every scenario gets it's own context object.
     *
     * @param array $parameters context parameters (set them up through behat.yml)
     */
    public function __construct(array $parameters)
    {
        // Initialize your context here
    }

//
// Place your definition and hook methods here:
//
//    /**
//     * @Given /^I have done something with "([^"]*)"$/
//     */
//    public function iHaveDoneSomethingWith($argument)
//    {
//        doSomethingWith($argument);
//    }
//
    /**
     * @Given /^I am on the homepage$/
     */
    public function iAmOnTheHomepage()
    {
        throw new PendingException();
    }

    /**
     * @Given /^I have the value autocomplete in the query$/
     */
    public function iHaveTheValueAutocompleteInTheQuery()
    {
        throw new PendingException();
    }

    /**
     * @Given /^I have the value find=ma\+in\+ber in the query$/
     */
    public function iHaveTheValueFindMaInBerInTheQuery()
    {
        throw new PendingException();
    }

    /**
     * @Then /^I should get:$/
     */
    public function iShouldGet(PyStringNode $string)
    {
        throw new PendingException();
    }
    
    
}
