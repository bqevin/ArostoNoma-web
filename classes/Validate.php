<?php

class Validate{
    private $_passed = false,
            $_errors = array(),
            $_db = null;

    // public function __construct(){
    //     $this->_db = Database::getInstance();
    // }

    public function check($source, $items = array()){
        foreach ($items as $item => $rules) {
            foreach ($rules as $rule => $rule_value) {
                // echo "{$item}  {$rule} must be {$rule_value} <br>";
                //Trimmed to avoid whitespace for length logics/validation
                $value = trim($source[$item]);
                // $item = escape($item);
                if ($rule ==='required' && empty($value)) {
                    //{$item} is equals to field name of value.***Change to call name  ref on arrays
                    $this->addError("{$item} is required!");
                } else if(!empty($value)){
                    switch ($rule) {
                        case 'min':
                            if (strlen($value) < $rule_value) {
                                $this->addError("{$item} must be a minimum of {$rule_value} characters");
                            }
                            break;
                        case 'max':
                            if (strlen($value) > $rule_value) {
                                $err = "{$item} must NOT exceed a maximum of {$rule_value} characters";
                                $this->addError($err);
                            }
                            break;
                            //Can check email or original value
                        case 'matches':
                        //$source[] is being used since we are checking again another rule_value not one in our current loop
                            if ($value != $source[$rule_value]) {
                                $this->addError("{$rule_value} Doesn't Match!");
                            }
                            break;
                        case 'unique':
                            $check = R::count('users','email=?', [$value]);
                            // $check = $this->_db->get($rule_value, array($item, '=', $value))->count();
                            
                            if ($check > 0) {
                                $error = "{$item} is being used. Find unique {$item}!";
                                $this->addError($error);
                                return false;
                            }
                            return true;
                            break;
                        default:
                            # code...
                            break;
                    }
                }
            }
        }
        if (empty($this->_errors)) {
            $this->_passed = true;
        }
        return $this;
    }

    //Errors Corner<Arrayed>
    public function addError($error){
        $this->_errors[] = $error;
    }
    //Tabulates and display all available errors
    public function errors(){
        return $this->_errors;
    }
    //Correspond with pass logic if 0 or 1
    public function passed(){
        return $this->_passed;
    }
}
