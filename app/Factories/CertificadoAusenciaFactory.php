<?php
namespace App\Factories;

use App\Form\Tramites\CertificadoAusencia\Paso1;
use App\Form\Tramites\CertificadoAusencia\Paso2;
use App\Form\Tramites\CertificadoAusencia\Paso3;
use App\Form\Tramites\CertificadoAusencia\Paso4;

class CertificadoAusenciaFactory extends PasoAbstractFactory {
    
   // Usar método getPaso para obtener el objeto del tipo Paso
   public function getPaso(int $paso_numero){
      if(empty($paso_numero)){
         return null;
      }
      if($paso_numero == 1)
      {
         return new Paso1();
      }
      elseif ($paso_numero == 2) {
         return new Paso2();
      }
      elseif ($paso_numero == 3) {
         return new Paso3();
      }
      elseif ($paso_numero == 4) {
         return new Paso4();
      }
           
      return null;
   }
}