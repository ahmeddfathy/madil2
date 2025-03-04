<?php

namespace App\Console\Commands;

use App\Models\Appointment;
use Illuminate\Console\Command;

class CleanupPendingAppointments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'appointments:cleanup-pending';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'حذف المواعيد المعلقة التي لم يتم إكمال طلباتها بعد ساعة';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $count = Appointment::cleanupPendingAppointments();

        $this->info("تم حذف {$count} من المواعيد المعلقة بنجاح");
        $this->line("سيتم تشغيل هذا الأمر تلقائياً كل ساعة");
    }
}
