<h2>New Log Entry</h2>

<p><strong>Title:</strong> {{ $logEntry->title }}</p>
<p><strong>Level:</strong> {{ $logEntry->level }}</p>
<p><strong>Labels:</strong> {{ is_array($logEntry->labels) ? implode(', ', $logEntry->labels) : $logEntry->labels }}</p>
<p><strong>Created at:</strong> {{ $logEntry->created_at?->format('Y-m-d H:i:s') }}</p>

@if(!empty($logEntry->content))
    <p><strong>Content:</strong></p>
    <pre style="background:#f5f5f5;padding:10px;">{{ formatJsonIfPossible($logEntry->content) }}</pre>
@endif

@if(!empty($logEntry->context))
    <p><strong>Context:</strong></p>
    <pre style="background:#f5f5f5;padding:10px;">{{ json_encode($logEntry->context, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
@endif
