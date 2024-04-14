<?php

namespace App\Filament\Resources;

use App\Enums\Status;
use App\Filament\Resources\CampaignResource\Pages;
use App\Filament\Resources\CampaignResource\RelationManagers;
use App\Models\Campaign;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CampaignResource extends Resource
{
    protected static ?string $model = Campaign::class;


    protected static ?string $navigationIcon = 'heroicon-o-calendar';

    public static function getNavigationBadge(): ?string
    {
        return Campaign::where('end_date','>=',now())->count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Campaign Information')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Title')
                            // ->columnSpanFull()
                            ->required(),
                        // get status from enum
                        Forms\Components\Select::make('status')
                            ->options(Status::class)
                            ->required(),
                        Forms\Components\DateTimePicker::make('start_date')
                            ->label('Start Date')
                            ->afterOrEqual('now')
                            ->columns(1)
                            ->required(),
                        Forms\Components\DateTimePicker::make('end_date')
                            ->label('End Date')
                            ->after('start_date')
                            ->columns(1)
                            ->required(),
                    ]),

                Forms\Components\Section::make('Additional Information')
                    ->columns(3)
                    ->collapsed()
                    ->collapsible()
                    ->schema([
                        Forms\Components\TextInput::make('location')
                            ->label('Location'),
                        Forms\Components\TextInput::make('parking'),
                        Forms\Components\TextInput::make('parking_link')
                            ->placeholder('https://'),
                        Forms\Components\RichEditor::make('description')
                            ->columnSpanFull(),
                    ]),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->sortable(),
                // count contacts relation belongstomany
                Tables\Columns\TextColumn::make('contacts_count')
                    ->label('Contacts')
                    ->counts('contacts')
                    ->sortable(),
                Tables\Columns\TextColumn::make('start_date')
                    ->dateTime('Y-m-d H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('end_date')
                    ->dateTime('Y-m-d H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options(Status::class)
                    ->multiple(),
                Tables\Filters\Filter::make('start_date')
                    ->form([
                        Forms\Components\DatePicker::make('start_date'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['start_date'],
                                fn (Builder $query, $date): Builder => $query->whereDate('start_date', '>=', $date),
                            );
                    }),
                Tables\Filters\Filter::make('end_date')
                    ->form([
                        Forms\Components\DatePicker::make('end_date'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['end_date'],
                                fn (Builder $query, $date): Builder => $query->whereDate('end_date', '<=', $date),
                            );
                    })
            ], layout: Tables\Enums\FiltersLayout::AboveContentCollapsible)
            ->actions([
                // Tables\Actions\ActionGroup::make([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('Set Status')
                    ->icon('heroicon-o-arrows-right-left')
                    ->color('warning')
                    ->modal('setStatus')
                    ->requiresConfirmation()
                    ->fillForm(
                        fn (Campaign $record) => [
                            'status' => $record->status,
                        ],
                    )
                    ->form([
                        Forms\Components\Radio::make('status')
                            ->label('Status')
                            ->options([
                                Status::DRAFT->value => 'Draft',
                                // Status::SCHEDULED->value => 'Scheduled',
                                Status::PUBLISHED->value => 'Published',
                                Status::COMPLETED->value => 'Completed',
                                Status::CANCELLED->value => 'Cancelled',

                            ])
                            ->required(),
                    ])
                    ->action(fn (Campaign $record, array $data) => $record->update($data)),

                // ])
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
            RelationManagers\ContactsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCampaigns::route('/'),
            'create' => Pages\CreateCampaign::route('/create'),
            'edit' => Pages\EditCampaign::route('/{record}/edit'),
        ];
    }
}
