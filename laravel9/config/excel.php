<?php

use Maatwebsite\Excel\Excel as MaatwebsiteExcel;

return [
    'exports' => [
        'heading' => 'slugged',
        'csv' => [
            'delimiter' => ',',
            'enclosure' => '"',
            'line_ending' => "\n",
            'use_bom' => false,
            'include_separator_line' => false,
            'excel_compatibility' => false,
        ],
    ],

    'imports' => [
        'heading' => 'slugged',
        'csv' => [
            'delimiter' => ',',
            'enclosure' => '"',
            'line_ending' => "\n",
            'use_bom' => false,
            'include_separator_line' => false,
            'excel_compatibility' => false,
        ],
    ],

    'temporary_files' => [
        'local_path' => storage_path('app/public/excel-imports'),
        'remote_disk' => null,
    ],

    'chunk_size' => 1000,

    'transactions' => [
        'enabled' => true,
    ],

    'model' => [
        'import' => [
            'class' => MaatwebsiteExcel::class,
        ],
    ],
];