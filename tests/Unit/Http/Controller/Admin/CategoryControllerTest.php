<?php

namespace Tests\Unit\Http\Controller\Admin;

use Mockery;
use Tests\TestCase;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\CategoryRequest;
use App\Http\Controllers\Admin\CategoryController;
use App\Repositories\Category\ICategoryRepository;
use Illuminate\Database\Eloquent\Collection;
use Symfony\Component\HttpFoundation\ParameterBag;

class CategoryControllerTest extends TestCase
{
    protected $categoryMock;
    protected $category;

    public function setUp(): void
    {
        $this->categoryMock = Mockery::mock(ICategoryRepository::class);
        $this->category = Mockery::mock(Category::class);

        parent::setUp();
    }

    public function tearDown(): void
    {
        Mockery::close();

        parent::tearDown();
    }

    public function testItCanShowIndexWithDataCategory()
    {
        $this->categoryMock
            ->shouldReceive('all')
            ->once()
            ->andReturn(new Collection);

        $controller = new CategoryController($this->categoryMock);

        $result = $controller->index();

        $data = $result->getData();

        $this->assertEquals('admin.categories.index', $result->getName());

        $this->assertArrayHasKey('categories', $data);
    }

    public function testItCanShowCreatePageWithDataCategory()
    {
        $this->categoryMock
            ->shouldReceive('getAllParentCategory')
            ->once()
            ->andReturn(new Collection);

        $controller = new CategoryController($this->categoryMock);

        $result = $controller->create();

        $data = $result->getData();

        $this->assertEquals('admin.categories.add', $result->getName());

        $this->assertArrayHasKey('categories', $data);
    }

    public function testItCanCreateNewCategory()
    {
        $this->categoryMock
            ->shouldReceive('create')
            ->once()
            ->andReturn(new Collection);

        $data = [
            'name' => 'test',
            'description' => 'test',
            'parent_id' => 15,
            'type' => 1,
        ];

        $request = new CategoryRequest();
        $request->headers->set('content-type', 'application/json');
        $request->setJson(new ParameterBag($data));

        $controller = new CategoryController($this->categoryMock);

        $result = $controller->store($request);

        $this->assertInstanceOf(RedirectResponse::class, $result);

        $this->assertEquals(route('admin.categories.index'), $result->headers->get('Location'));

        $this->assertEquals(trans('categories.message_create_success'), $result->getSession()->get('message'));
    }

    public function testItCanShowEditPageWithDataCategory()
    {
        $this->categoryMock
            ->shouldReceive('getAllParentCategory')
            ->once()
            ->andReturn(new Collection);

        $controller = new CategoryController($this->categoryMock);

        $result = $controller->edit($this->category);

        $data = $result->getData();

        $this->assertEquals('admin.categories.edit', $result->getName());

        $this->assertArrayHasKey('category', $data);
        $this->assertArrayHasKey('categories', $data);
    }

    public function testItCanUpdateCategory()
    {
        $data = [
            'name' => 'test',
            'description' => 'test',
            'parent_id' => 15,
            'type' => 1,
        ];

        $request = new CategoryRequest();
        $request->headers->set('content-type', 'application/json');
        $request->setJson(new ParameterBag($data));

        $controller = new CategoryController($this->categoryMock);

        $result = $controller->update($request, $this->category);

        $this->assertInstanceOf(RedirectResponse::class, $result);

        $this->assertEquals(route('admin.categories.index'), $result->headers->get('Location'));
    }
}
