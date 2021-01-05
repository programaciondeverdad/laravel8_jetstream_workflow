<?php
namespace App\Factories;

class PasoFactoryProducer {
   public static function getFactory(int $tramite_tipo_id): PasoAbstractFactory{   
      if($tramite_tipo_id == 1){
         return new CertificadoAusenciaFactory();         
      }elseif ($tramite_tipo_id == 2) {
         return new CertificadoViajeFactory();
      }
      return null;
   }
}