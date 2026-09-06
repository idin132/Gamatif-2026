<?php

namespace App\Filament\Resources\DataMahasiswaResource\Pages;

use Filament\Actions;
use App\Models\Kelompok;
use App\Models\DataMahasiswa;
use Livewire\WithFileUploads;
use GuzzleHttp\Promise\Create;
use Filament\Actions\CreateAction;
use Illuminate\Contracts\View\View;
use App\Imports\DataMahasiswaImport;
use Maatwebsite\Excel\Facades\Excel;
use Filament\Forms\Components\FileUpload;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\DataMahasiswaResource;
// use app\Models\
use Filament\Notifications\Notification;
class ListDataMahasiswas extends ListRecords
{
    use WithFileUploads; // penting biar wire:model file bisa jalan

    protected static string $resource = DataMahasiswaResource::class;

    public $file;

    protected function getHeaderActions(): array
{
    return [
        Actions\CreateAction::make(),

         Actions\Action::make('import')
            ->label('Import Data')
            ->modalHeading('Upload File')
            ->form([
                \Filament\Forms\Components\FileUpload::make('file')
                    ->label('Pilih Berkas')
                    ->required()
                    ->acceptedFileTypes([
                        'text/csv',
                        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                        'application/vnd.ms-excel',
                    ]),
            ])
            ->action(function (array $data) {
                // FileUpload sudah otomatis simpan ke storage, $data['file'] = path string
                $path = storage_path('app/public/' . $data['file']);

                \Maatwebsite\Excel\Facades\Excel::import(
                    new \App\Imports\DataMahasiswaImport,
                    $path
                );

               Notification::make()
                ->title('Data berhasil diimport!')
                ->success()
                ->send();
                        }),
                ];
}

    public function save()
    {
        $this->validate([
            'file' => 'required|file|mimes:csv,xlsx,xls',
        ]);

        // Simpan file sementara
        $path = $this->file->store('imports');

        // Import menggunakan Excel
        Excel::import(new DataMahasiswaImport, storage_path('app/' . $path));

        // Reset file biar modal bisa dipakai lagi
        $this->reset('file');

        $this->notify('success', 'Data berhasil diimport!');
    }
}
