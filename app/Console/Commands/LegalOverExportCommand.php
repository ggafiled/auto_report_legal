<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use DB;
use Exception;
use Illuminate\Support\Facades\Mail;
use App\Mail\LegalReport;
use App\Services\Exports\LegalTasksOverFiveYearExport;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class LegalOverExportCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'legal:over';

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

    function normalExport()
    {
        try
        {
            $filepath = 'legal_over_1_year_report'.Carbon::now()->timestamp.'.xlsx';
            (new LegalTasksOverFiveYearExport)->store('legal'."\\".$filepath);
        }
        catch (Exception $ex){
            echo $ex;
        }
        finally
        {
            Mail::to(explode(',', env('MAIL_LEGAL_TEAM')))->send(new LegalReport($filepath));
        }    
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->normalExport();
    }
}
