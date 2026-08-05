<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('import_data', function (Blueprint $table) {
            $table->id();
            $table->string('batch_id')->nullable();
            $table->string('no_registrasi')->index();
            $table->string('surat_permohonan')->nullable();
            $table->string('jenis');
            $table->string('pemohon');
            $table->string('pembeli')->nullable();
            $table->string('status')->default('Diproses');
            $table->date('tgl_surat')->nullable();
            $table->string('nomor_pl')->nullable();
            $table->string('no_spj_ppt')->nullable();
            $table->string('no_skep_kpt')->nullable();
            $table->string('no_iph')->nullable();
            $table->string('no_rekom')->nullable();
            $table->text('alasan_pending')->nullable();
            $table->string('status_validasi')->default('Siap diimpor');
            $table->string('status_verifikasi')->default('Belum Diverifikasi');
            $table->string('file_name')->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('import_data');
    }
};
