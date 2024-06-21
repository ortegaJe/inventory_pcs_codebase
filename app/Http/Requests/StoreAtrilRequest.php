<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAtrilRequest extends FormRequest
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
        return [
            'brand' => [
                'required',
                'numeric',
                //Rule::in([1, 2, 3, 6])
            ],
            'os' => [
                'required',
                'numeric',
            ],
            'model' => 'nullable|regex:/^[0-9a-zA-Z-()-, ]+$/i',
            'serial' => 'required|unique:devices,serial_number|regex:/^[0-9a-zA-Z-]+$/i',
            'monitor_serial' => 'nullable|regex:/^[0-9a-zA-Z-]+$/i',
            'activo_fijo' => 'nullable|regex:/^[0-9a-zA-Z-]+$/i',
            'ram0' => [
                'required',
                'numeric',
            ],
            'ram1' => [
                'required',
                'numeric',
            ],
            'hdd0' => [
                'required',
                'numeric',
            ],
            'hdd1' => [
                'required',
                'numeric',
            ],
            'processor' => [
                'required',
                'numeric',
            ],
            'statu' => [
                'required',
                'numeric',
            ],
            'ip' => 'nullable|ipv4',
            'mac' => 'nullable|max:17|regex:/^([0-9A-Fa-f]{2}[:-]){5}([0-9A-Fa-f]{2})$/',
            'domain_name' => 'required',
            'anydesk' => 'nullable|max:24|regex:/^[0-9a-zA-Z-@]+$/i',
            'device_name' => 'required|unique:devices,device_name|max:20|regex:/^[0-9a-zA-Z-]+$/i',
            'campu' => 'required|numeric',
            'location' => 'required|nullable|max:56|regex:/^[0-9a-zA-Z-ñÑóÓíÍ ]+$/i',
            'custodian_date' => 'required_with:custodian_name,filled|date',
            'custodian_name' => 'required_with:custodian_date,filled|regex:/^[0-9a-zA-Z-ñÑ-óÓ-íÍ ]+$/i',
            'statu_assignment' => 'required_with:custodian_name,filled|numeric',
            'observation' => 'nullable|max:255',
            'files' => 'required|array|size:2',
            'files.*' => 'required|image|mimes:jpeg,png,jpg|max:4096',
        ];
    }

    public function messages()
    {
        return [
            'brand.required' => 'Seccíon 1. EQUIPO - Seleccione un item en la lista de fabricantes',
            'brand.in' => 'Seccíon 1. EQUIPO - Seleccione una marca de computador valida en la lista',
            'model.regex' => 'Seccíon 1. EQUIPO - Símbolo(s) no permitido en el campo modelo',
            'os.required' => 'Seccíon 1. EQUIPO - Seleccione un item en la lista de sistemas operativos',
            'os.in' => 'Seccíon 1. EQUIPO - Seleccione un sistema operativo válido en la lista',
            'serial.required' => 'Seccíon 1. EQUIPO - Es requerido un número de serial',
            'serial.regex' => 'Seccíon 1. EQUIPO - Símbolo(s) no permitido en el campo número de serial',
            'serial.unique' => 'Seccíon 1. EQUIPO - Ya existe un equipo registrado con este número de serial',
            'activo_fijo.regex' => 'Seccíon 1. EQUIPO - Símbolo(s) no permitido en el campo de activo fijo',
            'activo_fijo.unique' => 'Seccíon 1. EQUIPO - Ya existe un equipo registrado con este número activo fijo',
            'monitor_serial.regex' => 'Símbolo(s) no permitido en el campo de número serial del monitor',
            'monitor_serial.unique' => 'Ya existe un monitor registrado con este número serial del monitor',
            'ram0.required' => 'Seccíon 2. HARDWARE - Seleccione un item en la lista de memoria ram ranura 1',
            'ram0.in' => 'Seccíon 2. HARDWARE - Seleccione una memoria ram valida en la lista',
            'ram1.required' => 'Seccíon 2. HARDWARE - Seleccione un item en la lista de memoria ram ranura 2',
            'ram1.in' => 'Seccíon 2. HARDWARE - Seleccione una memoria ram valida en la lista',
            'hdd0.required' => 'Seccíon 2. HARDWARE - Seleccione un item en la lista de primer almacenamiento',
            'hdd0.in' => 'Seccíon 2. HARDWARE - Seleccione un disco duro válido en la lista',
            'hdd1.required' => 'Seccíon 2. HARDWARE - Seleccione un item en la lista de segundo almacenamiento',
            'hdd1.in' => 'Seccíon 2. HARDWARE - Seleccione un disco duro válido en la lista',
            'processor.required' => 'Seccíon 2. HARDWARE - Seleccione un item en la lista de procesador',
            'processor.in' => 'Seccíon 2. HARDWARE - Seleccione un procesador válido en la lista',
            'statu.required' => 'Seccíon 2. HARDWARE - Seleccione un item en la lista estado del equipo',
            'statu.in' => 'Seccíon 2. HARDWARE - Seleccione un estado válido en la lista',
            'ip.required' => 'Seccíon 3. RED - Es requirida un dirección IP',
            'ip.ipv4' => 'Seccíon 3. RED - Direccion IP no valida',
            'ip.unique' => 'Seccíon 3. RED - Ya existe un equipo con esta IP registrado',
            'mac.required' => 'Seccíon 3. RED - Es requirida un dirección MAC',
            'mac.regex' => 'Seccíon 3. RED - Símbolo(s) no permitido en el campo dirección MAC',
            'mac.max' => 'Seccíon 3. RED - Direccion MAC no valida',
            'mac.unique' => 'Seccíon 3. RED - Ya existe un equipo con esta MAC registrado',
            'domain_name.required' => 'Seccíon 3. RED - Seleccionar un item en la lista de dominios',
            'anydesk.max' => 'Seccíon 3. RED - Solo se permite 24 caracteres para el campo anydesk',
            'anydesk.regex' => 'Seccíon 3. RED - Símbolo(s) no permitido en el campo anydesk',
            'anydesk.unique' => 'Seccíon 3. RED - Ya existe un equipo registrado con este anydesk',
            'device_name.required' => 'Seccíon 3. RED - Es requerido un nombre de equipo',
            'device_name.max' => 'Seccíon 3. RED - Solo se permite 20 caracteres para el campo nombre de equipo',
            'device_name.regex' => 'Seccíon 3. RED - Símbolo(s) no permitido en el campo nombre de equipo',
            'device_name.unique' => 'Seccíon 3. RED - Ya existe un equipo registrado con este nombre',
            'campu.required' => 'Seccíon 4. UBICACIÓN - Es requerido seleccionar la sede del equipo',
            'custodian_date.required_with' => 'Seccíon 4. UBICACIÓN - El campo fecha de asignación del custodio es obligatorio cuando el nombre del custodio está presente o llenado',
            'custodian_date.date' => 'Seccíon 4. UBICACIÓN - Este no es un formato de fecha permitido para el campo de fecha de asignación de custodio',
            'custodian_name.required_with'  => 'Seccíon 4. UBICACIÓN - El campo nombre del custodio es obligatorio cuando la fecha de asignación del custodio está presente o llenado',
            'custodian_name.regex' => 'Seccíon 4. UBICACIÓN - Símbolo(s) no permitido en el campo nombre del custodio',
            'statu_assignment.required_with' => 'Seccíon 4. UBICACIÓN - El campo concepto es obligatorio cuando el nombre del custodio está presente o llenado',
            'location.required' => 'Seccíon 4. UBICACIÓN - Es requerida la ubicación del equipo en sede',
            'location.regex' => 'Seccíon 4. UBICACIÓN - Símbolo(s) no permitido en el campo ubicación',
            'observation.max' => 'Seccíon 4. UBICACIÓN - Solo se permite 255 caracteres para el campo observación',
            'files.required' => 'Seccíon 4. UBICACIÓN - Es requerido subir dos fotos del atril para evidencia.',
            'files.size' => 'Seccíon 4. UBICACIÓN - Es requerido subir solo dos fotos como evidencia',
            'files.image' => 'Seccíon 4. UBICACIÓN - Solo se aceptan archivos tipo imagenes',
            'files.mimes' => 'Seccíon 4. UBICACIÓN - Solo se aceptan archivos tipo imagenes con extensiones jpeg,png,jpg',
            'files.max' => 'Seccíon 4. UBICACIÓN - Los archivos cargados no deben ser mayor a 8MB'
        ];
    }
}
