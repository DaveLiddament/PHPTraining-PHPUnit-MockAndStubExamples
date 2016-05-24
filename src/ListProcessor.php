<?php

namespace Training\PHPUnit\Examples;


class ListProcessor
{

    /**
     * @var ItemProcessor
     */
    private $itemProcessor;


    /**
     * ListProcessor constructor.
     * @param ItemProcessor $itemProcessor
     */
    public function __construct(ItemProcessor $itemProcessor)
    {
        $this->itemProcessor = $itemProcessor;
    }


    /**
     * @param array $items
     */
    public function processList(array $items)
    {
        foreach($items as $item) {
            $this->itemProcessor->process($item);
        }
    }
    
    
}