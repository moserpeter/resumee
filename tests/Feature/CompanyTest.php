<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CompanyTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();

        $this->user = $this->apiSignIn();
    }

    /** @test */
    public function AUserCanCreateACompany()
    {
        $company = factory(\App\Company::class)->make();

        $response = $this->json('POST', route('companies.store'), $company->toArray());
        $response->assertSuccessful()
                 ->assertJsonFragment($company->toArray());

        $this->assertDatabaseHas('companies', $company->toArray());
    }

    /** @test */
    public function AUserCanViewAllCompanies()
    {
        $companies = factory(\App\Company::class, 20)->create(['user_id' => "{$this->user->id}"]);

        $response = $this->json('GET', route('companies.index'));
        $response->assertSuccessful()
                 ->assertJson(["data" => $companies->toArray()]);
    }

    /** @test */
    public function AUserCanUpdateACompany()
    {
        $company = factory(\App\Company::class)->create(['user_id' => "{$this->user->id}"]);
        $newCompany = factory(\App\Company::class)->make();

        $respone = $this->json('PUT', route('companies.update', $company), $newCompany->toArray());
        $respone->assertSuccessful()
                ->assertJsonFragment($newCompany->toArray());

        $this->assertDatabaseHas('companies', $newCompany->toArray());
        $this->assertDatabaseMissing('companies', $company->toArray());
    }

    /** @test */
    public function AUserCanViewACompany()
    {
        $company = factory(\App\Company::class)->create(['user_id' => "1"]);

        $response = $this->json("GET", route('companies.show', $company));
        $response->assertSuccessful()
                 ->assertJsonFragment($company->toArray());
    }

    /** @test */
    public function AUserCanDeleteACompany()
    {
        $company = factory(\App\Company::class)->create(['user_id' => "{$this->user->id}"]);

        $response = $this->json('DELETE', route('companies.destroy', $company));
        $response->assertStatus(204);

        $this->assertDatabaseMissing('companies', $company->toArray());
    }
}
