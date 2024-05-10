<?php

namespace App\Filament\Resources;

use App\Enums\HttpMethods;
use App\Filament\Resources\WebhookResource\Pages;
use App\Filament\Resources\WebhookResource\RelationManagers;
use App\Models\Webhook;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class WebhookResource extends Resource
{

    protected static ?string $model = Webhook::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-up-right';

    public static function form(Form $form): Form
    {
        return $form
            ->columns(6)
            ->schema([
                Forms\Components\Select::make('campaign_id')
                    ->relationship('campaign', 'title')
                    ->columnSpan(2),
                Forms\Components\TextInput::make('name')
                    ->columnSpan(2),
                Forms\Components\TextInput::make('url')
                    ->columnSpan(2)
                    ->url()
                    ->placeholder('https://example.com/webhook')
                    ->required(),
                Forms\Components\Select::make('method')
                    ->options(HttpMethods::class)
                    ->columnSpan(2)
                    ->required(),
                Forms\Components\TextInput::make('bearer_token')
                    ->columnSpan(2),
                Forms\Components\Toggle::make('is_Active')
                    ->inline(false)
                    ->columnSpan(2),
                Forms\Components\Textarea::make('headers')
                    ->columnSpanFull()
                    ->json(),
                Forms\Components\Textarea::make('payload')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // only name, method, campaign
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('method')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('campaign.title')
                    ->searchable()
                    ->sortable(),

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
            'index' => Pages\ListWebhooks::route('/'),
            'create' => Pages\CreateWebhook::route('/create'),
            'edit' => Pages\EditWebhook::route('/{record}/edit'),
        ];
    }
}
