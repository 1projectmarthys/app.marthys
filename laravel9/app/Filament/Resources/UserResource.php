<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $navigationIcon = 'heroicon-o-user';
    protected static ?string $navigationLabel = 'User';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                Forms\Components\Card::make()->schema([
                    Forms\Components\TextInput::make('name')
                        ->required()
                        ->maxLength(255)
                        ->label('Nama'),
                    
                    Forms\Components\TextInput::make('email')
                        ->email()
                        ->required()
                        ->unique(ignorable: fn ($record) => $record)
                        ->maxLength(255),
                    
                    Forms\Components\TextInput::make('password')
                        ->password()
                        ->required(fn (string $context): bool => $context === 'create')
                        ->minLength(8)
                        ->dehydrateStateUsing(fn ($state) => Hash::make($state)),
                    
                    Forms\Components\Toggle::make('is_active')
                        ->required()
                        ->default(true)
                        ->label('Status Aktif'),
                    Forms\Components\Select::make('role')
                        ->options([
                            'admin' => 'Admin',
                            'accounting' => 'Accounting',
                            'purchasing' => 'Purchasing',
                            'hrd' => 'HRD',
                            'user' => 'Regular User',
                            'legal' => 'Legalitas',
                        ])
                        ->default('user')
                        ->required(),
                  
                ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\BadgeColumn::make('is_active')
                    ->label('Status')
                    ->sortable()
                    ->colors([
                        'danger' => false,
                        'success' => true,
                    ])
                    ->enum([
                        false => 'Non-Aktif',
                        true => 'Aktif',
                    ]),
                
                Tables\Columns\BadgeColumn::make('role')
                    ->colors([
                        'primary' => 'user',
                        'success' => 'admin',
                        'warning' => 'accounting',
                        'danger' => 'purchasing',
                        'info' => 'hrd',
                    ])
                    ->sortable(),
                
               
            ])
            ->filters([
                //
                Tables\Filters\Filter::make('active')
                ->label('Active Only')
                ->query(fn ($query) => $query->where('is_active', true)),
            
                Tables\Filters\Filter::make('inactive')
                    ->label('Inactive Only')
                    ->query(fn ($query) => $query->where('is_active', false)),
                Tables\Filters\SelectFilter::make('role')
                    ->options([
                        'admin' => 'Admin',
                        'accounting' => 'Accounting',
                        'purchasing' => 'Purchasing',
                        'hrd' => 'HRD',
                        'user' => 'Regular User',
                        'legal' => 'Legalitas',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                   
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }    
}
