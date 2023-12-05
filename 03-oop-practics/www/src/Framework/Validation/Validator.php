<?php
declare(strict_types=1);

namespace Framework\Validation;


/**
 * Created by PhpStorm at 05.12.2023
 *
 * @Validator
 *
 * @author Jean-Claude <jeanyao@ymail.com>
 *
 * @package Framework\Validation
 */
class Validator
{
       /**
        * @var array
       */
       protected array $params = [];


       /**
        * @var array
       */
       protected array $errors = [];




       /**
        * @param array $params
       */
       public function __construct(array $params)
       {
           $this->params = $params;
       }




       /**
        * @param string ...$keys
        *
        * @return $this
       */
       public function required(string ...$keys): self
       {
           foreach ($keys as $key) {
               if (! array_key_exists($key, $this->params)) {
                   $this->addError($key, 'required');
               }
           }

           return $this;
       }



       /**
        * @param string $key
        *
        * @return $this
       */
       public function slug(string $key): self
       {
            $pattern = '/^([a-z0-9]+-?)+$/';

            if (! preg_match($pattern, $this->params[$key])) {
                $this->addError($key, 'slug');
            }

            return $this;
       }






       /**
        * @return ValidationError[]
       */
       public function getErrors(): array
       {
            return $this->errors;
       }




       /**
         * @param string $key
         * @param string $rule
         * @return $this
       */
       protected function addError(string $key, string $rule): self
       {
            $this->errors[$key] = new ValidationError($key, $rule);

            return $this;
       }
}