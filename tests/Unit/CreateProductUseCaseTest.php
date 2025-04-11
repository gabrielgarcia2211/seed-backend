<?php

namespace Tests\Unit;

use Mockery;

use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;
use App\UseCases\Product\CreateProductUseCase;
use App\Interfaces\Product\ProductRepositoryInterface;

class CreateProductUseCaseTest extends TestCase
{
    #[Test]
    public function puede_crear_un_producto()
    {
        $repository = Mockery::mock(ProductRepositoryInterface::class);

        $data = [
            'nombre' => 'Zapatos',
            'precio' => 50000,
            'descripcion' => 'Zapatos de cuero',
            'activo' => true,
        ];

        $repository->shouldReceive('create')->once()->with($data)->andReturn((object) $data);

        $useCase = new CreateProductUseCase($repository);
        $producto = $useCase->execute($data);

        $this->assertEquals('Zapatos', $producto->nombre);
        $this->assertTrue($producto->activo);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}