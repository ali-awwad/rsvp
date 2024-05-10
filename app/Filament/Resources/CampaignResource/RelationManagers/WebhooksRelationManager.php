<?php

namespace App\Filament\Resources\CampaignResource\RelationManagers;

use App\Enums\HttpMethods;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class WebhooksRelationManager extends RelationManager
{
    protected static string $relationship = 'webhooks';

    public function form(Form $form): Form
    {
        return $form
        ->columns(6)
            ->schema([

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
                ->label('Payload (JSON) - Additonal data to send with the webhook')
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
