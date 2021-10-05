<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateFormRequest extends FormRequest
{
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
        $device = $this->route('user.inventory.desktop.edit');
        return [
            'serial-pc' => ['required', 'regex:/^[0-9a-zA-Z-]+$/i','unique:devices,serial_number,'.$this->route('user.inventory.desktop.edit')->id],
            //['activo-fijo-pc' => ['nullable', 'max:15', 'regex:/^[0-9a-zA-Z-]+$/i','unique:devices,inventory_active_code,' . $device]],
            //['serial-monitor-pc' => ['nullable', 'regex:/^[0-9a-zA-Z-]+$/i','unique:devices,monitor_serial_number,' . $device]],
            'ip' => ['nullable','ipv4','unique:devices,ip,'.$device->id],
            'mac' => ['nullable','max:17', 'regex:/^([0-9A-Fa-f]{2}[:-]){5}([0-9A-Fa-f]{2})$/', 'unique:devices,mac,'.$device->id],
            //['anydesk' => ['nullable', 'max:24', 'regex:/^[0-9a-zA-Z- @]+$/i', 'unique:devices,anydesk,' . $device->id],
            'pc-name' => ['required','max:20', 'regex:/^[0-9a-zA-Z-]+$/i', 'unique:devices,device_name,'.$device->id],
            'marca-pc-select2' => 'not_in:0',
            'marca-pc-select2' => [
                'required',
                'numeric',
                Rule::in([1, 2, 3, 6])
            ],
            'modelo-pc' => 'nullable|max:100|regex:/^[0-9a-zA-Z- ()]+$/i',
            'os-pc-select2' => [
                'required',
                'numeric',
                Rule::in([1, 2, 3, 4, 5, 6])
            ],
            'val-select2-ram0' => [
                'required',
                'numeric',
                //Rule::in([1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19])
            ],
            'val-select2-ram1' => [
                'numeric',
                //Rule::in([1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19])
            ],
            'val-select2-first-storage' => [
                'required',
                'numeric',
                //Rule::in([1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 30])
            ],
            'val-select2-second-storage' => [
                'numeric',
                //Rule::in([1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 30])
            ],
            'val-select2-status' => [
                'required',
                'numeric',
                Rule::in([1, 2, 3, 5, 6, 7, 8])
            ],
            'pc-domain-name' => 'required|max:20|regex:/^[0-9a-zA-Z-.]+$/i',
            //'pc-name' => 'required|max:20|regex:/^[0-9a-zA-Z-]+$/i',
            'location' => 'nullable|max:56|regex:/^[0-9a-zA-Z- ]+$/i',
            'custodian-assignment-date' => 'required_with:custodian-name,filled|max:10|date',
            'custodian-name' => 'required_with:custodian-assignment-date,filled|max:56|regex:/^[0-9a-zA-Z- .]+$/i',
            'observation' => 'nullable|max:255',

        ];
    }
}
