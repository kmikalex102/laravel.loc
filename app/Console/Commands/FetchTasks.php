<?php

namespace App\Console\Commands;

use App\Models\FailedTask;
use App\Models\Task;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class FetchTasks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fetch-tasks';

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
        try {
            $response = Http::get('https://jsonplaceholder.typicode.com/todos/1');
        } catch (\Exception $e) {
            $this->error('An error occurred: ' . $e->getMessage());
            return 1;
        }
        if (!$response->successful()) {
            $this->error('API request failed');
            return 1;
        }
        $data = $response->json();
        if (is_array($data) && !empty($data['title'])) {
            Task::create(['title' => $data['title']]);
            $this->info('External data saved successfully');
            return 0;
        } else {
            FailedTask::create([
                'error_message' => 'Invalid API response: ' . json_encode($data)
            ]);
            $this->error('Invalid API response');
            return 1;
        }
    }
}
