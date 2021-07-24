<?php

namespace Tests\Unit\Http\Controller\Admin;

use Mockery;
use Tests\TestCase;
use App\Models\Product;
use App\Models\Category;
use App\Http\Requests\ProductRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Database\Eloquent\Collection;
use App\Repositories\Product\IProductRepository;
use App\Http\Controllers\Admin\ProductController;
use App\Repositories\Category\ICategoryRepository;
use Mockery\Mock;
use Symfony\Component\HttpFoundation\ParameterBag;

class ProductControllerTest extends TestCase
{
    protected $productMock;
    protected $categoryMock;
    protected $product;

    public function setUp(): void
    {
        $this->productMock = Mockery::mock(IProductRepository::class);
        $this->categoryMock = Mockery::mock(ICategoryRepository::class);
        $this->product = Mockery::mock(Product::class);

        parent::setUp();
    }

    public function tearDown(): void
    {
        Mockery::close();

        parent::tearDown();
    }

    public function testItCanShowIndexWithDataProduct()
    {
        $this->productMock
            ->shouldReceive('all')
            ->once()
            ->andReturn(new Collection);

        $controller = new ProductController($this->productMock, $this->categoryMock);

        $result = $controller->index();

        $data = $result->getData();

        $this->assertEquals('admin.products.index', $result->getName());

        $this->assertArrayHasKey('products', $data);
    }

    public function testItCanShowCreatePageWithDataProduct()
    {
        $this->categoryMock
            ->shouldReceive('getAllChildCategory')
            ->once()
            ->andReturn(new Collection);

        $controller = new ProductController($this->productMock, $this->categoryMock);

        $result = $controller->create();

        $data = $result->getData();

        $this->assertEquals('admin.products.add', $result->getName());

        $this->assertArrayHasKey('categories', $data);
    }

    public function testItCanCreateNewProduct()
    {
        $this->productMock
            ->shouldReceive('create')
            ->once()
            ->andReturn(new Collection);

        $data = [
            'cate_id' => 1,
            'name' => 'abc',
            'price' => 132,
            'description' => 'abc',
        ];

        $request = new ProductRequest();
        $request->headers->set('content-type', 'application/json');
        $request->setJson(new ParameterBag($data));

        $controller = new ProductController($this->productMock, $this->categoryMock);

        $result = $controller->store($request);

        $this->assertInstanceOf(RedirectResponse::class, $result);

        $this->assertEquals(route('admin.products.index'), $result->headers->get('Location'));

        $this->assertEquals(trans('products.message_create_success'), $result->getSession()->get('message'));
    }

    public function testItCanShowEditPageWithDataProduct()
    {
        $this->categoryMock
            ->shouldReceive('getAllChildCategory')
            ->once()
            ->andReturn(new Collection);

        $controller = new ProductController($this->productMock, $this->categoryMock);

        $result = $controller->edit($this->product);

        $data = $result->getData();

        $this->assertEquals('admin.products.edit', $result->getName());

        $this->assertArrayHasKey('product', $data);
        $this->assertArrayHasKey('categories', $data);
    }

    public function testItCanUpdateProduct()
    {
        $data = [
            'cate_id' => 1,
            'name' => 'abc',
            'price' => 132,
            'description' => 'abc',
        ];

        $request = new ProductRequest();
        $request->headers->set('content-type', 'application/json');
        $request->setJson(new ParameterBag($data));

        $controller = new ProductController($this->productMock, $this->categoryMock);

        $result = $controller->update($request, $this->product);

        $this->assertInstanceOf(RedirectResponse::class, $result);

        $this->assertEquals(route('admin.products.index'), $result->headers->get('Location'));
    }
}
