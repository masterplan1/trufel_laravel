<?php

namespace App\Console\Commands;

use App\Http\Helpers\Image;
use Illuminate\Console\Command;

class ImageOptimize extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:image-optimize';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command image-optimize';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        Image::optimize();
    }
}
