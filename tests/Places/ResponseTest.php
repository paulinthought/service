<?php

namespace PlaceFinder\Tests\Places;

/**
 * Transformer for JSON
 *
 * @package Places/Tests
 * @author Paul Grattan
 */
class ResponseTest extends \PHPUnit_Framework_TestCase
{
    
    public function getTestData()
    {
        return array(
            array('json', true),
            array('xml', true),
            array('html', false)
        );
    }
    
    /**
     * 
     * @dataProvider getTestData
     * @test
     */
    public function isValidResponseTypeTest($testResponseType, $expectedPass)
    {
        $response = new \PlaceFinder\Places\Response();
        $isValid = $response->isValidResponseType($testResponseType);
         
        $this->assertEquals($expectedPass, $isValid);
    }

    /**
     * 
     * @dataProvider getTestData
     * @test
     * @expectedException
     */    
    public function getResponseMimeTypeTest($testResponseType, $expectedPass)
    {
        
        if (!$expectedPass)
        {
            $this->setExpectedException('Exception');
        }
        
        $response = new \PlaceFinder\Places\Response($testResponseType);
        $mimeType = $response->getResponseMimeType();
        
        if ($testResponseType == 'json')
        {
            $this->assertEquals($mimeType, 'application/json');
        }
        if ($testResponseType == 'xml')
        {
            $this->assertEquals($mimeType, 'application/xml');
        }
        
    }
    
}
