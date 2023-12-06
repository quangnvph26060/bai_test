<?php

namespace App\Jobs;

use App\Models\Posts;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DeleteUnpaidDatTour implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //
        $currentTime = Carbon::now();
        $expirationTime = $currentTime->subMinutes(2);

        // Xóa các bản ghi chưa thanh toán và đã hết hạn
        $deletedpost = Posts::where('status', 0)
            ->where('created_at', '<=', $expirationTime)
            ->delete();
    }
}
