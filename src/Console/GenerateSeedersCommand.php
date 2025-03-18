<?php

namespace Zainularfeen\SeederGenerator\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class GenerateSeedersCommand extends Command
{
    protected $signature = 'generate:seeders {--chunk=1000 : Rows per chunk} {--force : Overwrite existing seeders}';
    protected $description = 'Generate seeders with hardcoded data from existing database tables';

    public function handle()
    {
        ini_set('memory_limit', '-1');

        $chunkSize = (int) $this->option('chunk');
        $force = $this->option('force');
        $tables = DB::select('SHOW TABLES');
        $database = env('DB_DATABASE');
        $tableKey = "Tables_in_{$database}";

        $seederDir = database_path('seeders');
        if (!File::exists($seederDir)) {
            File::makeDirectory($seederDir, 0755, true);
            $this->info("Created seeders directory: {$seederDir}");
        }

        foreach ($tables as $table) {
            $tableName = $table->$tableKey;
            if (in_array($tableName, ['migrations', 'telescope_entries']))
                continue;

            $seederClass = Str::studly($tableName) . 'Seeder';
            $filePath = database_path("seeders/{$seederClass}.php");

            if (File::exists($filePath) && !$force)
                continue;

            $this->info("Processing table: {$tableName}");
            $totalRows = DB::table($tableName)->count();
            if ($totalRows == 0)
                continue;

            $bar = $this->output->createProgressBar($totalRows);
            $bar->start();

            $allData = [];
            foreach (DB::table($tableName)->cursor() as $row) {
                $allData[] = (array) $row;
                $bar->advance();
            }

            $content = "<?php\n\nnamespace Database\\Seeders;\n\nuse Illuminate\\Database\\Seeder;\nuse Illuminate\\Support\\Facades\\DB;\n\nclass {$seederClass} extends Seeder\n{\n    public function run()\n    {\n        DB::table('{$tableName}')->insert(" . var_export($allData, true) . ");\n    }\n}\n";

            try {
                File::put($filePath, $content);
                $bar->finish();
                $this->newLine();
                $this->info("Seeder created: {$seederClass} for {$totalRows} rows");
            } catch (\Exception $e) {
                $this->error("Failed to write seeder for {$tableName}: " . $e->getMessage());
            }
        }

        $this->info("Seeder generation completed!");
    }
}
