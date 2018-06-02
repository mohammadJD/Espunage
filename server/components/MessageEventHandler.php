<?php
namespace app\components;

use Sse\Events\TimedEvent;

class MessageEventHandler extends TimedEvent
{
    public $period = 5; // the interval in seconds

    private $stocks = [['symbol' => 'MSFT', 'price' => 30.00, 'change' => 0], ['symbol' => 'APPL', 'price' => 30.00, 'change' => 0], ['symbol' => 'GOOG', 'price' => 30.00, 'change' => 0]];

    public function check()
    {
        return true;
    }

    public function update()
    {
        foreach ($this->stocks as $stockKey => $stock) {
            $currentPrice = $stock['price'];
            $changedPercentage = rand(-5, 5);
            $newPrice = $currentPrice + ($currentPrice * ($changedPercentage / 100));

            $this->stocks[$stockKey]['price'] = $newPrice;
            $this->stocks[$stockKey]['change'] = $newPrice - $currentPrice;

        }
        return json_encode($this->stocks);
    }
}