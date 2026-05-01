<?php

namespace App\Filament\Resources\Tags\Pages;

use App\Filament\Resources\Tags\TagsResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditTags extends EditRecord
{
    protected static string $resource = TagsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function getRedirecUrl(): string
    {
        return $this->getResource()::getUrl('index');   
    }
}
