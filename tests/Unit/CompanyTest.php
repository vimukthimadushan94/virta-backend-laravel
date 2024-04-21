<?php

namespace Tests\Unit;

use App\Models\Company;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class CompanyTest extends TestCase
{
    use RefreshDatabase;

    /**
     * test cases for create company
     */
    public function test_can_create_company_with_valid_data(): void
    {
        $data = [
            'name' => 'Test Company',
            'parent_company_id' => null,
        ];
        $response = $this->postJson('/api/company',$data);
        $response->assertStatus(201);
    }

    public function test_create_company_without_required_fields(): void
    {
        $response = $this->postJson('/api/company', []);

        $response->assertStatus(422);
    }

    /**
     * test cases for update api
     */
    public function test_update_company_with_valid_data():void
    {
        $company = Company::factory()->create();

        $updateData = [
            'name' => 'Updated Company Name',
            'parent_company_id' => null,
        ];

        $response = $this->putJson('/api/company/' . $company->id, $updateData);

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure(['id', 'name', 'parent_company_id'])
            ->assertJson([
                'name' => $updateData['name'],
                'parent_company_id' => $updateData['parent_company_id'],
            ]);

        $this->assertDatabaseHas('companies', [
            'id' => $company->id,
            'name' => $updateData['name'],
            'parent_company_id' => $updateData['parent_company_id'],
        ]);
    }

    public function test_returns_422_validation_fails(): void
    {
        $response = $this->putJson('/api/company/9999', []);

        $response->assertStatus(422)
            ->assertJson([
                'success' => false,
                'message'=> "Validation errors",
            ]);;
    }

    public function test_delete_existing_company()
    {
        $company = Company::factory()->create();

        $response = $this->deleteJson('/api/company/' . $company->id);

        $response->assertStatus(200);
    }

    public function test_returns_404_if_company_not_found()
    {
        $response = $this->deleteJson('/api/company/9999');

        $response->assertStatus(404);
    }

}
