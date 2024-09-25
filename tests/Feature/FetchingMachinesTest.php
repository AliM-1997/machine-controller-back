<?php

namespace Tests\Feature;

use Tests\TestCase;

class FetchingMachinesTest extends TestCase
{

    public function test_it_fetches_a_list_of_machine_inputs(): void
    {
        $response = $this->getJson('/api/v1/machine');

        $response->dump();

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'machineInputs' => [
                '*' => [
                    'id',
                    'name',
                    'serial_number',
                    'created_at',
                    'updated_at',
                ],
            ],
        ]);
    }
}
