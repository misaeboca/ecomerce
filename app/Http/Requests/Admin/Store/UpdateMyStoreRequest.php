<?php

namespace App\Http\Requests\Admin\Store;

use App\Http\Requests\Admin\JsonFormRequest;

class UpdateMyStoreRequest extends JsonFormRequest
{
    protected $usc = '';
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'schedules' => [
                'sometimes',
                function ($attribute, $value, $fail)
                {
                    if(!isset($value['monday_opening']))
                    {
                        $fail('schedules.monday_opening');
                        return;
                    }

                    if(!isset($value['monday_closing']))
                    {
                        $fail('schedules.monday_closing');
                        return;
                    }

                    if(!isset($value['tuesday_opening']))
                    {
                        $fail('schedules.tuesday_opening');
                        return;
                    }

                    if(!isset($value['tuesday_closing']))
                    {
                        $fail('schedules.tuesday_closing');
                        return;
                    }

                    if(!isset($value['wednesday_opening']))
                    {
                        $fail('schedules.wednesday_opening');
                        return;
                    }

                    if(!isset($value['wednesday_closing']))
                    {
                        $fail('schedules.wednesday_closing');
                        return;
                    }

                    if(!isset($value['thursday_opening']))
                    {
                        $fail('schedules.thursday_opening');
                        return;
                    }

                    if(!isset($value['thursday_closing']))
                    {
                        $fail('schedules.thursday_closing');
                        return;
                    }

                    if(!isset($value['friday_opening']))
                    {
                        $fail('schedules.friday_opening');
                        return;
                    }

                    if(!isset($value['friday_closing']))
                    {
                        $fail('schedules.friday_closing');
                        return;
                    }

                    if(!isset($value['saturday_opening']))
                    {
                        $fail('schedules.saturday_opening');
                        return;
                    }

                    if(!isset($value['saturday_closing']))
                    {
                        $fail('schedules.saturday_closing');
                        return;
                    }
                    if(!isset($value['sunday_opening']))
                    {
                        $fail('schedules.sunday_opening');
                        return;
                    }

                    if(!isset($value['sunday_closing']))
                    {
                        $fail('schedules.sunday_closing');
                        return;
                    }

                }
            ]
        ];
    }
}
