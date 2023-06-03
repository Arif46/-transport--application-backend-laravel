<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transport;
use App\Http\Validations\Transport\TransportValidations;

class TransportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $transports = Transport::all();

        return response()->json([
                'success' => true,
                'message' => 'Data Found!',
                'data'  => $transports
            ]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validationResult = TransportValidations::validate($request);

        if (!$validationResult['success']) {
            return response($validationResult);
        }
        try {
            $requestAll = $request->all();
            $transport = Transport::create($requestAll);

        } catch (\Exception $ex) {
            return response([
                'success' => false,
                'message' => 'Failed to save data.',
                'errors'  => env('APP_ENV') !== 'production' ? $ex->getMessage() : []
            ]);
        }
        return response()->json([
            'success' => true,
            'message' => 'Data save successfully',
            'data'    => $transport
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $transport = Transport::find($id);

        if (!$transport) {
            return response()->json([
                'success' => false,
                'message' => 'Data not found.'
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Data found!',
            'data'    => $transport
        ]);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validationResult = TransportValidations:: validate($request, $id);

        if (!$validationResult['success']) {
            return response($validationResult);
        }

        $transport = Transport::find($id);

        try {
            $requestAll = $request->all();
            $transport->update($requestAll);

        } catch (\Exception $ex) {
            return response([
                'success' => false,
                'message' => 'Failed to save data.',
                'errors'  => env('APP_ENV') !== 'production' ? $ex->getMessage() : []
            ]);
        }
        return response()->json([
            'success' => true,
            'message' => 'Data Update successfully',
            'data'    => $transport
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    $transport = Transport::find($id);

        if (!$transport) {
            return response()->json([
                'success' => false,
                'message' => 'Data not found.'
            ]);
        }

        $transport->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data deleted successfully'
        ]);

    }

    /**
     * Calculate Price
     */
    public function calculatePrice(Request $request)
    {
        $transportType = $request->input('transport_type');
        $distance = $request->input('distance');
        $price = $this->calculateTransportPrice($transportType, $distance);

        return response()->json(['price' => $price]);
    }

    /**
     * Calculate Transport price
     */
    private function calculateTransportPrice($transportType, $distance)
    {
        // Hard code the cost based on transport type and distance
        if ($transportType === 'road') {
            return $distance * 0.1;
        } elseif ($transportType === 'sea') {
            return $distance * 0.2;
        } elseif ($transportType === 'air') {
            return $distance * 0.3;
        }
        return 0;
    }
}
