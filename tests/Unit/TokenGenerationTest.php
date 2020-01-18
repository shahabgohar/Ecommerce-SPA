<?php

namespace Tests\Unit;

use App\Models\User;
use App\Token\Token;
use PHPUnit\Framework\TestCase;

class TokenGenerationTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
   public function test_to_check_whether_a_token_is_generated_for_user()
   {

       $this->assertNull(Token::GenerateToken(['shahab',1]),"no token is generated ");
   }

}
