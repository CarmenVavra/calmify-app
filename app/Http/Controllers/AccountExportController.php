<?php

namespace App\Http\Controllers;

use App\Actions\ExportAccountData;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AccountExportController extends Controller
{
    /**
     * Download everything stored about the account as JSON (Art. 15 and 20 GDPR).
     */
    public function __invoke(Request $request, ExportAccountData $export): JsonResponse
    {
        $data = $export->handle($request->user());
        $filename = 'calmify-daten-'.now()->format('Y-m-d').'.json';

        return response()->json($data, 200, [
            'Content-Disposition' => 'attachment; filename="'.$filename.'"',
            'Cache-Control' => 'no-store, private',
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }
}
