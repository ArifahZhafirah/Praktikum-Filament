<?php

namespace App\Filament\Resources\Tags\Pages;

use App\Filament\Resources\Tags\TagsResource;
use Filament\Resources\Pages\CreateRecord;

class CreateTags extends CreateRecord
{
    protected static string $resource = TagsResource::class;

    protected function getRedirecUrl(): string
    {
    return $this->getResource()::getUrl('index');    
    }
}
