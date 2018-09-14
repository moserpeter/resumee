<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ApplicationTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();
    
        $this->user = factory(\App\User::class)->create();
    }
    /** @test */
    public function AUserCanCreateAnApplication()
    {
        $this->be($this->user, 'api');
        $application = factory(\App\Application::class)->make();

        $response = $this->json('POST', route('applications.store'), $application->toArray());
        $response->assertSuccessful();
        $response->assertJsonFragment($application->toArray());

        $this->assertDatabaseHas('applications', $application->toArray());
    }

    /** @test */
    public function AUserCanViewAnApplication()
    {
        $this->be($this->user, 'api');

        $application = factory(\App\Application::class)->create(['user_id' => "{$this->user->id}"]);

        $response = $this->json('GET', route('applications.show', $application));
        $response->assertSuccessful();
        $response->assertJsonFragment($application->toArray());
    }

    /** @test */
    public function AUserCanUpdateAnApplication()
    {
        $this->be($this->user, 'api');

        $application = factory(\App\Application::class)->create(["user_id" => "{$this->user->id}"]);
        $data = factory(\App\Application::class)->make();

        $response = $this->json('PUT', route('applications.update', $application), $data->toArray());
        $response->assertSuccessful();
        $response->assertJsonFragment($data->toArray());

        $this->assertDatabaseHas('applications', $data->toArray());
        $this->assertDatabaseMissing('applications', $application->toArray());
    }

    /** @test */
    public function AUserCanDeleteAnApplication()
    {
        $this->be($this->user, 'api');

        $application = factory(\App\Application::class)->create(["user_id" => "{$this->user->id}"]);

        $response = $this->json('DELETE', route('applications.destroy', $application));
        $response->assertSuccessful();
        $this->assertDatabaseMissing('applications', $application->toArray());
    }

    /** */
    public function AApplicationCanBeSend()
    {
        $this->be($this->user, 'api');

        Mail::fake();

        $application = factory(\App\Application::class)->create(["user_id" => "{$this->user->id}"]);
        $response = $this->json('POST', route('applications.send', $application));
        $response->assertSuccessful();
        $response->assertJsonMissing(["send_at" => null]);

        \Mail::assertSent(\App\Mail\ApplicationMail::class, function ($mail) use ($application) {
            return $mail->hasTo($application);
        });
        
        \Mail::assertSent(\App\Mail\ApplicationMail::class, 1);
    }
}
