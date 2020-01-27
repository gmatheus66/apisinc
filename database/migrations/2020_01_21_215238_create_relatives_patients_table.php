<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRelativesPatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('relatives_patients', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('kinship_degree',[
                'Grandparents', 'Mother', 'Father','Grandchild',
                 'Son','Sister','Broher', 'Wife','Husband',
                 'Girlfriend','Boyfriend','Other']);
            $table->unsignedBigInteger('relative_id');
            $table->foreign('relative_id')->references('id')->on('relatives');
            $table->unsignedBigInteger('patient_id');
            $table->foreign('patient_id')->references('id')->on('patients');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('relatives_patients');
    }
}
