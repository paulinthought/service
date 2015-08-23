<?php

namespace PlaceFinder\Tests\Places;

/**
 * Transformer for JSON
 *
 * @package Places/Tests
 * @author Paul Grattan
 */
class TransformTest extends \PHPUnit_Framework_TestCase
{
    
    public function getJsonTestData()
    {
        return array(
            array('{"json" : "good"}', true),
            array('{"json" : bad}', false)
        );
    }
    
    /**
     * 
     * @dataProvider getJsonTestData
     * @test
     */
    public function jsonToArrayTest($testJson, $expectedPass)
    {
        $array = \PlaceFinder\Places\Transform::jsonToArray($testJson);
         
        if (!$expectedPass) 
        {
            $this->assertEmpty($array);
        } else
        {
            $this->assertCount(1, $array);
        }
    }

}
