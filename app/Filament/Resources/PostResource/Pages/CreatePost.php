<?php

namespace App\Filament\Resources\PostResource\Pages;

use App\Filament\Resources\PostResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Unusualdope\FilamentModelTranslatable\Filament\Resources\Pages\FmtCreateRecord;

class CreatePost extends FmtCreateRecord
{
    protected static string $resource = PostResource::class;
}
