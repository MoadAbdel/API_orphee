<?php

namespace Tests\Unit;

use App\Models\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function test_uses_professional_email_returns_true_with_entreprise_address(): void
    {
        $user = new User;

        $this->assertTrue($user->usesProfessionalEmail('john@entreprise.com'));
    }

    public function test_uses_professional_email_returns_false_with_gmail_address(): void
    {
        $user = new User;

        $this->assertFalse($user->usesProfessionalEmail('john@gmail.com'));
    }
}
