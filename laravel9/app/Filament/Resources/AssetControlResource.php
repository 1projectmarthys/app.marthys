<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AssetControlResource\Pages;
use App\Filament\Resources\AssetControlResource\RelationManagers;
use App\Models\AssetControl;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AssetControlResource extends Resource
{
    protected static ?string $model = AssetControl::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';
    protected static ?string $navigationGroup = 'IT';
protected static ?string $navigationLabel = 'Asset Control';
protected static ?int $navigationSort = 1;
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListAssetControls::route('/'),
            'create' => Pages\CreateAssetControl::route('/create'),
            'edit' => Pages\EditAssetControl::route('/{record}/edit'),
        ];
    }    
}
