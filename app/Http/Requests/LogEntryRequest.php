<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LogEntryRequest extends FormRequest {
    public function rules(): array {
        return [
            'token' => ['required'],
            'title' => ['required'],
            'content' => ['required'],
            'level' => ['required|in:debug,info,notice,warning,error,critical,alert,emergency'],
            'labels' => ['nullable'],
            'context' => ['nullable'],
        ];
    }

    public function authorize(): bool {
        return true;
    }
}
