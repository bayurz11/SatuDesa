<?php

namespace App\Http\Controllers\Admin;

use App\Exports\CitizensExport;
use App\Exports\CitizensImportTemplateExport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class CitizenExcelController extends Controller
{
    public function export()
    {
        return Excel::download(
            new CitizensExport(
                request('search'),
                request('status'),
                request('gender')
            ),
            'data-penduduk-' . now()->format('Ymd-His') . '.xlsx'
        );
    }

    public function template()
    {
        return Excel::download(
            new CitizensImportTemplateExport(),
            'template-import-penduduk.xlsx'
        );
    }
}
