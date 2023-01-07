<?php
namespace App\Rules;
use Illuminate\Contracts\Validation\Rule;
use Squarebit\PTRules\Rules\CC;
use Squarebit\PTRules\Rules\NIF;
class PtCc implements Rule
{
    protected $alias = 'pt_cc';
    public function __toString()
    {
        return $this->alias;
    }
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $nif = new CC();
        return $nif->passes(null, $value);
    }
    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('O número do cartão do cidadão não é válido.');
    }
}
