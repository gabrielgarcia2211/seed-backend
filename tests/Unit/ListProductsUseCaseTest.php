<?php

namespace Tests\Unit;

use Mockery;
use Tests\TestCase;
use App\Models\Product\Product;
use PHPUnit\Framework\Attributes\Test;
use App\UseCases\Product\ListProductsUseCase;
use App\Interfaces\Product\ProductRepositoryInterface;

class ListProductsUseCaseTest extends TestCase
{
    #[Test]
    public function puede_listar_productos()
    {
        $repository = Mockery::mock(ProductRepositoryInterface::class);

        $productos = collect([
            (object)[ 'id' => 1, 'nombre' => 'Producto A' ],
            (object)[ 'id' => 2, 'nombre' => 'Producto B' ],
        ]);

        $repository->shouldReceive('all')->once()->andReturn($productos);

        $useCase = new ListProductsUseCase($repository);
        $result = $useCase->execute();

        $this->assertCount(2, $result);
        $this->assertEquals('Producto A', $result[0]->nombre);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
