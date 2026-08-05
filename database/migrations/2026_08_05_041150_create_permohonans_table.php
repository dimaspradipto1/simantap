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
        Schema::create('permohonans', function (Blueprint $table) {
            $table->id();
            $table->string('no_registrasi')->unique();
            $table->string('pemohon');
            $table->string('jenis_permohonan');
            $table->string('surat_permohonan')->nullable();
            $table->string('nomor_pl')->nullable();
            $table->string('no_spj_ppt')->nullable();
            $table->string('no_rekom')->nullable();
            $table->string('no_skep_kpt')->nullable();
            $table->string('no_iph')->nullable();
            $table->string('pembeli')->nullable()->default('-');
            $table->date('tanggal_surat')->nullable();
            $table->string('status_proses')->default('Diproses');
            $table->string('status_verifikasi')->default('Menunggu');
            $table->string('waktu_menunggu')->nullable();
            $table->string('ditugaskan')->nullable();
            $table->foreignId('assigned_to')->nullable()->constrained('users')->onDelete('set null');
            
            // Checklist 6 dokumen
            $table->boolean('check_sppt')->default(false);
            $table->boolean('check_sp')->default(false);
            $table->boolean('check_skpt')->default(false);
            $table->boolean('check_skpl_sppl_lama')->default(false);
            $table->boolean('check_pl')->default(false);
            $table->boolean('check_pl_lama')->default(false);

            $table->text('keterangan_petugas')->nullable();
            $table->string('file_tanda_terima')->nullable();
            $table->string('uploaded_by_name')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permohonans');
    }
};
