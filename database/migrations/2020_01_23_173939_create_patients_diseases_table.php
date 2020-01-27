<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientsDiseasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patients_diseases', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('diseases_id');
            $table->foreign('diseases_id')->references('id')->on('diseases');
            $table->enum('kinship_degree',[
                'Grandparents', 'Mother', 'Father','Grandchild', 
                'Son','Sister','Broher', 'Wife','Husband','Girlfriend',
                'Boyfriend','Other'])->nullable();
            $table->unsignedBigInteger('patient_id');
            $table->foreign('patient_id')->references('id')->on('patients');
            $table->unsignedBigInteger('handbooks_id');
            $table->foreign('handbooks_id')->references('id')->on('handbooks');
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
        Schema::dropIfExists('patients_diseases');
    }
}
