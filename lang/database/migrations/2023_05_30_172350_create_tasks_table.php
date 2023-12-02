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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->nullable()->constrained()->onDelete('cascade');
            $table->text('description');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->dateTime('date_taken')->nullable(); 
            $table->dateTime('date_completed')->nullable(); 
            $table->string('file_path')->nullable();
            $table->boolean('is_seen')->default(false);
            $table->timestamps();
            $table->unsignedSmallInteger('status')->default(0);
            // 0 => 'Available',
            //     1 => 'Ongoing',
            //     2 => 'Done',
            //     3 => 'Approved',
            //     4 => 'Rejected',
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
