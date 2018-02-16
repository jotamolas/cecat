<?php
namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * @Annotation
 */
class ValidateCreditsValidator extends ConstraintValidator{
    
    private $em;
    
    public function __construct(\Doctrine\ORM\EntityManager $em) {
        $this->em = $em;
    }
    
    public function validate($value, Constraint $constraint) {
           
           if($constraint->getCost() > $constraint->getBalance()){
                
                $this->context->buildViolation($constraint->message)
                ->setParameter('{{ string }}', $value)
                ->addViolation();
                
            }
    }
    
    
}
