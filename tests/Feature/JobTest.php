<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class JobTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();
    
        $this->user = $this->apiSignIn();
    }

    /** @test */
    public function AJobCanBeCreated()
    {
        $job = factory(\App\Job::class)->make();

        $response = $this->json('POST', route('jobs.store'), $job->toArray());
        $response->assertSuccessful()
                 ->assertJson(["data" => $job->toArray()]);

        $this->assertDatabaseHas('jobs', $job->toArray());
    }

    /** @test */
    public function AJobCanBeUpdated()
    {
        $job = factory(\App\Job::class)->create();
        $newJob = factory(\App\Job::class)->make();

        $response = $this->json('PUT', route('jobs.update', $job), $newJob->toArray());
        $response->assertSuccessful()
                 ->assertJson(["data" => $newJob->toArray()]);

        $this->assertDatabaseHas('jobs', $newJob->toArray());
        $this->assertDatabaseMissing('jobs', $job->toArray());
    }

    /** @test */
    public function AJobCanBeDeleted()
    {
        $job = factory(\App\Job::class)->create();

        $response = $this->json('DELETE', route('jobs.destroy', $job));
        $response->assertStatus(204);

        $this->assertDatabaseMissing('jobs', $job->toArray());
    }

    /** @test */
    public function AJobCanBeShown()
    {
        $job = factory(\App\Job::class)->create();

        $response = $this->json('GET', route('jobs.show', $job))        ;
        $response->assertOk()
                 ->assertJson(["data" => $job->toArray()]);
    }

    /** @test */
    public function AllJobsCanBeShown()
    {
        $jobs = factory(\App\Job::class, 10)->create();

        $response = $this->json('GET', route('jobs.index'));
        $response->assertSuccessful()
                 ->assertJson(["data" => $jobs->toArray()]);
    }
}
