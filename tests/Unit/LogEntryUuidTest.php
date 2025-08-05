<?php

namespace Tests\Unit;

use App\Models\LogEntry;
use App\Models\Token;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LogEntryUuidTest extends TestCase
{
    use RefreshDatabase;

    public function test_log_entry_uses_uuid_as_primary_key(): void
    {
        // Create a token first since LogEntry requires it
        $token = Token::factory()->create();
        
        // Create a LogEntry
        $logEntry = LogEntry::factory()->create([
            'token_id' => $token->id
        ]);

        // Assert that the ID is a UUID (36 characters with dashes)
        $this->assertMatchesRegularExpression(
            '/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/i',
            $logEntry->id
        );

        // Assert that the ID is a string, not an integer
        $this->assertIsString($logEntry->id);
    }

    public function test_log_entry_can_be_found_by_uuid(): void
    {
        // Create a token first since LogEntry requires it
        $token = Token::factory()->create();
        
        // Create a LogEntry
        $logEntry = LogEntry::factory()->create([
            'token_id' => $token->id
        ]);

        // Find the LogEntry by its UUID
        $foundLogEntry = LogEntry::find($logEntry->id);

        $this->assertNotNull($foundLogEntry);
        $this->assertEquals($logEntry->id, $foundLogEntry->id);
        $this->assertEquals($logEntry->title, $foundLogEntry->title);
    }
}
