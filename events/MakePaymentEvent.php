<?php
namespace komer45\partnership\events;

use yii\base\Event;

class MakePaymentEvent extends Event
{
    public $model;
}