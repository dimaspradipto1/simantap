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
        Schema::create('verifikasis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('permohonan_id')->nullable()->constrained('permohonans')->onDelete('cascade');
            $table->string('no_registrasi')->index();
            $table->string('pemohon')->nullable();
            $table->string('jenis_permohonan')->nullable();
            $table->string('status_verifikasi')->default('Menunggu');
            $table->string('waktu_menunggu')->nullable();
            $table->string('ditugaskan')->nullable();

            // 6 Checklist items
            $table->boolean('check_sppt')->default(false);
            $table->boolean('check_skpt')->default(false);
            $table->boolean('check_pl')->default(false);
            $table->boolean('check_sp')->default(false);
            $table->boolean('check_skpl_sppl_lama')->default(false);
            $table->boolean('check_pl_lama')->default(false);

            $table->text('keterangan')->nullable();
            $table->string('bukti_tanda_terima')->nullable();

            $table->foreignId('verified_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('verified_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('verifikasis');
    }
};
