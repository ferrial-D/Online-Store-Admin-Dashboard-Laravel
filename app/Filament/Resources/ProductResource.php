<?php

namespace App\Filament\Resources;
use App\Models\category;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms;

use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Set;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\str;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()->schema([
                   Section::make('Product information')->schema([
                    TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(function ($state, callable $set, callable $get) {
                        // Safely set the 'slug' attribute
                        if (!$get('record.id')) {
                            $set('slug', Str::slug($state)); // Here we correctly pass both attribute and value
                        }
                    }),
                
                


                    TextInput::make('slug')
                    ->required()
                    ->maxLength(255)
                    ->disabled()
                    ->dehydrated()
                    ->unique(Product::class, 'slug', ignoreRecord:true),

                    MarkdownEditor::make('description')
                    ->columnSpanFull()
                    ->fileAttachmentsDirectory('products')
                   ])->columns(2),

                   Section::make('Images')->schema([
                    FileUpload::make('image')
                    ->multiple()
                    ->directory('products')
                    ->maxFiles(5)
                    ->reorderable()
                   ])
                ])->columnSpan(2),

                Group::make()->schema([
                    Section::make('Price')->schema([
                        TextInput::make('price')
                        ->required()
                        ->numeric()
                        ->prefix('INR')
                    ]),

                    Section::make('Associations')->schema([
                        Select::make('category_id')
                        ->required()
                        ->searchable()
                        ->preload()
                        ->relationship('category', 'name'),
                        
                        Select::make('brand_id')
                        ->required()
                        ->searchable()
                        ->preload()
                        ->relationship('brand', 'name'),
                   
                    ]),

                    Section::make('Status')->schema([
                        Toggle::make('in_stock')
                        ->required()
                        ->default(true),

                        Toggle::make('is_active')
                        ->required()
                        ->default(true),

                        Toggle::make('is_featered')
                        ->required(),
                        

                        Toggle::make('on_sale')
                        ->required()
                        

                    ])

                ])->columnSpan(1)



            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                
                    Tables\Columns\TextColumn::make('category.name')
                    ->sortable(),
                
                    Tables\Columns\TextColumn::make('brand.name')
                    ->sortable(),

                    Tables\Columns\TextColumn::make('price')
                    ->money('INR')
                    ->sortable(),
                
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
                Tables\Columns\IconColumn::make('is_featured')
                    ->boolean(),
                Tables\Columns\IconColumn::make('in_stock')
                    ->boolean(),
                Tables\Columns\IconColumn::make('on_sale')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('category')
                ->relationship('category', 'name'),
                
                SelectFilter::make('brand')
                ->relationship('brand', 'name'),


            ])
            ->actions([
                ActionGroup::make([
                  ViewAction::make(),
                  EditAction::make(),
                  DeleteAction::make(),

                ])
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
