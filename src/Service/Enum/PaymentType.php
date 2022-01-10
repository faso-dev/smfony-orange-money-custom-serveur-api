<?php

namespace App\Service\Enum;

enum PaymentType : string
{
  case FAKE = 'FAKE';
  case REAL = 'REAL';
}