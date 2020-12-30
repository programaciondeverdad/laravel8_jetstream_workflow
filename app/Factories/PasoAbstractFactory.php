<?php
namespace App\Factories;


abstract class PasoAbstractFactory {
   abstract function getPaso(int $paso_numero);
}