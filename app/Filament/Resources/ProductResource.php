<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // This will automatically associate the product with the logged-in admin
                Forms\Components\Hidden::make('user_id')
                    ->default(auth()->id()),

                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),

                Forms\Components\RichEditor::make('description')
                    ->required()
                    ->columnSpanFull(),

                Forms\Components\TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->prefix('RM'),

                Forms\Components\Select::make('category_id')
                    ->relationship('category', 'name')
                    ->required(),

                Forms\Components\Select::make('condition')
                    ->options([
                        'New' => 'New',
                        'Like New' => 'Like New',
                        'Very Good' => 'Very Good',
                        'Good' => 'Good',
                        'Fair' => 'Fair',
                    ])
                    ->required(),

                Forms\Components\Select::make('status')
                    ->options([
                        'active' => 'Active',
                        'inactive' => 'Inactive',
                        'sold' => 'Sold',
                    ])
                    ->default('active')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('images.0.image_path')
                    ->label('Image')
                    ->disk('public'),
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Seller')
                    ->sortable(),
                Tables\Columns\TextColumn::make('price')
                    ->money('MYR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'active' => 'success',
                        'inactive' => 'warning',
                        'sold' => 'danger',
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
