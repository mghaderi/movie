<?php

namespace App\Domains\Media\Services;

use App\Domains\Media\Models\Link;
use App\Exceptions\CanNotDeleteModelException;
use App\Exceptions\CanNotSaveModelException;
use App\Exceptions\InvalidTypeException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class LinkService {

    public const TYPE_MOVIE = 'movie';
    public const TYPE_IMAGE = 'image';

    public ?Link $link = null;

    public function linkTypes(): array {
        return [
            self::TYPE_MOVIE => self::TYPE_MOVIE,
            self::TYPE_IMAGE => self::TYPE_IMAGE,
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

    public function setLinkData(string $address, string $extension, string $quality): void {
        if ($this->link instanceof Link) {
            $this->link->address = $address;
            $this->link->extension = $extension;
            $this->link->quality = $quality;
            return;
        }
        throw new ModelNotFoundException('can not find link model');
    }

    public function setLink(Link $link): void {
        $this->link = $link;
    }

    public function saveLink(): void {
        if ($this->link instanceof Link) {
            try {
                $this->link->saveOrFail();
                return;
            } catch (\Exception|\Throwable $exception) {
                throw new CanNotSaveModelException('link model can not be saved. attributes: ' .
                    implode(',', $this->link->getAttributes()));
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

    public function remove(Link $link): void {
        if (! empty($link->id)) {
            if (! $link->delete()) {
                throw new CanNotDeleteModelException(
                    'can not delete link model with id: ' . $link->id
                );
            }
            return;
        }
        throw new ModelNotFoundException('model link not found');
    }

}
