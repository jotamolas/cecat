<?php
namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;


/**
 * @Annotation
 */
class ValidateCredits extends Constraint{
    
    protected $cost;
    protected $balance;
    public $message  = 'No tiene los creditos suficientes para utilizar este Servicio';
    
    public function __construct($options) {        
        $this->cost = $options['cost'];
        $this->balance = $options['balance'];
    }

    public function validatedBy() {
        return 'validate.credits';
    }    
    
    public function getCost(){
        return $this->cost;
    }
    
    public function getBalance(){
        return $this->balance;
    }
    
}
