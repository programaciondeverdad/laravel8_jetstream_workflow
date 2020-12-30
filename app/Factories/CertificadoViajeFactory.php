<?php
namespace App\Factories;

class CertificadoViajeFactory extends PasoAbstractFactory {
    
   // Usar método getPaso para obtener el objeto del tipo Paso
   public function getPaso(int $paso_numero){
      if(empty($paso_numero)){
         return null;
      }
      if($paso_numero == 1)
      {
         // return new Paso1();
      }
      elseif ($paso_numero == 2) {
         // return new Paso2();
      }
           
      return null;
   }
}