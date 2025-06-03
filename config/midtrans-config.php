<?php
require_once __DIR__ . '/../vendor/autoload.php'; // sesuaikan path ke autoload composer

use Midtrans\Config;

Config::$serverKey = 'SB-Mid-server-9Z2yjnUQcCAVEEq2x-N7ciOL';    // Ganti dengan server key Midtrans sandbox/production-mu
Config::$isProduction = false;                    // false = sandbox, true = production
Config::$isSanitized = true;
Config::$is3ds = true;
