<?php

namespace PlaceFinder\Tests\Places;

/**
 * Transformer for JSON
 *
 * @package Places/Tests
 * @author Paul Grattan
 */
class MapsApiWrapperTest extends \PHPUnit_Framework_TestCase
{
    
    public function getTestData()
    {
        return array(
            array('{"status" : "ok"}', true),
            array('{"status" : "errors"}', false),
            array('{"errors" : "Bad Request"}', false)
        );
    }
    
    /**
     * 
     * @dataProvider getTestData
     * @test
     */
    public function validateJsonResponseDataTest($jsonString, $expectedPass)
    {
        $request = $this->getMock('Request', array('getFindQuery', 'getAutoComplete'));
        $request->expects($this->any())
                ->method('getFindQuery')
                ->will($this->returnValue('test Query'));
        $request->expects($this->any())
                ->method('getAutoComplete')
                ->will($this->returnValue(true));
        
        $response = new \PlaceFinder\Places\MapsApiWrapper($request);
        
        $reflector = new \ReflectionClass($response);
        
        $jsonProp = $reflector->getProperty('responseBody');
        $jsonProp->setAccessible(true);
        $jsonProp->setValue($response,  $jsonString);
        
        $validateJsonMethod = $reflector->getMethod('validateJsonResponseData');
        $validateJsonMethod->setAccessible(true);
                
        if (!$expectedPass)
        {
            $this->setExpectedException('Exception');
            $isValid = $validateJsonMethod->invoke($response);
        } else
        {
            $isValid = $validateJsonMethod->invoke($response);
            $this->assertEquals($expectedPass, $isValid);
        }
    }
    
    
}
