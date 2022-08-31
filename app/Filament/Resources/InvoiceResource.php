<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Invoice;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Support\Actions\Action;
use Filament\Tables\Actions\BulkAction;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\InvoiceResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use App\Filament\Resources\InvoiceResource\RelationManagers;

class InvoiceResource extends Resource
{
    protected static ?string $model = Invoice::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $navigationGroup = 'Menu';

    protected static ?string $recordTitleAttribute = 'reference';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Forms\Components\Select::make('player_id')->relationship('players', 'name'),
            Forms\Components\Select::make('status')
            ->options([
                'Pending' => 'Pending',
                'Paid' => 'Paid',
                'Cancelled' => 'Cancelled'
            ])->required(),
            Forms\Components\TextInput::make('amount')->rules('required', 'numeric')->label('Amount'),
            Forms\Components\DatePicker::make('from')->required()->format('y-m-d')->label('From'),
            Forms\Components\DatePicker::make('to')->required()->format('y-m-d')->label('To'),

            Forms\Components\TextInput::make('reference')->default(function () {
                return 'INV-' . str_pad(Invoice::count() + 1, 6, '0', STR_PAD_LEFT);
            })->label('Reference'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('reference')->label('Reference'),
                Tables\Columns\TextColumn::make('players.name')->label('Player'),
                Tables\Columns\BadgeColumn::make('status')
                ->icons([
                    'heroicon-o-x',
                    'heroicon-o-loading' => 'Pending',
                    'heroicon-o-check' => 'Paid',
                    'heroicon-o-x' => 'Cancelled'
                ]),
                Tables\Columns\TextColumn::make('amount')->label('Amount'),
                Tables\Columns\TextColumn::make('from')->label('From'),
                Tables\Columns\TextColumn::make('to')->label('To'),
            ])
            ->filters([
                Tables\Filters\Filter::make('reference')->label('Reference'),
                Tables\Filters\Filter::make('players.name')->label('Player'),
                Tables\Filters\Filter::make('status')->label('Status'),
                Tables\Filters\Filter::make('amount')->label('Amount'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('pdf')
                ->url(fn (Invoice $record): string => route('invoice.pdf', $record->id))
                ->openUrlInNewTab()
                ->icon('far-file-pdf')
                ->label('PDF'),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                ExportBulkAction::make(),
               /*  BulkAction::make('pdf')
                ->url(fn (Invoice $record): string => route('invoice.pdf', $record->id))
                ->openUrlInNewTab()
                ->icon('far-file-pdf')
                ->label('PDF'), */
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
            'index' => Pages\ListInvoices::route('/'),
            'create' => Pages\CreateInvoice::route('/create'),
            'edit' => Pages\EditInvoice::route('/{record}/edit'),
        ];
    }        
}
