<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmployeeResource\Pages;
use App\Filament\Resources\EmployeeResource\RelationManagers;
use App\Models\Employee;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use Filament\Forms\Components\Section;

//using select
use Filament\Forms\Components\Select;

use Illuminate\Support\Collection;
use Filament\Forms\Get;
use Filament\Forms\Set;

use App\Models\State;
use App\Models\City;

class EmployeeResource extends Resource
{
    protected static ?string $model = Employee::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('User Name')
                ->description('Input User name Details ')
                ->schema([
                    Forms\Components\TextInput::make('first_name')
                    ->required()
                    ->maxLength(255),
                    Forms\Components\TextInput::make('last_name')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('middle_name')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('phone')
                        ->tel()
                        ->required()
                        ->maxLength(255),
                ])->columns(3),
                Section::make('User Address')
                ->description('Input User Address Details ')
                ->schema([
                    Select::make('country_id')
                    ->relationship(name: 'country',titleAttribute: 'name')
                    ->required()
                    ->searchable()
                    ->preload()
                    // ->multiple()
                    ->live()
                    ->afterStateUpdated(function (Set $set) {
                        $set('state_id', null);
                        $set('city_id', null);
                        }
                    )
                    ->native(true),
                
                    Select::make('state_id')
                    ->options(fn(Get $get):Collection=> State::query()
                        ->where('country_id', $get('country_id'))
                        ->pluck('name', 'id'))
                    ->required()
                    ->searchable()
                    ->afterStateUpdated(function (Set $set) {
                        $set('city_id', null);
                    })
                    ->preload()
                    ->live()
                    // ->multiple()
                    ->native(true),
                    Select::make('city_id')
                    ->options(fn(Get $get):Collection=> City::query()
                        ->where('state_id', $get('state_id'))
                        ->pluck('name', 'id'))
                    ->required()
                    ->searchable()
                    ->preload()
                    // ->multiple()
                    ->native(true),
                    Forms\Components\TextInput::make('address')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('zip_code')
                        ->required()
                        ->maxLength(255),

                ])->columns(2),
                
                
                Select::make('department_id')
                    ->relationship(name: 'department',titleAttribute: 'name')
                    ->required()
                    ->searchable()
                    ->preload()
                    // ->multiple()
                    ->native(true),
                Forms\Components\DatePicker::make('date_hired')
                    ->required(),
                Forms\Components\DatePicker::make('date_resigned'),
                Forms\Components\DatePicker::make('date_of_birth')
                    ->required()
                    ->columnSpanFull(),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('first_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('last_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('middle_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('address')
                    ->searchable(),
                Tables\Columns\TextColumn::make('zip_code')
                    ->searchable(),
                Tables\Columns\TextColumn::make('country_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('state_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('city_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('department_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('date_hired')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('date_resigned')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('date_of_birth')
                    ->date()
                    ->sortable(),
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
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListEmployees::route('/'),
            'create' => Pages\CreateEmployee::route('/create'),
            'view' => Pages\ViewEmployee::route('/{record}'),
            'edit' => Pages\EditEmployee::route('/{record}/edit'),
        ];
    }
}
