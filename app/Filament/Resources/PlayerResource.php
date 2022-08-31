<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Club;
use Filament\Tables;
use App\Models\Player;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\PlayerResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PlayerResource\RelationManagers;

class PlayerResource extends Resource
{
    protected static ?string $model = Player::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $navigationGroup = 'Menu';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')->required(),
                Forms\Components\Select::make('club_id')->relationship('clubs', 'name'),
                Forms\Components\TextInput::make('email')->required(),
                Forms\Components\TextInput::make('phone')->required(),
                Forms\Components\TextInput::make('address')->required(),
                Forms\Components\Select::make('gender')
                ->options([
                    'Male' => 'Male',
                    'Female' => 'Female'
                ])->required(),
                Forms\Components\FileUpload::make('photo')->required()->label('Photo'),
                Forms\Components\DatePicker::make('dob')->required()->format('y-m-d')->label('Date of Birth'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('photo')->rounded(),
                Tables\Columns\TextColumn::make('name')->sortable(),
                Tables\Columns\TextColumn::make('clubs.name')->sortable()->label('Club'),
                Tables\Columns\TextColumn::make('email')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('phone')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('address')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('gender')->sortable()->searchable(),
            ])
            ->filters([
                SelectFilter::make('clubs')->relationship('clubs', 'name')
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
            RelationManagers\ClubsRelationManager::class,
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPlayers::route('/'),
            'create' => Pages\CreatePlayer::route('/create'),
            'edit' => Pages\EditPlayer::route('/{record}/edit'),
        ];
    }    
}
