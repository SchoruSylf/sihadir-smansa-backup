<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DetectFace extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:detect-face';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'detect face with python script';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Replace with the path to your Python script
        $pythonScriptPath = base_path('app/python/detect_faces_lbph_svm.py');

        // Execute the Python script    
        $output = shell_exec('detect_face ' . $pythonScriptPath);

        // Output the result
        $this->info($output);
    }
}
