<?php

namespace Tests\Feature\Media\Services;

use App\Domains\Media\Models\Link;
use App\Domains\Media\Services\LinkService;
use App\Exceptions\InvalidTypeException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LinkServiceTest extends TestCase {
    use RefreshDatabase;

    /** @test */
    public function link_types_test() {
        $linkService = new LinkService();
        $response = $linkService->linkTypes();
        $this->assertIsArray($response);
        $this->assertArrayHasKey(LinkService::TYPE_IMAGE, $response);
        $this->assertArrayHasKey(LinkService::TYPE_MOVIE, $response);
        $this->assertTrue($response[LinkService::TYPE_IMAGE] === LinkService::TYPE_IMAGE);
        $this->assertTrue($response[LinkService::TYPE_MOVIE] === LinkService::TYPE_MOVIE);
    }

    /** @test */
    public function set_link_type_test() {
        $linkService = new LinkService();
        try {
            $linkService->setLinkType(LinkService::TYPE_MOVIE);
            $this->fail();
        } catch (\Exception $exception) {
            $this->assertTrue($exception instanceof ModelNotFoundException);
        }
        $linkService->link = Link::factory()->create();
        try {
            $linkService->setLinkType(LinkService::TYPE_MOVIE);
            $this->assertTrue($linkService->link->type === LinkService::TYPE_MOVIE);
            $linkService->setLinkType(LinkService::TYPE_IMAGE);
            $this->assertTrue($linkService->link->type === LinkService::TYPE_IMAGE);
        } catch (\Exception $exception) {
            $this->fail();
        }
        try {
            $linkService->setLinkType('wrong type');
            $this->fail();
        } catch (\Exception $exception) {
            $this->assertTrue($exception instanceof InvalidTypeException);
        }
    }

    /** @test */
    public function set_link_data_test() {
        $linkService = new LinkService();
        try {
            $linkService->setLinkData('test address', '.jpg', '1024');
            $this->fail();
        } catch (\Exception $exception) {
            $this->assertTrue($exception instanceof ModelNotFoundException);
        }
        $linkService->link = Link::factory()->create();
        try {
            $linkService->setLinkData('test address', '.jpg', '1024');
            $this->assertTrue($linkService->link->address === 'test address');
            $this->assertTrue($linkService->link->extension === '.jpg');
            $this->assertTrue($linkService->link->quality === '1024');
        } catch (\Exception $exception) {
            $this->fail();
        }
    }

    /** @test */
    public function set_link_test() {
        $linkService = new LinkService();
        $this->assertTrue($linkService->link === null);
        try {
            $linkService->setLink(Link::factory()->create());
            $this->assertTrue($linkService->link instanceof Link);
        } catch (\Exception $exception) {
            $this->fail();
        }
    }

    /** @test */
    public function save_link_test() {
        $linkService = new LinkService();
        try {
            $linkService->saveLink();
            $this->fail();
        } catch (\Exception $exception) {
            $this->assertTrue($exception instanceof ModelNotFoundException);
        }
        $linkService->link = Link::factory()->create();
        try {
            $linkService->saveLink();
            $this->assertTrue(! empty($linkService->link->id));
        } catch (\Exception $exception) {
            $this->fail();
        }
    }

    /** @test */
    public function fetch_or_create_link() {
        $linkService = new LinkService();
        $link = $linkService->fetchOrCreateLink();
        $this->assertEmpty($link->id);
        $linkService->setLink($link);
        $linkService->saveLink();
        $link = $linkService->fetchOrCreateLink();
        $this->assertNotEmpty($link->id);
    }

    /** @test */
    public function remove_test() {
        $linkService = new LinkService();
        try {
            $linkService->remove(new Link());
            $this->fail();
        } catch (\Exception $exception) {
            $this->assertTrue($exception instanceof ModelNotFoundException);
        }
        $link = Link::factory()->create();
        try {
            $linkService->remove($link);
        } catch (\Exception $exception) {
            dd($exception->getMessage());
            $this->fail();
        }
    }

}
