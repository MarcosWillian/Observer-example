<?php 

class Login implements SplSubject {
    
    /* constantes */
    const UNKNOWN_USER = 1;
    const INCORRECT_PWD = 2;
    const ALREADY_LOGGED_IN = 3;
    const ALLOW = 4;
 
    private $status = array(); 
    private $storage;
 
    function __construct() {

        /* 
        Standard PHP Library ou SPL é uma coleção de classes e interfaces que servem para resolver problemas padrões no mundo PHP, seu principal objetivo é prover interfaces que permita os desenvolvedores fazer um uso completo das vantagens da programação orientado a objetos. 
        Quando estamos implementando o Observer pattern, precisamos de duas interfaces, Subject que deve ser implementado pela classe que vai ser observado e Observer que deve ser implementado pela classe que vai observar. Não precisamos criar essas interfaces, pois a SPL já as trouxe com os nomes SPLSubject e SplObserver.
        A classe SplObjectStorage fornece um mapa de objetos para dados ou, ignorando dados, um conjunto de objetos. Para armazenar nossos observadores.
        */
       
        $this->storage = new SplObjectStorage(); 
    }
 

    function init( $username, $password, $ip ) {
 
        // Simulando status aleatórios para teste
        $this->setStatus( rand( 1, 4 ), $username, $ip);
 
        // Notifica todas as Observers da mudança de estado
        $this->notify();
        
        if( $this->status[0] == self::ALLOW ) {
            return true;
        }
 
        return false;
 
    }
 

    private function setStatus( $status, $username, $ip ) {
        $this->status = array( $status, $username, $ip );
    }
 
    function getStatus() {
        return $this->status;
    }
 
    function attach( SplObserver $observer ) {
        $this->storage->attach( $observer );
    }
 
    function detach( SplObserver $observer ) {
        $this->storage->detach( $observer );
    }
 
    function notify() {
        
        foreach ( $this->storage as $observer ) {
            $observer->update( $this );
        }
 
    }
 
}