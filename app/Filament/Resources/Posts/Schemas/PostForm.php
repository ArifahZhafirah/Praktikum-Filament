<?php

namespace App\Filament\Resources\Posts\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DateTimePicker;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Group;

class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                // =====================
                // KIRI (2/3) - FIELDS
                // =====================
                Section::make('Post Details')
                    ->description('Isi data utama post')
                    ->icon('heroicon-o-document-text')
                    ->schema([

                        // 2 kolom untuk field utama
                        Group::make([
                            TextInput::make("title")
                                ->rules('min:5')
                                ->validationMessages([ 'required' => 'Title wajib diisi',
                                'min' => 'Title minimal 5 karakter',
                                ]),

                            TextInput::make("slug")
                                ->required()
                                ->rules('min:3')
                                ->unique(ignoreRecord: true)
                                ->validationMessages(['required' => 'Slug wajib diisi',
                                'min' => 'Slug minimal 3 karakter',
                                'unique' => 'Slug tidak boleh sama',
                                ]),

                            Select::make('category_id')
                                ->relationship('category', 'name')                       
                                ->required()
                                ->validationMessages(['required' => 'Category wajib dipilih',
                                ])
                                ->preload()
                                ->searchable(),

                            ColorPicker::make('color'),
                        ])->columns(2),

                        // full width untuk content
                        MarkdownEditor::make('content')
                            ->columnSpanFull(),

                    ])
                    ->columnSpan(2),

                // =====================
                // KANAN (1/3)
                // =====================
                Group::make([

                    // Section Image
                    Section::make('Image Upload')
                        ->schema([
                            FileUpload::make('image')
                                ->required()
                                ->validationMessages([ 'required' => 'Image wajib diupload',
                                ])
                                ->disk("public")
                                ->directory("posts"),
                        ]),

                    // Section Meta
                    Section::make('Meta Information')
                        ->icon('heroicon-o-information-circle')
                        ->schema([
                            TagsInput::make('tags'),
                            Checkbox::make('published'),
                            DateTimePicker::make('published_at'),
                        ]),

                ])->columnSpan(1),

            ])
            ->columns(3); // total grid 3 (2/3 + 1/3)
    }
}


// RichEditor::make("content"),
                // FileUpload::make("image")
                //     ->disk("public")
                //     ->directory("posts"),
                // TagsInput::make("tags"),
                // Checkbox::make("published"),
                // DateTimePicker::make("published_at"),
