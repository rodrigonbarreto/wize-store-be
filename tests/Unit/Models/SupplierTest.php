<?php

namespace Tests\Unit\Models;

use App\Models\Supplier;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SupplierTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_supplier()
    {
        $supplier = Supplier::factory()->create([
            'store_name' => 'Test Store',
            'type' => 'supplier',
        ]);

        $this->assertInstanceOf(Supplier::class, $supplier);
        $this->assertEquals('Test Store', $supplier->store_name);
        $this->assertEquals('supplier', $supplier->type);
    }
}
