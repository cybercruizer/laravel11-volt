<?php

namespace App\Http\Controllers;

use App\Models\Wilayah;
use Illuminate\Http\Request;

class WilayahController extends Controller
{
    // ... other methods remain the same ...

    public function getRegencies($provinceCode)
    {
        try {
            // Clean the province code to ensure correct format
            $provinceCode = str_pad($provinceCode, 2, '0', STR_PAD_LEFT);
            
            // Log the incoming request
            \Log::info('Getting regencies for province: ' . $provinceCode);
            
            // Simplify the query using the scope we already have
            $regencies = Wilayah::regencies()
                ->where('code', 'like', $provinceCode . '.%')
                ->orderBy('name')
                ->get(['code', 'name']);
            
            // Log the results
            \Log::info('Found ' . $regencies->count() . ' regencies');
            
            // Return plain JSON array for easier frontend processing
            return response()->json($regencies);
            
        } catch (\Exception $e) {
            \Log::error('Error getting regencies: ' . $e->getMessage());
            return response()->json([
                'error' => 'Failed to fetch regencies',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getDistricts($regencyCode)
    {
        try {
            // Clean the regency code
            $regencyCode = str_replace('.', '', $regencyCode);
            // Add a dot after the second character to format the regency code (XX.XX)
            $regencyCode = substr_replace($regencyCode, '.', 2, 0);
            
            $districts = Wilayah::districts()
                ->where('code', 'like', $regencyCode . '.%')
                ->orderBy('name')
                ->get(['code', 'name']);
                
            return response()->json($districts);
            
        } catch (\Exception $e) {
            \Log::error('Error getting districts: ' . $e->getMessage());
            return response()->json([
                'error' => 'Failed to fetch districts',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getVillages($districtCode)
    {
        try {
            // Clean the district code
            $districtCode = str_replace('.', '', $districtCode);
            
            // Format the code with proper dots (XX.XX.XX format)
            // For example: 110101 becomes 11.01.01
            $formattedCode = substr($districtCode, 0, 2) . '.' . 
                            substr($districtCode, 2, 2) . '.' .
                            substr($districtCode, 4, 2);
            
            // Log the formatted code for debugging
            \Log::info('Looking for villages with district code prefix: ' . $formattedCode);
            
            // Get villages where code starts with the district code (XX.XX.XX.)
            $villages = Wilayah::villages()
                ->where('code', 'like', $formattedCode . '.%')
                ->orderBy('name')
                ->get();

            // Log the results
            \Log::info('SQL Query: ' . Wilayah::villages()
                ->where('code', 'like', $formattedCode . '.%')
                ->toSql());
            \Log::info('Found ' . $villages->count() . ' villages');
            
            if ($villages->isEmpty()) {
                \Log::warning('No villages found for district: ' . $formattedCode);
            } else {
                \Log::info('First village code example: ' . $villages->first()->code);
            }

            return response()->json($villages);
            
        } catch (\Exception $e) {
            \Log::error('Error getting villages: ' . $e->getMessage());
            return response()->json([
                'error' => 'Failed to fetch villages',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}