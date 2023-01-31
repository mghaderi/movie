<?php

namespace App\Domains\Media\Services;

use App\Domains\Media\Models\Link;
use App\Exceptions\CanNotSaveModelException;
use App\Exceptions\InvalidTypeException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class LinkService
{
    private ?Link $link;

    public function linkTypes(): array {
        return [
            'movie',
            'image',
        ];
    }

    public function setLinkType(string $type) {
        if ($this->link instanceof Link) {
            foreach ($this->linkTypes() as $linkType) {
                if ($type === $linkType) {
                    $this->link->type = $linkType;
                    return;
                }
            }
            throw new InvalidTypeException('link type: ' . $type . ' is invalid');
        }
        throw new ModelNotFoundException('can not find link model');
    }

    public function setLinkAddress(string $address): void {
        if ($this->link instanceof Link) {
            $this->link->address = $address;
            return;
        }
        throw new ModelNotFoundException('can not find link model');
    }

    public function setLinkExtension(string $extension): void {
        if ($this->link instanceof Link) {
            $this->link->extension = $extension;
            return;
        }
        throw new ModelNotFoundException('can not find link model');
    }

    public function setLinkQuality(string $quality): void {
        if ($this->link instanceof Link) {
            $this->link->quality = $quality;
            return;
        }
        throw new ModelNotFoundException('can not find link model');
    }

    public function setLink(Link $link): void {
        $this->link = $link;
    }

    public function saveLink() {
        if ($this->link instanceof Link) {
            try {
                $this->link->saveOrFail();
                return;
            } catch (\Exception|\Throwable $exception) {
                throw new CanNotSaveModelException('link model can not be saved. attributes: ' .
                    implode($this->link->getAttributes()));
            }
        }
        throw new ModelNotFoundException('can not find link model');
    }

    public function fetchOrCreateLink(): Link {
        if ($this->link instanceof Link) {
            return $this->link;
        }
        return (new Link());
    }

}
