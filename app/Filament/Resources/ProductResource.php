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

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Forms\Components\TextInput::make('code')
                ->required()
                ->label('Product Code')
                ->unique()
                ->maxLength(50),
            Forms\Components\TextInput::make('name')
                ->required()
                ->label('Product Name')
                ->maxLength(250),
            Forms\Components\TextInput::make('quantity')
                ->required()
                ->numeric()
                ->label('Quantity')
                ->minValue(1)
                ->maxValue(10000),
            Forms\Components\TextInput::make('price')
                ->required()
                ->numeric()
                ->label('Price')
                ->prefix('$'),
            Forms\Components\Textarea::make('description')
                ->label('Description')
                ->maxLength(1000)
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            Tables\Columns\TextColumn::make('code')->label('Code')->sortable(),
            Tables\Columns\TextColumn::make('name')->label('Name')->sortable()->searchable(),
            Tables\Columns\TextColumn::make('quantity')->label('Quantity')->sortable(),
            Tables\Columns\TextColumn::make('price')->label('Price')->money('USD')->sortable(),
            Tables\Columns\TextColumn::make('description')->label('Description')->limit(50),
            Tables\Columns\TextColumn::make('created_at')->label('Created At')->date(),
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
