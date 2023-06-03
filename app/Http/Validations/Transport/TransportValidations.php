<?php
namespace App\Http\Validations\Transport;

use Validator;

class TransportValidations
{
    /**
     * Transport Validation
     */
    public static function validate($request, $id = 0)
    {
        $validator = Validator::make($request->all(), [
            'transport_type' => 'required',
            'distance' => 'required',
            'price' => 'required',
       ]);

       if ($validator->fails()) {
           return ([
               'success' => false,
               'errors' => $validator->errors()
           ]);
       }

       return ['success'=> 'true'];
    }
}
