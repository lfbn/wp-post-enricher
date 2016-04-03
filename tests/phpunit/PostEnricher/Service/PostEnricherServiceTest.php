<?php

namespace PostEnricher\Service;

class PostEnricherServiceTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var PostEnricherService
     */
    protected $postEnricherService;

    public function setUp()
    {
        $this->postEnricherService = new PostEnricherService(
            PostEnricherService::SEARCH_TYPE_GOOGLE_SEARCH
        );
    }

    /**
     * @dataProvider getHandleStringDataProvider
     *
     * @TODO This is not working. Test the public method instead!
     */
    public function testHandleString($input, $outcome)
    {
        $postEnricherServiceRef = new \ReflectionClass($this->postEnricherService);
        $method = $postEnricherServiceRef->getMethod('handleString');
        $method->setAccessible(true);
        $output = $method->invoke($postEnricherServiceRef, $input);
        $this->assertEquals(
            $output,
            $outcome
        );
    }

    public function getHandleStringDataProvider()
    {
        return array(
            array(
                'Hilary Clinton rather than Donald Trump...',
                'hilary clinton donald trump'
            ),
            array(
                'Tesla set to open a store in Brooklyn Friday',
                'tesla open store brooklyn friday'
            ),
            array(
                'Here\'s the only guide you need to being a millennial!',
                'guide you need being millennial'
            )
        );
    }
}
