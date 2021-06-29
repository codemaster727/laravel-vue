<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Nexmo\Laravel\Facade\Nexmo;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

/**
 * ショートメッセージ送信を行うジョブ
 */
class SendShortMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $phone;
    protected $message;

    /**
     * ジョブ生成のコンストラクタ
     *
     * @param [string] $phone
     * @param [string] $message
     */
    public function __construct($phone, $message)
    {
        $this->phone   = $phone;
        $this->message = $message;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $phoneJpn = ltrim($this->phone, "0");
        $phoneJpn = "81" . $phoneJpn;
        // メッセージを送信
        Nexmo::message()->send([
            'to' => $phoneJpn,
            'from' => config('const.system.name'),
            'text' => $this->message,
            'type' => 'unicode'
        ]);
    }
}
