<?php
/**
 * Created by PhpStorm.
 * User: juan
 * Date: 30/01/18
 * Time: 09:02 PM
 */

namespace App;


use Symfony\Component\HttpFoundation\Session\Session;

class Funciones
{

    /**
     * Construye los parametros requeridos para generar un mensaje
     * @param string $strTipo El tipo de mensaje a generar  se debe enviar en minuscula <br> error, informacion
     * @param string $strMensaje El mensaje que se mostrara
     * @param string $vista la vista donde se mostrara el mensaje
     */
    public function Mensaje($strTipo, $strMensaje)
    {
        $session = new Session();
        $session->getFlashBag()->add($strTipo, $strMensaje);
    }
}