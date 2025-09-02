<?php

namespace App\Hooks;

use App\Mail\Hook as HookMail;
use App\Models\Hook as HookModel;
use App\Models\LogEntry;
use Illuminate\Support\Facades\Mail as MailFacade;

class Mail extends Hook {

    public function run(LogEntry $logEntry, HookModel $hook): void {
        $config = $this->validateConfig($hook, [
            'email' => 'required|email',
        ]);

        if (empty($config)) {
            return;
        }

        MailFacade::to($config['email'])->send(new HookMail($hook, $logEntry));
    }
}
