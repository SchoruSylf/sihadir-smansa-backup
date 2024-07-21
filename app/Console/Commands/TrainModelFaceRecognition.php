<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TrainModelFaceRecognition extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:train-model-face-recognition';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Replace with the path to your Python script
        $pythonScriptPath = base_path('D:\Kuliah\Berkas TA\Tugas Akhir\face-recognition\train_lbph_svm_model.py.py');

        // Execute the Python script
        $output = shell_exec('python ' . $pythonScriptPath);

        // Output the result
        $this->info($output);
    }
}
