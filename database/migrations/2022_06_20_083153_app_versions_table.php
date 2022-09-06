<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\AppVersion;


class AppVersionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_versions', function (Blueprint $table) {
            $table->id();
            $table->string('ios');
            $table->string('android');
            $table->boolean('forcefully');
            $table->timestamps();
        });
        $app_version = AppVersion::first();
        if(!isset($app_version)){
            $app_version = new AppVersion;
            $app_version->ios = '1.0.0';
            $app_version->android = '1.0.0';
            $app_version->forcefully = false;
            $app_version->save();
        }
            
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('app_versions');
    }
}
