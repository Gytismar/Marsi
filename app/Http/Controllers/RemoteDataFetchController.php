<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RemoteDataFetchController extends Controller
{
    public function fetch(Request $request)
    {
        $request->validate([
            'url' => 'required|url',
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        try {
            $response = Http::post($request->input('url'), [
                'username' => $request->input('username'),
                'password' => $request->input('password'),
            ]);

            if ($response->failed()) {
                return response()->json([
                    'error' => 'Failed to fetch CSV',
                    'details' => $response->body(),
                ], $response->status());
            }

            return response($response->body(), 200)
                ->header('Content-Type', 'text/csv');

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Something went wrong',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
