<?php

declare(strict_types=1);

namespace App\Features\Token\Tests\Middlewares;

use App\Features\Token\Middlewares\ValidateUserToken;
use App\Features\Token\Models\Token;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ValidateUserTokenTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_allows_request_with_valid_token(): void
    {
        $user = User::factory()->create();
        $token = Token::factory()->create(['user_id' => $user->id]);

        $request = Request::create('/test', 'GET');
        $request->headers->set('Authorization', 'Bearer '.$token->token);

        $middleware = new ValidateUserToken;
        $nextCalled = false;

        $response = $middleware->handle($request, function ($req) use (&$nextCalled) {
            $nextCalled = true;

            return new Response('Success');
        });

        $this->assertTrue($nextCalled);
        $this->assertEquals('Success', $response->getContent());
    }

    #[Test]
    public function it_rejects_request_without_token(): void
    {
        $request = Request::create('/test', 'GET');

        $middleware = new ValidateUserToken;
        $nextCalled = false;

        $response = $middleware->handle($request, function ($req) use (&$nextCalled) {
            $nextCalled = true;

            return new Response('Should not reach here');
        });

        $this->assertFalse($nextCalled);
        $this->assertEquals(401, $response->getStatusCode());

        $data = json_decode($response->getContent(), true);
        $this->assertEquals('No token provided', $data['error']);
    }

    #[Test]
    public function it_rejects_request_with_invalid_token(): void
    {
        $request = Request::create('/test', 'GET');
        $request->headers->set('Authorization', 'Bearer invalid-token-xyz');

        $middleware = new ValidateUserToken;
        $nextCalled = false;

        $response = $middleware->handle($request, function ($req) use (&$nextCalled) {
            $nextCalled = true;

            return new Response('Should not reach here');
        });

        $this->assertFalse($nextCalled);
        $this->assertEquals(401, $response->getStatusCode());

        $data = json_decode($response->getContent(), true);
        $this->assertEquals('Invalid token', $data['error']);
    }

    #[Test]
    public function it_rejects_request_with_non_existent_token(): void
    {
        $request = Request::create('/test', 'GET');
        $request->headers->set('Authorization', 'Bearer '.str_repeat('a', 50));

        $middleware = new ValidateUserToken;

        $response = $middleware->handle($request, function ($req) {
            return new Response('Should not reach here');
        });

        $this->assertEquals(401, $response->getStatusCode());

        $data = json_decode($response->getContent(), true);
        $this->assertEquals('Invalid token', $data['error']);
    }

    #[Test]
    public function it_properly_extracts_bearer_token_from_authorization_header(): void
    {
        $user = User::factory()->create();
        $token = Token::factory()->create(['user_id' => $user->id]);

        $request = Request::create('/test', 'GET');
        $request->headers->set('Authorization', 'Bearer '.$token->token);

        $middleware = new ValidateUserToken;
        $passedRequest = null;

        $middleware->handle($request, function ($req) use (&$passedRequest) {
            $passedRequest = $req;

            return new Response('Success');
        });

        $this->assertNotNull($passedRequest);
        $this->assertEquals($token->token, $passedRequest->bearerToken());
    }
}
