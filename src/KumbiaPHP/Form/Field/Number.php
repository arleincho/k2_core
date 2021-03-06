<?php

namespace KumbiaPHP\Form\Field;

use KumbiaPHP\Form\Field\Text;

/**
 * Description of FormFieldText
 *
 * @author manuel
 */
class Number extends Text
{

    public function __construct($fieldName)
    {
        parent::__construct($fieldName);
        $this->setType('number');
    }

    /**
     * Valida que el numero este comprendido entre un minimo y un maximo establecido.
     * 
     * @param int $min
     * @param max $max
     * @param string $message
     * @return NumberField 
     */
    public function range($min, $max = NULL, $message = 'El campo %s debe ser un numero entre %s y %s')
    {
        $this->validationBuilder->range($this->getFieldName(), array(
            'message' => sprintf($message, $this->getFieldName(), $min, $max),
            'min' => $min,
            'max' => $max,
        ));
        return $this->attrs(array(
                    'min' => $min,
                    'max' => $max,
                ));
    }

}