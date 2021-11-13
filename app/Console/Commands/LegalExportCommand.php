<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use DB;
use Exception;
use Illuminate\Support\Facades\Mail;
use App\Mail\LegalReport;
use App\Services\Exports\LegalTasksExport;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class LegalExportCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'legal:export';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'For export legal task report and automatic send email to user account.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try
        {
            $filepath = 'legal\legal_report'.Carbon::now()->timestamp.'.xlsx';
            (new LegalTasksExport)->store($filepath);
        }
        catch (Exception $ex){}
        finally
        {
            Mail::to("nattapol.krobklang@dhl.com")->send(new LegalReport($filepath));
        }
    }
}
