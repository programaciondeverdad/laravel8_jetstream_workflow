<?php
/*
Clase ejemplo utilizada en clase para hacer refactorización.
Este es tu ayuda memoria para ver como realizar refactorizacion y aplicación de buenas prácticas.
*/
class PasoFake
{
	/**
     * isLastPasoFor a User
     * @return boolean
     */
    public function isLastPasoFor($roles)
    {
        $anyIsLastPaso = false;
        if (is_iterable($roles->get())) {
            foreach ($roles->get() as $role) {
            	$searchIsLastPaso = $this->searchIsLastPaso($role);
            	if ($searchIsLastPaso === true) {
                    $anyIsLastPaso = true;
                }
            }
        }
        else {
            $anyIsLastPaso = $this->searchIsLastPaso($roles);
        }


        return $anyIsLastPaso;
    }




    private function searchIsLastPaso($role){
    	return $this->TramiteTiposRolePasosService->isLastPasoFor($this->getTramiteTipo(), $role, $this->paso_numero);
    }
}
/*
1 == true ==> true
'1' == true ==> true
true == true ==> true

0 == false ==> true
'0' == false ==> true
false == false ==> true




1 === true ==> false
'1' === true ==> false
true === true ==> true

0 === false ==> false
'0' === false ==> false
false === false ==> true
*/