<?php

namespace App\Enums;

enum OrderStatus: string
{
  case New = 'new';
  case Active = 'active';
  case Completed = 'completed';
}