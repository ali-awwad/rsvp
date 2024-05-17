<?php

namespace App\Filament\Resources;

use App\Enums\ImageMimeTypes;
use App\Enums\Status;
use App\Filament\Resources\CampaignResource\Pages;
use App\Filament\Resources\CampaignResource\RelationManagers;
use App\Models\Campaign;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CampaignResource extends Resource
{
    protected static ?string $model = Campaign::class;


    protected static ?string $navigationIcon = 'heroicon-o-calendar';

    public static function getNavigationBadge(): ?string
    {
        return Campaign::where('end_date', '>=', now())->count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Section::make('Campaign Information')
                    ->columns(6)
                    ->schema(self::campaignInformationSchema()),

                Section::make('Additional Information')
                    ->columns(3)
                    ->collapsed()
                    ->schema(self::additionalInformationSchema()),
                Section::make('Media')
                    ->columns(2)
                    ->collapsed()
                    ->schema(self::mediaSchema()),


            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                SpatieMediaLibraryImageColumn::make('logo')
                    ->collection('logo')
                    ->conversion('thumb'),
                // link to campaign using uuid as icon eye withot text
                Tables\Columns\TextColumn::make('id')
                    ->icon('heroicon-o-eye')

                    ->url(fn (Campaign $record) => route('campaigns.show', $record)),
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
                Tables\Columns\TextColumn::make('publish_date')
                    ->dateTime('Y-m-d H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
                            ->options([
                                Status::DRAFT->value => 'Draft',
                                // Status::SCHEDULED->value => 'Scheduled',
                                Status::PUBLISHED->value => 'Published',
                                // Status::COMPLETED->value => 'Completed',
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
            RelationManagers\WebhooksRelationManager::class,

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

    protected static function campaignInformationSchema(): array
    {
        return [
            Forms\Components\TextInput::make('title')
                ->columnSpan(2)
                ->required(),
            // id
            Forms\Components\TextInput::make('uuid')
                ->columnSpan(2)
                ->disabled()
                ->required(),
            Forms\Components\Radio::make('status')
                ->options(Status::class)
                ->columns(3)
                ->default(Status::DRAFT)
                ->columnSpan(2)
                ->required(),
            Forms\Components\DateTimePicker::make('publish_date')
                ->afterOrEqual(fn (?Campaign $campaign) => $campaign->exists ? '' : 'now')
                ->columnSpan(2)
                ->required(),
            Forms\Components\DateTimePicker::make('start_date')
                ->afterOrEqual(fn (?Campaign $campaign) => $campaign->exists ? '' : 'now')
                ->columnSpan(2)
                ->required(),
            Forms\Components\DateTimePicker::make('end_date')
                ->rule('after_or_equal:start_date')
                ->afterOrEqual(fn (?Campaign $campaign) => $campaign->exists ? '' : 'start_date')
                ->columnSpan(2)
                ->required(),
        ];
    }

    protected static function additionalInformationSchema(): array
    {
        return [
            Forms\Components\TextInput::make('location'),
            Forms\Components\TextInput::make('parking'),
            Forms\Components\TextInput::make('parking_link')
                ->placeholder('https://'),
            Forms\Components\RichEditor::make('description')
                ->columnSpanFull(),
            Forms\Components\TextInput::make('terms_link')
                ->placeholder('https://'),
            Forms\Components\TextInput::make('data_policy_link')
                ->placeholder('https://'),
            Forms\Components\TextInput::make('cookies_policy_link')
                ->placeholder('https://'),
        ];
    }

    protected static function mediaSchema(): array
    {
        return [
            SpatieMediaLibraryFileUpload::make('background')
                ->collection('background')
                ->conversion('thumb')
                ->rules('image')
                ->acceptedFileTypes(ImageMimeTypes::values()),

            SpatieMediaLibraryFileUpload::make('Logo')
                ->collection('logo')
                ->conversion('thumb')
                ->acceptedFileTypes(ImageMimeTypes::values())
                ->rules('image'),

            SpatieMediaLibraryFileUpload::make('Sponsors')
                ->multiple()
                ->acceptedFileTypes(ImageMimeTypes::values())
                ->conversion('thumb')
                ->panelLayout('grid')

                ->collection('sponsors')
                ->rules('image')
                ->columnSpanFull(),
        ];
    }
}
