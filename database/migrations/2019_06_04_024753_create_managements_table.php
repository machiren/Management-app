<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateManagementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('managements', function (Blueprint $table) {
            
            // ID
            $table->bigIncrements('id');
            // 20XX年XX月XX日
            $table->date('date');
            // 何日
            $table->integer('day');
            // 何曜日
            $table->string('weekday');
            // 名前
            $table->string('name');
            // 社員ナンバー
            $table->integer('employee_number');
            // 始業時間
            $table->time('opening_time');
            // 終了時間
            $table->time('ending_time');
            // 休憩時間
            $table->time('break_time');
            // 実働時間
            $table->time('total_time');
            // 超過分の時間
            $table->time('over_time');
            // 有給
            $table->integer('paid_leave');
            // 欠勤
            $table->integer('absence'); 
            // 遅刻
            $table->integer('late');
            // 早退
            $table->integer('leave_early');
            // 休日出勤
            $table->integer('holiday_work');
            // 振替休日
            $table->integer('makeup_holiday');
            // プロジェクト名
            $table->text('poject');
            // 備考欄
            $table->text('memo');
            // 外部キー(複数のユーザーがマネジメントを持つ)
            $table->integer('user_id'); 
            // 作成日・更新日 (自動)
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
        Schema::dropIfExists('managements');
    }
}
