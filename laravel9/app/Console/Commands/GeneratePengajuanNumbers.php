<?php

namespace App\Console\Commands;

use App\Models\Pengajuanpembayaran;
use Illuminate\Console\Command;

class GeneratePengajuanNumbers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pengajuan:generate-document-numbers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate missing nomor_dokumen values for Pengajuanpembayaran records';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Starting to generate missing document numbers...');
        
        // Find records with missing document numbers
        $records = Pengajuanpembayaran::whereNull('nomor_dokumen')
            ->orWhere('nomor_dokumen', '')
            ->get();
            
        if ($records->isEmpty()) {
            $this->info('No records with missing document numbers found.');
            return 0;
        }
        
        $this->info("Found {$records->count()} records with missing document numbers.");
        
        // Group records by month and year to ensure correct numbering
        $recordsByMonth = $records->groupBy(function($record) {
            return date('m-Y', strtotime($record->tanggal));
        });
        
        $bar = $this->output->createProgressBar($records->count());
        $bar->start();
        
        $updatedCount = 0;
        
        foreach ($recordsByMonth as $monthYear => $monthRecords) {
            // Extract month and year
            list($month, $year) = explode('-', $monthYear);
            
            // For each month, get the count of existing document numbers
            $lastDocNum = Pengajuanpembayaran::whereRaw("DATE_FORMAT(tanggal, '%m-%Y') = ?", [$monthYear])
                ->whereNotNull('nomor_dokumen')
                ->where('nomor_dokumen', '!=', '')
                ->count();
            
            foreach ($monthRecords as $record) {
                $lastDocNum++;
                $idPadded = str_pad($lastDocNum, 2, '0', STR_PAD_LEFT);
                $bulan = Pengajuanpembayaran::convertToRoman($month);
                
                $newDocNumber = "{$idPadded}/MOI-FIN/{$bulan}/{$year}";
                $record->nomor_dokumen = $newDocNumber;
                $record->save();
                
                $updatedCount++;
                $bar->advance();
            }
        }
        
        $bar->finish();
        $this->newLine(2);
        $this->info("Successfully updated {$updatedCount} records with document numbers.");
        
        return 0; 
    }
}
