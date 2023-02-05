<?php

namespace Tests\Feature\Media\Services\Factories;

use App\Domains\Media\Services\Factories\LinkFactory;
use App\Domains\Media\Services\LinkService;
use App\Exceptions\InvalidTypeException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LinkFactoryTest extends TestCase {

    use RefreshDatabase;

    /** @test */
    public function generate_test() {
        $linkFactory = new LinkFactory();
        try {
            $linkFactory->generate(
                'wrong type',
                'test address',
                '.jpg',
                '1024'
            );
            $this->fail();
        } catch (\Exception $exception) {
            $this->assertTrue($exception instanceof InvalidTypeException);
        }
        $link = $linkFactory->generate(
            LinkService::TYPE_IMAGE,
            'test address',
            '.jpg',
            '1024'
        );
        $this->assertNotEmpty($link->id);
    }
}
