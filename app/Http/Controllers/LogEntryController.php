<?php

namespace App\Http\Controllers;

use App\Http\Resources\LogEntryResource;
use App\Models\LogEntry;
use App\Models\Token;
use Illuminate\Http\Request;

class LogEntryController extends Controller {
    public function store(Request $request) {
        $request->validate([
            'title' => ['required', 'string'],
            'content' => ['required', 'string'],
            'level' => ['required'],
            'labels' => ['nullable', 'array'],
            'context' => ['nullable', 'array'],
            'created' => ['required', 'date'],
        ]);

        $level = strtolower($request->input('level'));

        if (!in_array($level, ['debug', 'info', 'notice', 'warning', 'error', 'critical', 'alert', 'emergency'])) {
            return response()->json(['error' => 'Invalid log level'], 400);
        }

        $data = [
            'token_id' => Token::where('token', $request->input('token'))->first()->id,
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'level' => $request->input('level'),
            'labels' => $request->input('labels'),
            'context' => $request->input('context'),
            'created_at' => $request->input('created'),
        ];

        return new LogEntryResource(LogEntry::create($data));
    }
}
