<?php

namespace App\Console\Commands;

use App\Services\Currency\CurrencyImport;
use DateTime;
use Illuminate\Console\Command;

/**
 * Класс, описывающий консольное приложение для импорта курсов валют
 * Class ImportCurrenciesCommand
 *
 * @package App\Console\Commands
 */
class ImportCurrenciesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:currencies';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Executes currencies import';

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
        CurrencyImport::import((new DateTime())->format('d/m/Y'));
    }
}
